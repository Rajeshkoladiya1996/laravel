<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use App\Models\Tag;
use App\Models\User;
use App\Models\Level;
use App\Models\UserBlock;
use App\Models\SearchUser;
use App\Models\LevelDetail;
use App\Models\UserRequest;
use App\Helper\BaseFunction;
use App\Models\EventParticipant;
use App\Models\UserFollower;
use App\Models\UserFavourite;
use App\Models\Notifications;
use App\Models\LiveStreamUser;
use App\Models\UserLevelDetail;
use App\Models\UserSpendGemsDetail;
use Carbon\Carbon;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class UserController extends Controller
{
    // profile update
    public function updateProfile(Request $request)
    {
        $app = $request->header('Flag');
        $user = JWTAuth::parseToken()->authenticate();
        $data = compact('user');
        $validate = Validator::make($request->all(), [
            'username' => 'required|string|between:2,100|unique:users,username,' . $data['user']->id,
        ]);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => '0', 'ResponseText' => $validate->errors()->all()[0], 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
        }

        $userdata['username'] = $request->username;
        if (isset($request->phone) && $request->phone == "null" && $request->phone == null) {
            $validate = Validator::make($request->all(), [
                'phone' => 'required|string|between:2,100|unique:users,phone,' . $data['user']->id,
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

        if (isset($request->profile_img)) {
            $file = mb_convert_encoding($request->profile_img, 'UTF-8', 'UTF-8');
            $folderName = 'public/uploads/users/';
            $safeName = "profile_" . uniqid() . '.' . 'png';
            $destinationPath = storage_path('/app/public/uploads/users');
            $success = file_put_contents(storage_path('/app/public/uploads/users') . '/' . $safeName, base64_decode($file));
            $userdata['profile_pic'] = $safeName;
        }

        User::where('id', $data['user']->id)->update($userdata);
        $userdata = User::users()->where('id', $data['user']->id)->select('users.*', \DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , " . "CONCAT('" . url('/storage/app/public/uploads/users/') . "/', users.profile_pic)) AS profile_pic"))->get()->first();
        $userdata->followers = UserFollower::where('to_id', $data['user']->id)->count();
        $userdata->following = UserFollower::where('from_id', $data['user']->id)->count();
        $userdata->favourite = UserFavourite::where('from_id', $data['user']->id)->count();
        $userdata->total_gems = 0;
        $tags = Tag::all();
        foreach ($tags as $value) {
            $value->image = "";
        }
        $userdata->tag = $tags;
        $userdata->level = Level::where('id', $userdata->level_id)->first();
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
            $data->is_event_rank = 0;
           }  
        }
        
        $userdata->level->level = (isset(explode('-', $userdata->level->slug)[1])) ? explode('-', $userdata->level->slug)[1] : 0;
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User profile update successfully', 'ResponseData' => $userdata], 200);
    }

    // user List 
    public function userList(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
        }
        $loginuser = compact('user');
        $userList = User::users()->where('id', '!=', $loginuser['user']->id)->select('users.*', \DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , " . "CONCAT('" . url('/storage/app/public/uploads/users/') . "/', users.profile_pic)) AS profile_pic"))->get();
        foreach ($userList as $key => $value) {
            $value->followers = UserFollower::where('to_id', $value->id)->count();
            $value->following = UserFollower::where('from_id', $value->id)->count();
            $value->favourite = UserFavourite::where('from_id', $value->id)->count();

            $is_follower = UserFollower::where('from_id', $value->user_id)->where('to_id', $loginuser['user']->id)->count();
            $is_following = UserFollower::where('from_id', $loginuser['user']->id)->where('to_id', $value->user_id)->count();
            $is_favourite = UserFavourite::where('from_id', $loginuser['user']->id)->where('to_id', $value->id)->count();

            $value->is_follower = ($is_follower == 1) ? true : false;
            $value->is_following = ($is_following == 1) ? true : false;
            $value->is_favourite = ($is_favourite == 1) ? true : false;
            $value->total_gems = 0;
        }

        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User list', 'ResponseData' => $userList], 200);
    }

    // priver
    public function userPrivacyUpdate(Request $request)
    {
        $app = $request->header('Flag');
        $user = JWTAuth::parseToken()->authenticate();
        $data = compact('user');
        $validate = Validator::make($request->all(), [
            'hide_location' => 'required',
            'hide_near_by_videos' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
        }

        $userdata['hide_location'] = $request->hide_location;
        $userdata['hide_near_by_videos'] = $request->hide_near_by_videos;
        User::where('id', $data['user']->id)->update($userdata);
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User Privacy update successfully'], 200);
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

        $loginuser = compact('user');

        $data = User::users()->where('id', $request->user_id)->select('users.*', \DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , " . "CONCAT('" . url('/storage/app/public/uploads/users/') . "/', users.profile_pic)) AS profile_pic"))->first();

        // $url="http://bklive.stream:5080/WebRTCAppEE/rest/v2/broadcasts/".$data->stream_id."";
        // $response=BaseFunction::curlCallApi($url);
        if ($data == "") {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'User profile not found', 'ResponseData' => []], 200);
        }
        if ($request->user_id != $loginuser['user']->id) {
            if (isset($request->is_search) && $request->is_search == 1) {
                $isAlreadySearch = SearchUser::where('from_id', $loginuser['user']->id)->where('to_id', $data->id)->count();
                if ($isAlreadySearch == 0) {
                    $seachUser = new SearchUser;
                    $seachUser->from_id = $loginuser['user']->id;
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

        $is_follower = UserFollower::where('from_id', $request->user_id)->where('to_id', $loginuser['user']->id)->count();
        $is_following = UserFollower::where('from_id', $loginuser['user']->id)->where('to_id', $request->user_id)->count();

        $is_favourite = UserFavourite::where('from_id', $loginuser['user']->id)->where('to_id', $request->user_id)->count();
        $is_block = UserBlock::where('from_id', $loginuser['user']->id)->where('to_id', $request->user_id)->count();
        $data->total_times = LiveStreamUser::where('user_id', $request->user_id)->select(\DB::raw('sum(total_time) as total_time'))->get()[0]['total_time'];
        // level
        $data->level = Level::where('id', $data->level_id)->first();
        $data->level->level = (isset(explode('-', $data->level->slug)[1])) ? explode('-', $data->level->slug)[1] : 0;
        $eventParticipant = EventParticipant::where('user_id',$request->user_id)->first();
        $data->is_event_rank = 0;
        if($eventParticipant != ''){
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

    //follower request
    public function followerRequest(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
        }

        $validate = Validator::make($request->all(), [
            'from_id' => 'required',
            'to_id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
        }

        if ($request->from_id == $request->to_id) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'from user and to user is same'], 200);
        }
        $userdetail = User::where('id', $request->from_id)->first();
        $level = Level::where('id', $userdetail->level_id)->first();
        $levelNext = Level::where('id', '>', $userdetail->level_id)->first();
        $leveldetail = LevelDetail::where('level_id', $userdetail->level_id)->where('name', 'like', '%Follower%')->first();
        $check = UserFollower::where('from_id', $request->from_id)->where('to_id', $request->to_id)->first();

        if ($check == '') {
            $touserdetail = User::where('id', $request->to_id)->first();
            BaseFunction::sendNotification($touserdetail, "Follow Request", $userdetail->username . " is following you", 'user_follow', $userdetail);
            $follower = new UserFollower;
            $follower->from_id = $request->from_id;
            $follower->to_id = $request->to_id;
            $follower->save();
            if ($leveldetail != "") {
                $checklevel = UserLevelDetail::where('level_detail_id', $leveldetail->id)->first();
                if ($checklevel == "") {
                    $UserLevelDetail = new UserLevelDetail;
                    $UserLevelDetail->level_detail_id = $leveldetail->id;
                    $UserLevelDetail->point = $leveldetail->point;
                    $UserLevelDetail->user_id = $request->from_id;
                    $UserLevelDetail->save();
                    $point = $userdetail->point + $leveldetail->point;
                    User::where('id', $request->from_id)->update(['total_point' => $point]);
                    if ($level->total_point == $point) {
                        if ($levelNext != "") {
                            User::where('id', $request->from_id)->update(['level_id' => $levelNext->id]);
                        }
                    }
                }
            }

            // follower level Increased
            $userdetail = User::where('id', $request->from_id)->first();
            if ($userdetail->level_id != "") {
                BaseFunction::levelIncrease($userdetail, $request->from_id, 4);
            }
            $userdata=User::where('id',$request->to_id)->first();
            return response()->json(['ResponseCode'=>1,'ResponseText'=>'You have followed '.$userdata->username],200); 
        } else {
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User already follower'], 200);
        }
    }

    //unfollower request
    public function unfollowerRequest(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
        }

        $validate = Validator::make($request->all(), [
            'from_id' => 'required',
            'to_id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
        }

        $data = UserFollower::where('from_id', $request->from_id)->where('to_id', $request->to_id)->delete();
        $userdata = User::where('id', $request->to_id)->first();
        if ($data) {
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'You have unfollowed ' . $userdata->username], 200);
        } else {
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'user not unfollower'], 200);
        }
    }

    //my follower List
    public function myFollowerList(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
        }
        // $data=compact('user');
        $response = BaseFunction::agoraliveStreamList();
        $followdata = UserFollower::with('followeruser')->where('to_id', $user->id)->get();
        $streamlist = json_decode($response);
        $sorted = array();
        $followers = array();
        $is_live = array();

        foreach ($followdata as $key => $value) {
            $is_follower = UserFollower::where('from_id', $value['followeruser']->id)->where('to_id', $user->id)->count();
            $is_following = UserFollower::where('from_id', $user->id)->where('to_id', $value['followeruser']->id)->count();
            $is_favourite = UserFavourite::where('from_id', $user->id)->where('to_id', $value['followeruser']->id)->count();
            $value->is_follower = ($is_follower == 1) ? true : false;
            $value->is_following = ($is_following == 1) ? true : false;
            $value->is_favourite = ($is_favourite == 1) ? true : false;

            $is_block = UserBlock::where('from_id', $user->id)->where('to_id', $value['followeruser']->id)->count();
            if ($is_block == 0) {
                $value->is_live = 0;
                $value->startTime = 1613364473285;
                $value->webRTCViewerCount = 0;

                if ($streamlist != "") {
                    foreach ($streamlist->data->channels as  $antdata) {
                        if ($antdata->channel_name == $value['followeruser']->stream_id) {
                            $latest_live = LiveStreamUser::where('stream_id', $value['followeruser']->stream_id)->orderBy('id', 'DESC')->first();
                            $value->is_live = 1;
                            $value->streamId = $antdata->channel_name;
                            $value->startTime = strtotime($latest_live->created_at);
                            $value->webRTCViewerCount = $antdata->user_count == 0 ? 0 : $antdata->user_count - 1;
                        }
                    }
                }
                $sorted[$key] = $value->startTime;
                $is_live[$key] = $value->is_live;
                $followers[$key] = $value;
            }
        }
        array_multisort($sorted, SORT_DESC, $followers);
        array_multisort($is_live, SORT_DESC, $followers);
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'My follower list successfully', 'ResponseData' => $followers], 200);
    }

    //my following List
    public function myFollowingList(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
        }
        // $loginuser=compact('user');
        $response = BaseFunction::agoraliveStreamList();
        $followdata = UserFollower::with('followinguser')->where('from_id', $user->id)->get();
        $streamlist = json_decode($response);
        $sorted = array();
        $followers = array();
        $is_live = array();

        foreach ($followdata as $key => $value) {
            $is_follower = UserFollower::where('to_id', $value['followinguser']->id)->where('from_id', $user->id)->count();
            $is_following = UserFollower::where('from_id', $user->id)->where('to_id', $value['followinguser']->id)->count();
            $is_favourite = UserFavourite::where('to_id', $user->id)->where('from_id', $value['followinguser']->id)->count();
            $value->is_follower = ($is_follower == 1) ? true : false;
            $value->is_following = ($is_following == 1) ? true : false;
            $value->is_favourite = ($is_favourite == 1) ? true : false;

            $is_block = UserBlock::where('from_id', $user->id)->where('to_id', $value['followinguser']->id)->count();
            if ($is_block == 0) {
                $value->is_live = 0;
                $value->startTime = 1613364473285;
                $value->webRTCViewerCount = 0;
                if ($streamlist != "") {
                    foreach ($streamlist->data->channels as  $antdata) {
                        if ($antdata->channel_name == $value['followinguser']->stream_id) {
                            $latest_live = LiveStreamUser::where('stream_id', $value['followinguser']->stream_id)->orderBy('id', 'DESC')->first();
                            $value->is_live = 1;
                            $value->streamId = $antdata->channel_name;
                            $value->startTime = strtotime($latest_live->created_at);
                            $value->webRTCViewerCount = $antdata->user_count == 0 ? 0 : $antdata->user_count - 1;
                        }
                    }
                }
                $sorted[$key] = $value->startTime;
                $is_live[$key] = $value->is_live;
                $followers[$key] = $value;
            }
        }
        array_multisort($sorted, SORT_DESC, $followers);
        array_multisort($is_live, SORT_DESC, $followers);
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'My following list successfully', 'ResponseData' => $followers], 200);
    }

    //favourite request
    public function favourite(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'from_id' => 'required',
            'to_id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
        }
        $userdetail = User::where('id', $request->from_id)->first();
        $level = Level::where('id', $userdetail->level_id)->first();
        $levelNext = Level::where('id', '>', $userdetail->level_id)->first();
        $leveldetail = LevelDetail::where('level_id', $userdetail->level_id)->where('name', 'like', '%Favorite%')->first();
        $check = UserFavourite::where('from_id', $request->from_id)->where('to_id', $request->to_id)->first();

        if ($check == '') {
            $favourite = new UserFavourite;
            $favourite->from_id = $request->from_id;
            $favourite->to_id = $request->to_id;
            $favourite->save();
            if ($leveldetail != "") {
                $checklevel = UserLevelDetail::where('level_detail_id', $leveldetail->id)->first();
                if ($checklevel == "") {
                    $UserLevelDetail = new UserLevelDetail;
                    $UserLevelDetail->level_detail_id = $leveldetail->id;
                    $UserLevelDetail->point = $leveldetail->point;
                    $UserLevelDetail->user_id = $request->from_id;
                    $UserLevelDetail->save();
                    $point = $userdetail->point + $leveldetail->point;
                    User::where('id', $request->from_id)->update(['total_point' => $point]);
                    if ($level->total_point == $point) {
                        if ($levelNext != "") {
                            User::where('id', $request->from_id)->update(['level_id' => $levelNext->id]);
                        }
                    }
                }
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'favourite successfully'], 200);
        } else {
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User already favourite'], 200);
        }
    }

    //unfavourite request
    public function unfavourite(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'from_id' => 'required',
            'to_id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
        }
        UserFavourite::where('from_id', $request->from_id)->where('to_id', $request->to_id)->delete();
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'unfavourite successfully'], 200);
    }

    //favourite list
    public function favouriteList(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
        }
        $loginuser = compact('user');
        $response = BaseFunction::liveStreamList(0, 1000);
        $favouritedata = UserFavourite::with('favouriteuser')->where('from_id', $loginuser['user']->id)->get();
        $streamlist = json_decode($response);
        $sorted = array();
        $favourite = array();
        $is_live = array();

        foreach ($favouritedata as $key => $value) {
            $is_block = UserBlock::where('from_id', $loginuser['user']->id)->where('to_id', $value['favouriteuser']->id)->count();
            if ($is_block == 0) {
                $value->is_live = 0;
                $value->startTime = 1613364473285;
                $value->webRTCViewerCount = 0;
                if ($streamlist != "") {
                    foreach ($streamlist as $data) {
                        if ($data->streamId == $value['favouriteuser']->stream_id) {
                            $value->is_live = 1;
                            $value->startTime = $data->startTime;
                            $value->webRTCViewerCount = $data->webRTCViewerCount;
                            break;
                        }
                    }
                }
                $sorted[$key] = $value->startTime;
                $is_live[$key] = $value->is_live;
                $favourite[$key] = $value;
            }
        }
        array_multisort($sorted, SORT_DESC, $favourite);
        array_multisort($is_live, SORT_DESC, $favourite);
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Favourite list successfully', 'ResponseData' => $favourite], 200);
    }

    //other user follower List
    public function otherFollowerList(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
        }

        $validate = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
        }

        // $data=compact('user');
        $response = BaseFunction::agoraliveStreamList();
        $followdata = UserFollower::with('followeruser')->where('to_id', $request->user_id)->get();
        $streamlist = json_decode($response);
        $sorted = array();
        $followers = array();
        $is_live = array();

        foreach ($followdata as $key => $value) {
            $is_follower = UserFollower::where('from_id', $value['followeruser']->id)->where('to_id', $user->id)->count();
            $is_following = UserFollower::where('from_id', $user->id)->where('to_id', $value['followeruser']->id)->count();
            $is_favourite = UserFavourite::where('from_id', $user->id)->where('to_id', $value['followeruser']->id)->count();
            $value->is_follower = ($is_follower == 1) ? true : false;
            $value->is_following = ($is_following == 1) ? true : false;
            $value->is_favourite = ($is_favourite == 1) ? true : false;

            $is_block = UserBlock::where('from_id', $user->id)->where('to_id', $value['followeruser']->id)->count();
            if ($is_block == 0) {
                $value->is_live = 0;
                $value->startTime = 1613364473285;
                $value->webRTCViewerCount = 0;

                if ($streamlist != "") {
                    foreach ($streamlist->data->channels as  $antdata) {
                        if ($antdata->channel_name == $value['followeruser']->stream_id) {
                            $latest_live = LiveStreamUser::where('stream_id', $value['followeruser']->stream_id)->orderBy('id', 'DESC')->first();
                            $value->is_live = 1;
                            $value->streamId = $antdata->channel_name;
                            $value->startTime = strtotime($latest_live->created_at);
                            $value->webRTCViewerCount = $antdata->user_count == 0 ? 0 : $antdata->user_count - 1;
                        }
                    }
                }
                $sorted[$key] = $value->startTime;
                $is_live[$key] = $value->is_live;
                $followers[$key] = $value;
            }
        }
        array_multisort($sorted, SORT_DESC, $followers);
        array_multisort($is_live, SORT_DESC, $followers);
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'My follower list successfully', 'ResponseData' => $followers], 200);
    }

    //other user following List
    public function otherFollowingList(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
        }
        $validate = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
        }
        // $loginuser=compact('user');
        $response = BaseFunction::agoraliveStreamList();
        $followdata = UserFollower::with('followinguser')->where('from_id', $request->user_id)->get();
        $streamlist = json_decode($response);
        $sorted = array();
        $followers = array();
        $is_live = array();

        foreach ($followdata as $key => $value) {
            $is_follower = UserFollower::where('from_id', $value['followinguser']->id)->where('to_id', $user->id)->count();
            $is_following = UserFollower::where('from_id', $user->id)->where('to_id', $value['followinguser']->id)->count();
            $is_favourite = UserFavourite::where('to_id', $user->id)->where('from_id', $value['followinguser']->id)->count();
            $value->is_follower = ($is_follower == 1) ? true : false;
            $value->is_following = ($is_following == 1) ? true : false;
            $value->is_favourite = ($is_favourite == 1) ? true : false;

            $is_block = UserBlock::where('from_id', $user->id)->where('to_id', $value['followinguser']->id)->count();
            if ($is_block == 0) {
                $value->is_live = 0;
                $value->startTime = 1613364473285;
                $value->webRTCViewerCount = 0;
                if ($streamlist != "") {
                    foreach ($streamlist->data->channels as  $antdata) {
                        if ($antdata->channel_name == $value['followinguser']->stream_id) {
                            $latest_live = LiveStreamUser::where('stream_id', $value['followinguser']->stream_id)->orderBy('id', 'DESC')->first();
                            $value->is_live = 1;
                            $value->streamId = $antdata->channel_name;
                            $value->startTime = strtotime($latest_live->created_at);
                            $value->webRTCViewerCount = $antdata->user_count == 0 ? 0 : $antdata->user_count - 1;
                        }
                    }
                }
                $sorted[$key] = $value->startTime;
                $is_live[$key] = $value->is_live;
                $followers[$key] = $value;
            }
        }
        array_multisort($sorted, SORT_DESC, $followers);
        array_multisort($is_live, SORT_DESC, $followers);
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'My following list successfully', 'ResponseData' => $followers], 200);
    }

    // requestForLive function
    public function requestForLive(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
        }
        $checkrequest = UserRequest::where('user_id', $request->user_id)->where('type', 'request_for_live')->first();
        if ($checkrequest == "") {
            $userrequest = new UserRequest;
            $userrequest->user_id = $request->user_id;
            $userrequest->type = 'request_for_live';
            $userrequest->message = 'User send to request for live stream';
            $userrequest->status = '1';
            $userrequest->save();
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Live Stream request successfully', 'ResponseData' => ['status' => '1']], 200);
        } else {
            if ($checkrequest->status == 0) {
                $userrequest = new UserRequest;
                $userrequest->exists = true;
                $userrequest->id = $checkrequest->id;
                $userrequest->status = '1';
                $userrequest->save();
                return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Live Stream request send successfully', 'ResponseData' => ['status' => '1']], 200);
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Live Stream request already send', 'ResponseData' => ['status' => $checkrequest->status]], 200);
        }
    }

    // getStreamStatus function
    public function getStreamStatus(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
        }

        $checkrequest = UserRequest::where('user_id', $request->user_id)->where('type', 'request_for_live')->first();
        if ($checkrequest != "") {
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Live Stream request status', 'ResponseData' => ['status' => $checkrequest->status]], 200);
        } else {
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Live Stream request status', 'ResponseData' => ['status' => 0]], 200);
        }
    }

    public function userActivity(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
            }

            $validate = Validator::make($request->all(), [
                'start_date' => 'required',
                'end_date' => 'required',
                'type' => 'required',
            ]);
            if ($validate->fails()) {
                return response()->json(['ResponseCode' => '0', 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => $validate->errors()->all()]], 499);
            }


            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $users = User::users()->where('id', $user->id)->first();


            $livesteamers = LiveStreamUser::where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('user_id', $user->id)->get();
            $weeklydata = LiveStreamUser::where('user_id', $user->id)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->get();
            $total_time = 0;
            foreach ($weeklydata as $key => $data) {
                $interval = Carbon::parse($data->updated_at)->timestamp - Carbon::parse($data->created_at)->timestamp;
                $total_time = $total_time + $interval;
            }

            $diff_in_days = LiveStreamUser::where('user_id', $user->id)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->select(\DB::raw('DATE(created_at) as date'))->groupBy('date')->get();
            $data = [];
            $data['days'] = count($diff_in_days);
            $data['total_time'] = gmdate('H:i:s', $total_time);

            $array  = [];

            $diff_in_days = LiveStreamUser::where('user_id', $user->id)->whereBetween('created_at', [$start_date, $end_date])->distinct('created_at')->get();
            foreach ($livesteamers as $key => $value) {
                $start_date_bankock = new Carbon($value->created_at);
                $start_date_bankock->timezone = 'Asia/Bangkok';

                $end_date_bankock = new Carbon($value->updated_at);
                $end_date_bankock->timezone = 'Asia/Bangkok';

                $interval = date_diff($value->updated_at, $value->created_at);

                $timearray = [
                    "date" => date('d-m-Y', strtotime($value->created_at)),
                    "start_time" => date('H:i:s', strtotime($start_date_bankock->toDayDateTimeString())),
                    "end_time" => date('H:i:s', strtotime($end_date_bankock->toDayDateTimeString())),
                    "duration" => $interval->format('%H:%I:%S')
                ];

                $array[] = $timearray;
            }
            $data['user_activity'] = $array;
            if ($request->type == "user") {
                $data['days'] = 0;
                $data['total_time'] = '00:00:00';
                $data['user_activity'] = [];
            }
            return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User Activities', 'ResponseData' => $data], 200);
        } catch (JWTException $e) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'could not create token'], 500);
        } catch (Exception $e) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'Something went wrong.'], 500);
        }
    }


    // userActivity function
    public function userOldActivity(Request $request)
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

        $loginuser = compact('user');

        $data = User::users()->where('id', $request->user_id)->select('users.stream_id', 'users.id', 'users.username', 'users.phone', 'users.email', \DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , " . "CONCAT('" . url('/storage/app/public/uploads/users/') . "/', users.profile_pic)) AS profile_pic"))->first();

        $data->followers = UserFollower::where('to_id', $request->user_id)->count();
        $data->following = UserFollower::where('from_id', $request->user_id)->count();
        $data->favourite = UserFavourite::where('from_id', $request->user_id)->count();
        $data->total_livestream = LiveStreamUser::where('user_id', $request->user_id)->count();

        $is_follower = UserFollower::where('from_id', $request->user_id)->where('to_id', $loginuser['user']->id)->count();
        $is_following = UserFollower::where('from_id', $loginuser['user']->id)->where('to_id', $request->user_id)->count();

        $is_favourite = UserFavourite::where('from_id', $loginuser['user']->id)->where('to_id', $request->user_id)->count();

        $is_block = UserBlock::where('from_id', $loginuser['user']->id)->where('to_id', $request->user_id)->count();

        $data->is_follower = ($is_follower == 1) ? true : false;
        $data->is_following = ($is_following == 1) ? true : false;
        $data->is_favourite = ($is_favourite == 1) ? true : false;
        $data->is_block = ($is_block == 1) ? true : false;
        $data->total_times = LiveStreamUser::where('user_id', $request->user_id)->select(\DB::raw('sum(total_time) as total_time'))->get()[0]['total_time'];

        $data->top_supporters_list = UserSpendGemsDetail::with('user')->where('to_id', $request->user_id)->select('*', \DB::raw('sum(total_gems) as total_gems'))->groupBy('from_id')->orderBy('total_gems', 'DESC')->get();
        foreach ($data->top_supporters_list as $value) {
            $is_follower = UserFollower::where('from_id', $value->from_id)->where('to_id', $request->user_id)->count();
            $is_following = UserFollower::where('from_id', $request->user_id)->where('to_id', $value->from_id)->count();

            $is_favourite = UserFavourite::where('from_id', $request->user_id)->where('to_id', $value->from_id)->count();

            $is_block = UserBlock::where('from_id', $request->user_id)->where('to_id', $value->from_id)->count();
            $value->is_follower = ($is_follower == 1) ? true : false;
            $value->is_following = ($is_following == 1) ? true : false;
            $value->is_favourite = ($is_favourite == 1) ? true : false;
            $value->is_block = ($is_block == 1) ? true : false;
        }

        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'User Activities', 'ResponseData' => $data], 200);
    }

    public function topSuppotersList($live_stream_id)
    {
        return UserSpendGemsDetail::with('user')->where('live_stream_id', $live_stream_id)->orderBy('total_gems', 'DESC')->get();
    }


    public function getAlphabeats()
    {
        // $i=1;
        // foreach (range('A', 'Z') as $char) {
        //     $obj = array('id' => $i, 'image' => '','name'=>$char);
        //     $data[] = (Object)$obj;
        //     $i++;
        // }
        $data = [['id' => 1, 'image' => '', 'name' => 'Streamer'], ['id' => 2, 'image' => '', 'name' => 'Comical'], ['id' => 3, 'image' => '', 'name' => 'Singing'], ['id' => 4, 'image' => '', 'name' => 'Music'], ['id' => 5, 'image' => '', 'name' => 'Drama'], ['id' => 6, 'image' => '', 'name' => 'Cooking'], ['id' => 7, 'image' => '', 'name' => 'Dancing'], ['id' => 8, 'image' => '', 'name' => 'Special']];

        $tags = Tag::all();
        foreach ($tags as $value) {
            $value->image = "";
        }

        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Alphabeats list', 'ResponseData' => $tags], 200);
    }

    /*notifications list*/
    public function notificationList(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode' => 0, 'ResponseText' => 'validation fail', 'ResponseData' => ['errors' => 'user_not_found']], 404);
        }

        $notificationList = Notifications::where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(20);

        foreach ($notificationList as $row) {

            $find = ['from_user":"{', 'to_user":"{', '","end_time"', '","to_user"'];
            $replace = ['from_user":{', 'to_user":{', ',"end_time"', ',"to_user"'];;
            $final = str_replace($find, $replace, $row->data);
            $row->data = json_decode($final);
            $user = User::where('id', $row->data->id)->first();
            if ($user->profile_pic) {
                $row->data->image = url('/storage/app/public/uploads/users/') . "/" . $user->profile_pic;
            }
        }
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Notifications List successfully', 'ResponseData' => $notificationList], 200);
    }


    public function topBattelSuppotersList($battel_live_stream_id, $user_id)
    {
        return UserSpendGemsDetail::with('user')->where('battel_live_stream_id', $battel_live_stream_id)->where('to_id', $user_id)->orderBy('total_gems', 'DESC')->get();
    }
}
