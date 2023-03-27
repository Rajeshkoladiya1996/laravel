<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveStreamReport;
use JWTAuth;
use Validator;

class LivestreamReportController extends Controller
{
    public function liveStreamReport(Request $request)
    {
        $validate =Validator::make($request->all(), [
            'to_user_id' => 'required',
            'reason' => 'required'
        ]);
        if($validate->fails())
        {
            return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }

        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
        }

        if($users->id==$request->to_user_id){
            return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>['Invalid user id']]],499);
        }
        $check=LiveStreamReport::where('from_user_id',$users->id)->where('to_user_id',$request->to_user_id)->where('is_active',1)->first();
        if($check==""){     
            $livestreamreport =new LiveStreamReport;
            $livestreamreport->from_user_id=$users->id;
            $livestreamreport->to_user_id=$request->to_user_id;
            $livestreamreport->reason=$request->reason;
            $livestreamreport->save();
            return response()->json(['ResponseCode'=>1,'ResponseText'=>'Live Streamer report successfully'],200);
        }else{
            return response()->json(['ResponseCode'=>1,'ResponseText'=>'Live Streamer report is exists!'],200);
        }
    }
}
