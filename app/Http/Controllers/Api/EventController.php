<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\UserFollower;
use App\Models\UserFavourite;
use Validator;
use JWTAuth;

class EventController extends Controller
{
    public function eventList(Request $request)
    {
    	if (! $users = JWTAuth::parseToken()->authenticate()) {
    	    return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
    	}

        if(isset($request->type) && $request->type!=""){
            if($request->type=='vj'){
                $eventList=Event::where('status','1')->where('event_type','vj')->select('*',\DB::raw("CONCAT('".url('/storage/app/public/uploads/event/')."/', image) AS image"))->get();
            }else{

    	       $eventList=Event::where('status','1')->where('event_type','user')->select('*',\DB::raw("CONCAT('".url('/storage/app/public/uploads/event/')."/', image) AS image"))->get();
            }
        }else{
           $eventList=Event::where('status','1')->where('event_type','vj')->select('*',\DB::raw("CONCAT('".url('/storage/app/public/uploads/event/')."/', image) AS image"))->get();
        }


    	return response()->json(['ResponseCode'=>1,'ResponseText'=>'Event List successfully','ResponseData'=>$eventList],200); 
    }

    public function eventDetail(Request $request)
    {
        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }
        $validate = Validator::make($request->all(), [
            'id' => 'required',
         ]);

         if($validate->fails())
         {
             return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
         }

        $userList =EventParticipant::with(['user'])->where('event_id',$request->id)->orderBy('event_counts','desc')->limit(50)->get();
        foreach ($userList as $key => $value) {
            $value->followers=UserFollower::where('to_id',$value->user->id)->count();
            $value->following=UserFollower::where('from_id',$value->user->id)->count();
            $value->favourite=UserFavourite::where('from_id',$value->user->id)->count();
            
            $is_follower=UserFollower::where('from_id',$users->id)->where('to_id',$value->user->id )->count();
            $is_following=UserFollower::where('from_id',$value->user->id )->where('to_id',$users->id)->count();
            $is_favourite=UserFavourite::where('from_id', $value->user->id)->where('to_id',$users->id)->count();
            $value->is_follower=($is_follower==1)? true : false ;
            $value->is_following=($is_following==1)? true : false ;
            $value->is_favourite=($is_favourite==1)? true : false ;
        }

        $eventList=Event::with('reward_event')->where('id',$request->id)->where('status','1')->select('*',\DB::raw("CONCAT('".url('/storage/app/public/uploads/event/')."/', image) AS image"))->first();
        date_default_timezone_set("Asia/Bangkok");
        $eventList->nowdate=date('Y-m-d H:i:s');
        $eventList['participant'] =$userList; 
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Event detail','ResponseData'=>$eventList],200); 
    }
}
