<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\User;
use App\Models\UserBlock;
use App\Models\UserFollower;
use App\Models\UserFavourite;
use App\Models\UserLevelDetail;
use App\Models\LiveStreamUser;
use App\Models\StreamViewerUser;
use App\Models\HotTagSetting;
use App\Helper\BaseFunction;
use Validator;
use JWTAuth;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    public function liveStreamList(Request $request)
    {
        try {
            if (! $users = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
            }
            $rule=[
                'category'=>'required',
            ];
            $message=[
                'category.required'=>'category is required',
            ];
            $validate=Validator::make($request->all(),$rule,$message);

            if($validate->fails()){
                return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
            }
            $response=BaseFunction::agoraliveStreamList();
            $streamlist=json_decode($response);

            $sorted=array(); 
            $viewer=array();
            $is_live=array();
            $userdata=array();


            $user = User::with(['followers','following','favourite'])->where('id','!=',$users->id)->where('user_type','1')->select('id','username','email','county_code','stream_token','level_id','stream_id','phone','user_type','gender',\DB::raw("IF(profile_pic LIKE '%https://%' , profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', profile_pic)) AS profile_pic"));               
            if(isset($request->search_text) && ($request->search_text != '')) {
                $tags=$request->search_text;
                $user = $user->whereHas('usertag',function($q) use($tags){
                    return $q->leftjoin('tags', 'user_tags.tag_id', '=', 'tags.id')->where('tags.name',$tags);
                })->with('usertag');
            }
            
            

            if($request->category == 'popular'){
                $user = $user->orderBy('earned_gems','DESC')->limit(20)->get();
            }elseif($request->category == 'new_vj'){
                $user = $user->orderBy('created_at','DESC')->limit(20)->get();
            }elseif($request->category == 'live'){
               $user= $user->get();
            }else{
                $user= $user->get();
            }

            if($user!=""){
                foreach ($user as $key => $value) {
                    $is_block=UserBlock::where('from_id',$users->id)->where('to_id',$value->id)->count();
                    if($is_block==0){
                        $value->is_live=0;
                        $value->startTime=1613364473285;
                        $value->webRTCViewerCount=0;
                        $value->followers_count=count($value->followers) ;
                        $value->following_count=count($value->following) ;
                        $value->favourite_count=count($value->favourite) ;

                        unset($value->followers);
                        unset($value->following);
                        unset($value->favourite);

                        $is_follower=UserFollower::where('from_id',$value->id)->where('to_id',$users->id)->count();
                        $is_following=UserFollower::where('from_id',$users->id)->where('to_id',$value->id)->count();
                        $is_favourite=UserFavourite::where('from_id',$users->id)->where('to_id',$value->id)->count();

                        $value->is_follower=($is_follower==1)? true : false ;
                        $value->is_following=($is_following==1)? true : false ;
                        $value->is_favourite=($is_favourite==1)? true : false ;
                        $value->is_hot=1;
                        if($value->level_id<=2 ){
                            $value->is_hot=0;
                        }

                        if($request->category == 'live'){
                            if($streamlist->success){                            
                                foreach ($streamlist->data->channels as $antdata) {
                                    if($antdata->channel_name==$value->stream_id){
                                        $latest_live = LiveStreamUser::where('stream_id',$value->stream_id)->orderBy('id','DESC')->first();
                                        $value->is_live=1;
                                        $value->streamId=$antdata->channel_name;
                                        $value->startTime=strtotime($latest_live->created_at);
                                        $randviewer=rand(20,30);
                                        $value->webRTCViewerCount=$antdata->user_count == 0 ? $randviewer + 0 : ($randviewer + $antdata->user_count) - 1;
                                        $userdata[]=$value;
                                        break;
                                    }
                                }
                            }else{
                                $userdata[]=$value;
                            }
                        }else{
                            if($streamlist->success){
                                foreach ($streamlist->data->channels as  $antdata) {
                                    if($antdata->channel_name==$value->stream_id){
                                        $latest_live = LiveStreamUser::where('stream_id',$value->stream_id)->orderBy('id','DESC')->first();
                                        $value->is_live=1;
                                        $value->streamId=$antdata->channel_name;
                                        $value->startTime=strtotime($latest_live->created_at);
                                        $randviewer=rand(20,30);
                                        $value->webRTCViewerCount=$antdata->user_count == 0 ? $randviewer + 0 : ($randviewer + $antdata->user_count) - 1;
                                    }
                                }
                            }
                            $userdata[]=$value;

                        }                            
                        
                        // $sorted[$key] = $value->startTime;
                        // $viewer[$key] = $value->webRTCViewerCount;
                        // $is_live[$key] = $value->is_live;
                    }
                }
            }
            

            // if(isset($request->search_text) && ($request->search_text != '')) {
            //     $temp=array();
            //     foreach($userdata as $key => $value){
            //         if(strval(stripos($value->username, $request->search_text))!=""){
            //             $temp[$key]=$value;
            //         }
            //     }
            //     $userdata=$temp;  
                  
            // }
            if($request->category == 'popular'){
                usort($userdata, function($a, $b) {
                    return $b['following_count'] - $a['following_count'];
                });
            }else{
                usort($userdata, function($a, $b) {
                    return $b['webRTCViewerCount'] - $a['webRTCViewerCount'];
                });
                usort($userdata, function($a, $b) {
                    return $b['is_live'] - $a['is_live'];
                });
            }
            return response()->json(['ResponseCode'=>1,'ResponseText'=>'Live Streamer all list Successfully. ','ResponseData'=>$userdata],200);

        } catch (\Exception $e){
            return response()->json(['ResponseCode' => 0,'ResponseText' => 'Something went wrong.'], 500);
        } 
    }

    // liveStreamList2
    public function liveStreamList2(Request $request)
    {
        try {
            if (! $users = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
            }
            $rule=[
                'category'=>'required',
            ];
            $message=[
                'category.required'=>'category is required',
            ];
            $validate=Validator::make($request->all(),$rule,$message);

            if($validate->fails()){
                return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
            }
            $response=BaseFunction::agoraliveStreamList();
            $streamlist=json_decode($response);

            $sorted=array(); 
            $viewer=array();
            $is_live=array();
            $userdata=array();


            $user = User::with(['followers','following','favourite'])->where('id','!=',$users->id)->where('user_type','1')->select('id','username','email','county_code','stream_token','level_id','stream_id','phone','user_type','gender',\DB::raw("IF(profile_pic LIKE '%https://%' , profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', profile_pic)) AS profile_pic"));     
                      
            if(isset($request->search_text) && ($request->search_text != '')) {
                $tags=$request->search_text;
                $user = $user->whereHas('usertag',function($q) use($tags){
                    return $q->leftjoin('tags', 'user_tags.tag_id', '=', 'tags.id')->where('tags.name',$tags);
                })->with('usertag');
            }
            if($request->category == 'popular'){
                $user = $user->orderBy('earned_gems','DESC')->limit(20)->get();
            }elseif($request->category == 'new_vj'){
                $user = $user->orderBy('created_at','DESC')->limit(20)->get();
            }elseif($request->category == 'live'){
               $user= $user->get();
            }else{
                $user= $user->get();
            }

            if($user!=""){
                foreach ($user as $key => $value) {
                    $is_block=UserBlock::where('from_id',$users->id)->where('to_id',$value->id)->count();
                    if($is_block==0){
                        $value->is_live=0;
                        $value->startTime=1613364473285;
                        $value->webRTCViewerCount=0;
                        $value->followers_count=count($value->followers) ;
                        $value->following_count=count($value->following) ;
                        $value->favourite_count=count($value->favourite) ;

                        unset($value->followers);
                        unset($value->following);
                        unset($value->favourite);

                        $is_follower=UserFollower::where('from_id',$value->id)->where('to_id',$users->id)->count();
                        $is_following=UserFollower::where('from_id',$users->id)->where('to_id',$value->id)->count();
                        $is_favourite=UserFavourite::where('from_id',$users->id)->where('to_id',$value->id)->count();

                        $value->is_follower=($is_follower==1)? true : false ;
                        $value->is_following=($is_following==1)? true : false ;
                        $value->is_favourite=($is_favourite==1)? true : false ;
                        $value->is_hot=1;
                        if($value->level_id<=2 ){
                            $value->is_hot=0;
                        }
                        $live=0;
                        if($request->category == 'live'){
                            if($streamlist->success){                            
                                foreach ($streamlist->data->channels as $antdata) {
                                    if($antdata->channel_name==$value->stream_id){
                                        $live=1;
                                        $latest_live = LiveStreamUser::where('stream_id',$value->stream_id)->orderBy('id','DESC')->first();
                                        $value->is_live=1;
                                        $value->streamId=$antdata->channel_name;
                                        $value->startTime=strtotime($latest_live->created_at);
                                        $randviewer=rand(20,30);
                                        $value->webRTCViewerCount=$antdata->user_count == 0 ? $randviewer + 0 : ($randviewer + $antdata->user_count) - 1;
                                        $userdata[]=$value;
                                        break;
                                    }
                                }
                            }else{
                                $userdata[]=$value;
                            }
                            if($live==0){
                                $userdata[]=$value;
                            }
                        }else{
                            if($streamlist->success){
                                foreach ($streamlist->data->channels as  $antdata) {
                                    if($antdata->channel_name==$value->stream_id){
                                        $latest_live = LiveStreamUser::where('stream_id',$value->stream_id)->orderBy('id','DESC')->first();
                                        $value->is_live=1;
                                        $value->streamId=$antdata->channel_name;
                                        $value->startTime=strtotime($latest_live->created_at);
                                        $randviewer=rand(20,30);
                                        $value->webRTCViewerCount=$antdata->user_count == 0 ? $randviewer + 0 : ($randviewer + $antdata->user_count) - 1;
                                    }
                                }
                            }
                            $userdata[]=$value;

                        }                            
                        
                        // $sorted[$key] = $value->startTime;
                        // $viewer[$key] = $value->webRTCViewerCount;
                        // $is_live[$key] = $value->is_live;
                    }
                }
            }
            

            // if(isset($request->search_text) && ($request->search_text != '')) {
            //     $temp=array();
            //     foreach($userdata as $key => $value){
            //         if(strval(stripos($value->username, $request->search_text))!=""){
            //             $temp[$key]=$value;
            //         }
            //     }
            //     $userdata=$temp;  
                  
            // }
            if($request->category == 'popular'){
                usort($userdata, function($a, $b) {
                    return $b['following_count'] - $a['following_count'];
                });
            }else{
                usort($userdata, function($a, $b) {
                    return $b['webRTCViewerCount'] - $a['webRTCViewerCount'];
                });
                usort($userdata, function($a, $b) {
                    return $b['is_live'] - $a['is_live'];
                });
            }

            $currentPage = Paginator::resolveCurrentPage();
            $col = collect($userdata);
            $perPage = 20;
            $currentPageItems = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $newdata=[];
            foreach($currentPageItems as $val){
                $newdata[]=$val;
            }
            $items = new Paginator($newdata, count($col), $perPage);
            
            return response()->json(['ResponseCode'=>1,'ResponseText'=>'Live Streamer all list Successfully. ','ResponseData'=>$items],200);

        } catch (\Exception $e){
            return response()->json(['ResponseCode' => 0,'ResponseText' => 'Something went wrong.'], 500);
        } 
    }

    // recommendedUserList
    public function recommendedUserList(Request $request)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
            }

            $rule=[
                'category'=>'required',
            ];
            $message=[
                'category.required'=>'category is required',
            ];
            $validate=Validator::make($request->all(),$rule,$message);

            if($validate->fails()){
                return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
            }

            $response=BaseFunction::agoraliveStreamList();
            $streamlist=json_decode($response);

            $sorted=array();
            $viewer=array();
            $is_live=array();
            $userdata=array();

            $users=User::with(['followers','following','favourite'])->where('id','!=',$user->id)->where('user_type','1')->select('id','username','email','county_code','stream_token','recommended','level_id','stream_id','phone','user_type','earned_gems','gender',\DB::raw("IF(profile_pic LIKE '%https://%' , profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', profile_pic)) AS profile_pic"));
            if($request->category == 'popular' || $request->category == 'Popular'){
                $users = $users->where('recommended',1)->orderBy('created_at','DESC')->limit(20)->get();
            }elseif($request->category == 'hot' || $request->category == 'Hot'){
                $users = $users->where('recommended',2)->orderBy('created_at','DESC')->limit(20)->get();
            }else{
                $users = $users->where('recommended',0)->orderBy('created_at','DESC')->limit(20)->get();
            }
            // dd($users);
            if($users!=""){
                foreach ($users as $key => $value) {
                    $is_block=UserBlock::where('from_id',$user->id)->where('to_id',$value->id)->count();
                    if($is_block==0){
                        $value->is_live=0;
                        $value->startTime=1613364473285;
                        $value->webRTCViewerCount=0;
                        $value->followers_count=count($value->followers) ;
                        $value->following_count=count($value->following) ;
                        $value->favourite_count=count($value->favourite) ;

                        unset($value->followers);
                        unset($value->following);
                        unset($value->favourite);

                        $is_follower=UserFollower::where('from_id',$value->id)->where('to_id',$user->id)->count();
                        $is_following=UserFollower::where('from_id',$user->id)->where('to_id',$value->id)->count();
                        $is_favourite=UserFavourite::where('from_id',$user->id)->where('to_id',$value->id)->count();

                        $value->is_follower=($is_follower==1)? true : false ;
                        $value->is_following=($is_following==1)? true : false ;
                        $value->is_favourite=($is_favourite==1)? true : false ;
                        $value->is_hot=1;
                        if($value->level_id <= 2){
                            $value->is_hot=0;
                        }else{
                            $hot_tag=HotTagSetting::first();
                            if($value->followers_count>=$hot_tag->followers && $value->earned_gems>=$hot_tag->salmon_coin){
                                $value->is_hot=2;
                            }
                        }

                        if($streamlist->success){
                            foreach ($streamlist->data->channels as  $antdata) {
                                if($antdata->channel_name==$value->stream_id){
                                    $latest_live = LiveStreamUser::where('stream_id',$value->stream_id)->orderBy('id','DESC')->first();
                                    $value->is_live=1;
                                    $value->streamId=$antdata->channel_name;
                                    $value->startTime=strtotime($latest_live->created_at);
                                    $randviewer=rand(20,30);
                                    $value->webRTCViewerCount=$antdata->user_count == 0 ? $randviewer + 0 : ($randviewer + $antdata->user_count) - 1;
                                }
                            }
                        }
                        
                        $userdata[]=$value;

                        // $sorted[$key] = $value->startTime;
                        // $viewer[$key] = $value->webRTCViewerCount;
                        // $is_live[$key] = $value->is_live;
                    }
                }
            }

            if(isset($request->search_text) && ($request->search_text != '')) {
                $temp=array();
                foreach($userdata as $key => $value){
                    if(strval(stripos($value->username, $request->search_text))!=""){
                        $temp[$key]=$value;
                    }
                }
                $userdata=$temp;

            }

            

            usort($userdata, function($a, $b) {
                return $b['is_live'] - $a['is_live'];
            });
            
            return response()->json(['ResponseCode'=>1,'ResponseText'=>'User List successfully.','ResponseData'=>$userdata],200);

        } catch (JWTException $e) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'could not create token'],500);
        } catch (\Exception $e){
            $message = $e->getMessage();
            return response()->json([
                'ResponseCode' => 0,
                'ResponseText' => 'Something went wrong.',
            ], 500);
        }
    }
}
