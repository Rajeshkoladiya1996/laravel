<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\RewardEvent;
use App\Models\EventParticipantDetail;
use App\Models\LiveStreamUser;
use Exception;
use Validator;
use JWTAuth;


class EventParticipantController extends Controller
{
    public function registerPartisipant(Request $request)
    {
        try {
            
            $validate = Validator::make($request->all(), [
                'event_type' => 'required',
                'stream_type' => 'required',
                'reward_type' => 'required',
                'user_id'=>'required',

            ]);

            // dd($request->all());
            if($validate->fails()){
                return response()->json(['ResponseCode'=>'0','ResponseText'=>$validate->errors()->all()[0],'ResponseData'=>['errors'=>$validate->errors()->all()]],499);
            }
            $current_date = date('Y-m-d');

            $current_events = Event::where('status',"1")->where('start_date','<=',$current_date)->where('end_date','>=',$current_date)->where('event_type',$request->event_type)->where('reward_type',$request->reward_type)->where('stream_type','like','%'.$request->stream_type.'%')->get();
            $livestream= LiveStreamUser::where('stream_id',$request->live_stream_id)->orderBy('id','DESC')->first();
            // dd($livestream);
            foreach ($current_events as $key => $value) {
            // dd($value->reward_type);
                $is_exists = EventParticipant::where('user_id',$request->user_id)->where('event_id',$value->id)->first();
                // $rewardList = RewardEvent::where('event_id',$value->id)->get();
                $event_participant = new EventParticipant;
                $evenet_id = "";
                if($value->reward_type=="gift"){                
                    $gift=explode(',', $value->gift_id);
                    if(in_array($request->gift_id,$gift)){                
                        if($is_exists == ""){
                            $event_participant->user_id = $request->user_id;
                            $event_participant->event_id = $value->id;
                            $event_participant->points = 0;
                            $event_participant->reward_type = $value->reward_type;
                            $event_participant->event_counts = 1;
                            $event_participant->save();
                            $evenet_id = $event_participant->id;
                        }else{
                            $event_participant->exists = true;
                            $event_participant->id = $is_exists->id;
                            $event_participant->points = 0;
                            $event_participant->event_counts = $is_exists->event_counts + 1;
                            $event_participant->save();
                            $evenet_id = $is_exists->id;
                        }
                        $eventParticipantDetail = new EventParticipantDetail;
                        $eventParticipantDetail->event_participant_id = $evenet_id;
                        if($request->gift_id != ""){
                            $eventParticipantDetail->gift_id = $request->gift_id;
                        } 
                        if($livestream != '' && $livestream->id != ""){
                            $eventParticipantDetail->live_stream_id = $livestream->id;
                        }
                        $eventParticipantDetail->points = 0;
                        $eventParticipantDetail->save();
                    }
                }
            
            }

            return response()->json(['ResponseCode'=>'1','ResponseText'=>'partisipant','ResponseData'=>[]],200);
        } catch (Exception $e) {
            return response()->json(['ResponseCode'=>'0','ResponseText'=>'Something went wrong.'],500);
        }
    }
}
