<?php

namespace App\Http\Controllers\Api\V2;

use JWTAuth;
use Validator;
use App\Models\Tag;
use App\Models\User;
use App\Models\Level;
use App\Models\UserTag;
use App\Models\UserBlock;
use App\Models\SearchUser;
use App\Models\UserProfile;
use App\Models\LevelDetail;
use App\Models\UserRequest;
use App\Helper\BaseFunction;
use App\Models\UserFollower;
use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Models\EventParticipant;
use App\Models\UserFavourite;
use App\Models\LiveStreamUser;
use App\Models\UserLevelDetail;
use App\Models\UserSpendGemsDetail;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;


class UserController extends Controller
{

    // profile update
    public function updateProfile(Request $request)
    {
        $app = $request->header('Flag');
        $user = JWTAuth::parseToken()->authenticate();
        // $data=compact('user');
        $validate = Validator::make($request->all(), [
            'username' => 'required|string|between:2,100|unique:users,username,' . $user->id,
        ]);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => '0', 'ResponseText' => $validate->errors()->all()[0], 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
        }

        $userdata['username'] = $request->username;
        if (isset($request->phone) && $request->phone == "null" && $request->phone == null) {
            $validate = Validator::make($request->all(), [
                'phone' => 'required|string|between:2,100|unique:users,phone,' . $user->id,
            ]);
            if ($validate->fails()) {
                return response()->json(['ResponseCode' => '0', 'ResponseText' => $validate->errors()->all()[0], 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
            }
            $userdata['phone'] = $request->phone;
        }
        if (isset($request->address)) {
            $userdata['address'] = $request->address;
        }
        if (isset($request->gender)) {
            $userdata['gender'] = $request->gender;
        }

        $userdata['county_code'] = (isset($request->county_code)) ? $request->county_code : '';
        $userdata['description'] = ($request->description) ? $request->description : '';

        // image uploads
        if ($request->user_profile_id != "") {
            $profile_id = explode(',', $request->user_profile_id);
            foreach ($profile_id as $val) {
                $file = mb_convert_encoding($request['user_profiles' . $val], 'UTF-8', 'UTF-8');
                $folderName = 'public/uploads/users/';
                $safeName = "profile_" . uniqid() . '.' . 'png';
                $destinationPath = storage_path('/app/public/uploads/users');
                $success = file_put_contents(storage_path('/app/public/uploads/users') . '/' . $safeName, base64_decode($file));
                $data = new UserProfile;
                $data->image = $safeName;
                $data->user_id = $user->id;
                $data->save();
            }
            if (isset($request->primary_profile) && $request->primary_profile != "0") {
                $userprofiledefualt = UserProfile::where('user_id', $user->id)->get();
                $userprofile = User::where('id', $user->id)->first();
                if (isset($userprofiledefualt[$request->primary_profile - 1]) && $userprofiledefualt[$request->primary_profile - 1] != "") {
                    $userdata['profile_pic'] = $userprofiledefualt[$request->primary_profile - 1]->image;
                    $data = new UserProfile;
                    $data->id = $userprofiledefualt[$request->primary_profile - 1]->id;
                    $data->exists = true;
                    $data->image = $userprofile->profile_pic;
                    $data->save();
                }
            }
        } else {
            if (isset($request->primary_profile) && $request->primary_profile != "0") {
                $userprofiledefualt = UserProfile::where('user_id', $user->id)->get();
                $userprofile = User::where('id', $user->id)->first();
                if (isset($userprofiledefualt[$request->primary_profile - 1]) && $userprofiledefualt[$request->primary_profile - 1] != "") {
                    $userdata['profile_pic'] = $userprofiledefualt[$request->primary_profile - 1]->image;
                    $data = new UserProfile;
                    $data->id = $userprofiledefualt[$request->primary_profile - 1]->id;
                    $data->exists = true;
                    $data->image = $userprofile->profile_pic;
                    $data->save();
                }
            }
        }

        // profile_img
        // if(isset($request->profile_img)){           
        //     $file = mb_convert_encoding($request->profile_img, 'UTF-8', 'UTF-8');
        //     $folderName = 'public/uploads/users/';
        //     $safeName ="profile_".uniqid().'.'.'png';
        //     $destinationPath = storage_path('/app/public/uploads/users');
        //     $success = file_put_contents(storage_path('/app/public/uploads/users').'/'.$safeName, base64_decode($file));
        //     $userdata['profile_pic']=$safeName;
        // }

        // UserTag
        UserTag::where('user_id', $user->id)->delete();
        if ($request->tags != "") {
            $tagsdata = explode(',', $request->tags);
            foreach ($tagsdata as $value) {
                $usertag = new UserTag;
                $usertag->tag_id = $value;
                $usertag->user_id = $user->id;
                $usertag->save();
            }
        }

        User::where('id', $user->id)->update($userdata);
        $userdata = User::users()->where('id', $user->id)->select('users.*', \DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , " . "CONCAT('" . url('/storage/app/public/uploads/users/') . "/', users.profile_pic)) AS profile_pic"))->get()->first();

        $userdata->followers = UserFollower::where('to_id', $user->id)->count();
        $userdata->following = UserFollower::where('from_id', $user->id)->count();
        $userdata->favourite = UserFavourite::where('from_id', $user->id)->count();
        $userdata->total_gems = 0;
        $newprofile = array();
        $profiles = UserProfile::where('user_id', $user->id)->select('*', \DB::raw("IF(image LIKE '%https://%' , image , " . "CONCAT('" . url('/storage/app/public/uploads/users/') . "/', image)) AS image"))->get();
        $newprofile[0]['id'] = 0;
        $newprofile[0]['image'] = $userdata->profile_pic;
        foreach ($profiles as $key => $val) {
            $newprofile[$key + 1]['id'] = $val->id;
            $newprofile[$key + 1]['image'] = $val->image;
        }
        $userdata->profiles = $newprofile;
        $eventParticipant = EventParticipant::where('user_id',$user->id)->first();
        $userdata->is_event_rank = 0;
        if($eventParticipant !=''){
           if($eventParticipant->event_counts >= 50){
            $userdata->is_event_rank = 3;
            }else if($eventParticipant->event_counts >= 40 && $eventParticipant->event_counts < 50 ){
                $userdata->is_event_rank = 2;
            }else if($eventParticipant->event_counts >= 30 && $eventParticipant->event_counts < 40){
                $userdata->is_event_rank = 1;
            }else{
                 $userdata->is_event_rank = 0;
            } 
        }
        
        $tags = Tag::all();
        $usertags = UserTag::where('user_id', $user->id)->get();

        foreach ($tags as $value) {
            $value->is_tag = 0;
            foreach ($usertags as $val) {
                if ($val->tag_id == $value->id) {
                    $value->is_tag = 1;
                }
            }
            $value->image = "";
        }
        $userdata->tag = $tags;
        $userdata->level = Level::where('id', $userdata->level_id)->first();
        $userdata->level->level = (isset(explode('-', $userdata->level->slug)[1])) ? explode('-', $userdata->level->slug)[1] : 0;
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User profile update successfully', 'ResponseData' => $userdata], 200);
    }

    // profile
    public function profile()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 401);
            }

            $userdata = User::where('id', $user->id)->select('users.*', \DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , " . "CONCAT('" . url('/storage/app/public/uploads/users/') . "/', users.profile_pic)) AS profile_pic"))->first();
            $userdata->followers = UserFollower::where('to_id', $user->id)->count();
            $userdata->following = UserFollower::where('from_id', $user->id)->count();
            $userdata->favourite = UserFavourite::where('from_id', $user->id)->count();
            $userdata->level = Level::where('id', $userdata->level_id)->first();
            $userdata->level->level = (isset(explode('-', $userdata->level->slug)[1])) ? explode('-', $userdata->level->slug)[1] : 0;
            $tags = Tag::all();
            $usertags = UserTag::where('user_id', $user->id)->get();
            $profiles = UserProfile::where('user_id', $user->id)->select('*', \DB::raw("IF(image LIKE '%https://%' , image , " . "CONCAT('" . url('/storage/app/public/uploads/users/') . "/', image)) AS image"))->get();
            $newprofile[0]['id'] = 0;
            $newprofile[0]['image'] = $userdata->profile_pic;
            foreach ($profiles as $key => $val) {
                $newprofile[$key + 1]['id'] = $val->id;
                $newprofile[$key + 1]['image'] = $val->image;
            }
            $userdata->profiles = $newprofile;
            $eventParticipant = EventParticipant::where('user_id',$user->id)->first();
            $userdata->is_event_rank = 0;
            if($eventParticipant!=''){
                if($eventParticipant->event_counts >= 50){
                    $userdata->is_event_rank = 3;
                }else if($eventParticipant->event_counts >= 40 && $eventParticipant->event_counts < 50 ){
                    $userdata->is_event_rank = 2;
                }else if($eventParticipant->event_counts >= 30 && $eventParticipant->event_counts < 40){
                    $userdata->is_event_rank = 1;
                }else{
                     $userdata->is_event_rank = 0;
                }
            }

            foreach ($tags as $value) {
                $value->is_tag = 0;
                foreach ($usertags as $val) {
                    if ($val->tag_id == $value->id) {
                        $value->is_tag = 1;
                    }
                }
                $value->image = "";
            }
            $userdata->tag = $tags;
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User profile detail', 'ResponseData' => $userdata]);
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'token_expired']], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'token_invalid']], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'token_absent']], $e->getStatusCode());
        }
    }

    // user details
    public function userDetails(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
        }

        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
        }

        // $loginuser=compact('user');

        $data = User::users()->where('id', $request->user_id)->select('users.*', \DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , " . "CONCAT('" . url('/storage/app/public/uploads/users/') . "/', users.profile_pic)) AS profile_pic"))->first();

        // $url="http://bklive.stream:5080/WebRTCAppEE/rest/v2/broadcasts/".$data->stream_id."";
        // $response=BaseFunction::curlCallApi($url);
        if ($data == "") {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'User profile not found', 'ResponseData' => []], 200);
        }
        if ($request->user_id != $user->id) {
            if (isset($request->is_search) && $request->is_search == 1) {
                $isAlreadySearch = SearchUser::where('from_id', $user->id)->where('to_id', $data->id)->count();
                if ($isAlreadySearch == 0) {
                    $seachUser = new SearchUser;
                    $seachUser->from_id = $user->id;
                    $seachUser->to_id = $data->id;
                    $seachUser->save();
                }
            }
        }

        $newdata = array();
        if (!empty($newdata)) {
            $livestream = LiveStreamUser::where('user_id', $data->id)->orderBy('id', 'desc')->first();
            $data->live_total_gems = UserSpendGemsDetail::where('live_stream_id', $livestream->id)->select(\DB::raw('sum(total_gems) as live_total_gems'))->get()[0]->live_total_gems;
            $data->top_supporters_list = $this->topSuppotersList($livestream->id);
        } else {
            $data->live_total_gems = 0;
            $data->top_supporters_list = array();
        }

        $data->followers = UserFollower::where('to_id', $request->user_id)->count();
        $data->following = UserFollower::where('from_id', $request->user_id)->count();
        $data->favourite = UserFavourite::where('from_id', $request->user_id)->count();
        $data->total_livestream = LiveStreamUser::where('user_id', $request->user_id)->count();

        $is_follower = UserFollower::where('from_id', $request->user_id)->where('to_id', $user->id)->count();
        $is_following = UserFollower::where('from_id', $user->id)->where('to_id', $request->user_id)->count();

        $is_favourite = UserFavourite::where('from_id', $user->id)->where('to_id', $request->user_id)->count();
        $is_block = UserBlock::where('from_id', $user->id)->where('to_id', $request->user_id)->count();
        $data->total_times = LiveStreamUser::where('user_id', $request->user_id)->select(\DB::raw('sum(total_time) as total_time'))->get()[0]['total_time'];
        // level
        $data->level = Level::where('id', $data->level_id)->first();
        $data->level->level = (isset(explode('-', $data->level->slug)[1])) ? explode('-', $data->level->slug)[1] : 0;
        $tags = Tag::all();
        $usertags = UserTag::where('user_id', $request->user_id)->get();

        foreach ($tags as $value) {
            $value->is_tag = 0;
            foreach ($usertags as $val) {
                if ($val->tag_id == $value->id) {
                    $value->is_tag = 1;
                }
            }
            $value->image = "";
        }
        $data->tag = $tags;
        $profiles = UserProfile::where('user_id', $request->user_id)->select('*', \DB::raw("IF(image LIKE '%https://%' , image , " . "CONCAT('" . url('/storage/app/public/uploads/users/') . "/', image)) AS image"))->get();
        $newprofile[0]['id'] = 0;
        $newprofile[0]['image'] = $data->profile_pic;
        foreach ($profiles as $key => $val) {
            $newprofile[$key + 1]['id'] = $val->id;
            $newprofile[$key + 1]['image'] = $val->image;
        }

        $data->profiles = $newprofile;
        $eventParticipant = EventParticipant::where('user_id',$user->id)->first();
        $data->is_event_rank = 0;
        if($eventParticipant!=''){
            if($eventParticipant->event_counts >= 50){
                $data->is_event_rank = 3;
            }else if($eventParticipant->event_counts >= 40 && $eventParticipant->event_counts < 50 ){
                $data->is_event_rank = 2;
            }else if($eventParticipant->event_counts >= 30 && $eventParticipant->event_counts < 40){
                $data->is_event_rank = 1;
            }else{
                $data->is_event_rank = 0;
            }
        }
        $data->is_follower = ($is_follower == 1) ? true : false;
        $data->is_following = ($is_following == 1) ? true : false;
        $data->is_favourite = ($is_favourite == 1) ? true : false;
        $data->is_block = ($is_block == 1) ? true : false;

        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User profile update successfully', 'ResponseData' => $data], 200);
    }

    //my follower List
    public function myFollowerList(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
            }
            $followdata = UserFollower::with('followeruser')->where('to_id', $data['user']->id)->get();
            $sorted = array();
            $followers = array();
            $is_live = array();

            foreach ($followdata as $key => $value) {
                $is_block = UserBlock::where('from_id', $user->id)->where('to_id', $value['followeruser']->id)->count();
                if ($is_block == 0) {
                    $value->is_live = 0;
                    $value->startTime = 1613364473285;
                    $value->webRTCViewerCount = 0;
                    $response = BaseFunction::agoraliveStreamListUserDetail($value['followeruser']->stream_id);
                    $streamlist = json_decode($response);
                    if ($streamlist != "") {
                        if ($streamlist->data->channel_exist) {
                            $latest_live = LiveStreamUser::where('stream_id', $value['followeruser']->stream_id)->orderBy('id', 'DESC')->first();
                            $value->is_live = 1;
                            $value->startTime = strtotime($latest_live->created_at);
                            $value->webRTCViewerCount = $streamlist->data->audience_total == 0 ? 0 : $streamlist->data->audience_total;
                        }
                    }
                    $sorted[$key] = $value->startTime;
                    $is_live[$key] = $value->is_live;
                    $followers[$key] = $value;
                }
            }
            usort($followers, function ($a, $b) {
                return $b['webRTCViewerCount'] - $a['webRTCViewerCount'];
            });
            usort($followers, function ($a, $b) {
                return $b['is_live'] - $a['is_live'];
            });

            $recommendedData = LiveStreamUser::with(['user'])->where('user_id', '!=', $user->id)->groupby('user_id')->selectRaw('sum(total_time) as total_live_time,user_id')->orderby('total_live_time', 'DESC')->limit(10)->get();

            $recommendedUser = array();
            foreach ($recommendedData as $key => $value) {
                $is_block = UserBlock::where('from_id', $user->id)->where('to_id', $value->user->id)->count();
                $is_follower = UserFollower::where('to_id', $user->id)->where('from_id', $value->user->id)->count();

                if ($is_block == 0 &&  $is_follower == 0) {
                    $value->is_live = 0;
                    $value->startTime = 1613364473285;
                    $value->webRTCViewerCount = 0;
                    $response = BaseFunction::agoraliveStreamListUserDetail($value['user']->stream_id);
                    $streamlist = json_decode($response);
                    if ($streamlist != "") {
                        if ($streamlist->data->channel_exist) {
                            $latest_live = LiveStreamUser::where('stream_id', $value['user']->stream_id)->orderBy('id', 'DESC')->first();
                            $value->is_live = 1;
                            $value->startTime = strtotime($latest_live->created_at);
                            $value->webRTCViewerCount = $streamlist->data->audience_total == 0 ? 0 : $streamlist->data->audience_total;
                        }
                    }
                    $recommendedUser[] = $value;
                }
            }
            usort($recommendedUser, function ($a, $b) {
                return $b['webRTCViewerCount'] - $a['webRTCViewerCount'];
            });
            usort($recommendedUser, function ($a, $b) {
                return $b['is_live'] - $a['is_live'];
            });
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'My follower list successfully', 'ResponseData' => ['followers' => $followers, 'recommendeduser' => $recommendedUser]], 200);
        } catch (JWTException $e) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'could not create token'], 500);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json([
                'ResponseCode' => 0,
                'ResponseText' => 'Something went wrong.',
            ], 500);
        }
    }

    //my following List
    public function myFollowingList(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
            }

            // $response=BaseFunction::liveStreamList(0,1000);
            // $streamlist=json_decode($response);
            $followdata = UserFollower::with('followinguser')->where('from_id', $user->id)->get();
            $sorted = array();
            $followers = array();
            $is_live = array();

            foreach ($followdata as $key => $value) {
                $is_block = UserBlock::where('from_id', $user->id)->where('to_id', $value['followinguser']->id)->count();
                if ($is_block == 0) {
                    $response = BaseFunction::agoraliveStreamListUserDetail($value['followinguser']->stream_id);
                    $streamlist = json_decode($response);
                    $value->is_live = 0;
                    $value->startTime = 1613364473285;
                    $value->webRTCViewerCount = 0;
                    if ($streamlist != "") {
                        if ($streamlist->data->channel_exist) {
                            $latest_live = LiveStreamUser::where('stream_id', $value['followinguser']->stream_id)->orderBy('id', 'DESC')->first();
                            $value->is_live = 1;
                            $value->startTime = strtotime($latest_live->created_at);
                            $value->webRTCViewerCount = $streamlist->data->audience_total == 0 ? 0 : $streamlist->data->audience_total;
                        }
                    }
                    $sorted[$key] = $value->startTime;
                    $is_live[$key] = $value->is_live;
                    $followers[$key] = $value;
                }
            }
            usort($followers, function ($a, $b) {
                return $b['webRTCViewerCount'] - $a['webRTCViewerCount'];
            });
            usort($followers, function ($a, $b) {
                return $b['is_live'] - $a['is_live'];
            });

            $recommendedData = LiveStreamUser::with(['user'])->where('user_id', '!=', $user->id)->groupby('user_id')->selectRaw('sum(total_time) as total_live_time,user_id')->orderby('total_live_time', 'DESC')->limit(10)->get();

            $recommendedUser = array();
            foreach ($recommendedData as $key => $value) {
                $is_block = UserBlock::where('from_id', $user->id)->where('to_id', $value->user->id)->count();
                $is_follower = UserFollower::where('from_id', $user->id)->where('to_id', $value->user->id)->count();
                $response = BaseFunction::agoraliveStreamListUserDetail($value['user']->stream_id);
                $streamlist = json_decode($response);
                if ($is_block == 0 && $is_follower == 0) {
                    $value->is_live = 0;
                    $value->startTime = 1613364473285;
                    $value->webRTCViewerCount = 0;
                    if ($streamlist != "") {
                        if ($streamlist->data->channel_exist) {
                            $latest_live = LiveStreamUser::where('stream_id', $value['user']->stream_id)->orderBy('id', 'DESC')->first();
                            $value->is_live = 1;
                            $value->startTime = strtotime($latest_live->created_at);
                            $value->webRTCViewerCount = $streamlist->data->audience_total == 0 ? 0 : $streamlist->data->audience_total;
                        }
                    }
                    $recommendedUser[] = $value;
                }
            }
            usort($recommendedUser, function ($a, $b) {
                return $b['webRTCViewerCount'] - $a['webRTCViewerCount'];
            });
            usort($recommendedUser, function ($a, $b) {
                return $b['is_live'] - $a['is_live'];
            });
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'My following list successfully', 'ResponseData' => ['followers' => $followers, 'recommendeduser' => $recommendedUser]], 200);
        } catch (JWTException $e) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'could not create token'], 500);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json([
                'ResponseCode' => 0,
                'ResponseText' => 'Something went wrong.',
            ], 500);
        }
    }

    // // user details
    // public function userDetails(Request $request)
    // {
    //     try {
    //         $validate = Validator::make($request->all(), [
    //             'user_id' => 'required',
    //         ]);
    //         if($validate->fails())
    //         {
    //               return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
    //         }

    //         if (! $user = JWTAuth::parseToken()->authenticate()) {
    //             return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
    //         }

    //         $data=User::users()->where('id',$request->user_id)->select('users.*',\DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', users.profile_pic)) AS profile_pic"))->first();

    //         if($data==""){
    //             return response()->json(['ResponseCode'=>0,'ResponseText'=>'User profile not found','ResponseData'=>[]],200); 
    //         }

    //         if($request->user_id != $user->id){        
    //             if(isset($request->is_search) && $request->is_search == 1){
    //                 $isAlreadySearch = SearchUser::where('from_id',$user->id)->where('to_id',$data->id)->count();
    //                 if($isAlreadySearch == 0){
    //                     $seachUser = new SearchUser;
    //                     $seachUser->from_id = $user->id;
    //                     $seachUser->to_id = $data->id;
    //                     $seachUser->save();
    //                 }
    //             }
    //         }
    //         $newdata=array();
    //         if(!empty($newdata)){
    //             $livestream=LiveStreamUser::where('user_id',$data->id)->orderBy('id','desc')->first();
    //             $data->live_total_gems=UserSpendGemsDetail::where('live_stream_id',$livestream->id)->select(\DB::raw('sum(total_gems) as live_total_gems'))->get()[0]->live_total_gems;
    //             $data->top_supporters_list=$this->topSuppotersList($livestream->id);
    //         }else{
    //             $data->live_total_gems=0;
    //             $data->top_supporters_list=array();
    //         }

    //         $data->followers=UserFollower::where('to_id',$request->user_id)->count();
    //         $data->following=UserFollower::where('from_id',$request->user_id)->count();
    //         $data->favourite=UserFavourite::where('from_id',$request->user_id)->count();
    //         $data->total_livestream=LiveStreamUser::where('user_id',$request->user_id)->count();

    //         $is_follower=UserFollower::where('from_id',$request->user_id)->where('to_id',$user->id)->count();
    //         $is_following=UserFollower::where('from_id',$user->id)->where('to_id',$request->user_id)->count();

    //         $is_favourite=UserFavourite::where('from_id',$user->id)->where('to_id',$request->user_id)->count();
    //         $is_block=UserBlock::where('from_id',$user->id)->where('to_id',$request->user_id)->count();
    //         $data->total_times=LiveStreamUser::where('user_id',$request->user_id)->select(\DB::raw('sum(total_time) as total_time'))->get()[0]['total_time'];
    //         // level
    //         $data->level=Level::where('id',$data->level_id)->first();
    //         $data->level->level=(isset(explode('-',$data->level->slug)[1]))? explode('-',$data->level->slug)[1] :0;

    //         $data->is_follower=($is_follower==1)? true : false ;
    //         $data->is_following=($is_following==1)? true : false ;
    //         $data->is_favourite=($is_favourite==1)? true : false ;
    //         $data->is_block=($is_block==1)? true : false ;



    //         return response()->json(['ResponseCode'=>1,'ResponseText'=>'User profile update successfully','ResponseData'=>$data],200); 
    //     }
    //     catch (JWTException $e) {
    //         return response()->json(['ResponseCode'=>0,'ResponseText'=>'could not create token'],500);
    //     } catch (\Exception $e){
    //         $message = $e->getMessage();
    //         return response()->json([
    //             'ResponseCode' => 0,
    //             'ResponseText' => 'Something went wrong.',
    //         ], 500);
    //     }

    // }

    public function mostSearchUserList()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
            }
            $response = BaseFunction::agoraliveStreamList();
            $streamlist = json_decode($response);

            $userList = array();
            $userData = SearchUser::with(['user'])->where('to_id', '!=', $user->id)->selectRaw('to_id, count(to_id) as noofsearch')->groupby('to_id')->orderBy('noofsearch', 'DESC')->limit(20)->get();
            if ($userData != "") {
                foreach ($userData as $value) {
                    $value->is_live = 0;
                    $value->streamId = $value['user']->stream_id;
                    $value->startTime = 1613364473285;
                    $value->webRTCViewerCount = 0;

                    $is_follower = UserFollower::where('from_id', $value['user']->id)->where('to_id', $user->id)->count();
                    $is_following = UserFollower::where('from_id', $user->id)->where('to_id', $value['user']->id)->count();
                    $is_favourite = UserFavourite::where('from_id', $user->id)->where('to_id', $value['user']->id)->count();
                    $value->is_follower = ($is_follower == 1) ? true : false;
                    $value->is_following = ($is_following == 1) ? true : false;
                    $value->is_favourite = ($is_favourite == 1) ? true : false;

                    foreach ($streamlist->data->channels as  $antdata) {
                        if ($antdata->channel_name == $value['user']->stream_id) {
                            $latest_live = LiveStreamUser::where('stream_id', $value['user']->stream_id)->orderBy('id', 'DESC')->first();
                            $value->is_live = 1;
                            $value->streamId = $antdata->channel_name;
                            $value->startTime = strtotime($latest_live->created_at);
                            $value->webRTCViewerCount = $antdata->user_count == 0 ? 0 : $antdata->user_count - 1;
                        }
                    }
                }
            }

            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Most search user list successfully', 'ResponseData' => $userData], 200);
        } catch (JWTException $e) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'could not create token'], 500);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json([
                'ResponseCode' => 0,
                'ResponseText' => 'Something went wrong.',
            ], 500);
        }
    }

    public function updateProfileImage(Request $request)
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
            }



            $imageCount = UserProfile::where('user_id', $user->id)->count();

            if ($imageCount > 4) {
                return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' =>
                'You have already reached upload limit.']], 499);
            }

            if ($request->hasfile('image')) {
                $validate = Validator::make($request->all(), [
                    'image' => 'required',
                    'image.*' => 'mimes:jpeg,jpg,png|max:2048'
                ]);


                if ($validate->fails()) {
                    return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
                }

                $files = $request->file('image');
                if (count($files) > 4) {
                    return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' =>
                    'Not allowed more than 5 files.']], 499);
                }

                foreach ($files as $file) {
                    $new_name = 'user-' . rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(storage_path() . 'app/public/uploads/users/', $new_name);
                    $data = new UserProfile;
                    $data->image = $new_name;
                    $data->user_id = $user->id;
                    $data->save();
                }
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'profile updated upload successfully.', 'ResponseData' => []], 200);
        } catch (JWTException $e) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'could not create token'], 500);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json([
                'ResponseCode' => 0,
                'ResponseText' => 'Something went wrong.',
            ], 500);
        }
    }


    public function destroyImage(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
            }
            $validate = Validator::make($request->all(), [
                'id' => 'required'
            ]);
            if ($validate->fails()) {
                return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
            }
            $userdata = UserProfile::where('id', $request->id)->where('user_id', $user->id)->first();
            if ($userdata != "") {
                if ($userdata->image != "default.png") {
                    if (\File::exists(storage_path('app/public/uploads/users' . '/' . $userdata->image))) {
                        \File::delete(storage_path('app/public/uploads/users' . '/' . $userdata->image));
                    }
                }
            }
            UserProfile::where('id', $request->id)->delete();
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'profile image removed successfully.', 'ResponseData' => []], 200);
        } catch (JWTException $e) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'could not create token'], 500);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json([
                'ResponseCode' => 0,
                'ResponseText' => 'Something went wrong.',
            ], 500);
        }
    }

    // liveUserList
    public function liveUserList(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
            }
            $response = BaseFunction::agoraliveStreamList();
            $streamlist = json_decode($response);

            $sorted = array();
            $viewer = array();
            $is_live = array();
            $userdata = array();

            $users = User::with(['followers', 'following', 'favourite'])->where('is_online', 1)->where('id', '!=', $user->id)->where('user_type', '1')->select('id', 'username', 'email', 'county_code', 'stream_token', 'level_id', 'stream_id', 'phone', 'user_type', 'gender', \DB::raw("IF(profile_pic LIKE '%https://%' , profile_pic , " . "CONCAT('" . url('/storage/app/public/uploads/users/') . "/', profile_pic)) AS profile_pic"))->get();

            if ($users != "") {
                foreach ($users as $key => $value) {
                    $is_block = UserBlock::where('from_id', $user->id)->where('to_id', $value->id)->count();
                    if ($is_block == 0) {
                        $value->is_live = 0;
                        $value->startTime = 1613364473285;
                        $value->webRTCViewerCount = 0;
                        $value->followers_count = count($value->followers);
                        $value->following_count = count($value->following);
                        $value->favourite_count = count($value->favourite);

                        unset($value->followers);
                        unset($value->following);
                        unset($value->favourite);

                        $is_follower = UserFollower::where('from_id', $value->id)->where('to_id', $user->id)->count();
                        $is_following = UserFollower::where('from_id', $user->id)->where('to_id', $value->id)->count();
                        $is_favourite = UserFavourite::where('from_id', $user->id)->where('to_id', $value->id)->count();

                        $value->is_follower = ($is_follower == 1) ? true : false;
                        $value->is_following = ($is_following == 1) ? true : false;
                        $value->is_favourite = ($is_favourite == 1) ? true : false;
                        $value->is_hot = 1;
                        if ($value->level_id <= 2) {
                            $value->is_hot = 0;
                        }

                        if ($streamlist->success) {
                            foreach ($streamlist->data->channels as  $antdata) {
                                if ($antdata->channel_name == $value->stream_id) {
                                    $latest_live = LiveStreamUser::where('stream_id', $value->stream_id)->orderBy('id', 'DESC')->first();
                                    $value->is_live = 1;
                                    $value->streamId = $antdata->channel_name;
                                    $value->startTime = strtotime($latest_live->created_at);
                                    $randviewer = rand(20, 30);
                                    $value->webRTCViewerCount = $antdata->user_count == 0 ? $randviewer + 0 : ($randviewer + $antdata->user_count) - 1;
                                }
                            }
                        }
                        $userdata[] = $value;

                        // $sorted[$key] = $value->startTime;
                        // $viewer[$key] = $value->webRTCViewerCount;
                        // $is_live[$key] = $value->is_live;
                    }
                }
            }
            usort($userdata, function ($a, $b) {
                return $b['is_live'] - $a['is_live'];
            });
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User List successfully.', 'ResponseData' => $userdata], 200);
        } catch (JWTException $e) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'could not create token'], 500);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json([
                'ResponseCode' => 0,
                'ResponseText' => 'Something went wrong.',
            ], 500);
        }
    }
}
