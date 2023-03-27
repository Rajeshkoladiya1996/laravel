<?php

namespace App\Http\Controllers\Api;

use JWTAuth;
use Validator;
use App\Models\User;
use App\Models\Level;
use App\Models\LevelPoint;
use App\Models\LevelDetail;
use App\Helper\BaseFunction;
use Illuminate\Http\Request;
use App\Models\UserLevelDetail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class LevelController extends Controller
{
    // All Level List  
    public function allLeveList(Request $request)
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
        }
        $levelList=Level::with('level_detail')->get();
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'All level successfully','ResponseData'=>$levelList],200); 
    }

    // User wise level list  
    public function userLeveList(Request $request)
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
        }
        
        $loginuser=compact('user');
        $userList=User::where('id',$loginuser['user']->id)->first();

        $levelList=Level::with('level_detail')->where('id',$userList->level_id)->first();
        $levelList->level=(isset(explode('-',$levelList->slug)[1]))? explode('-',$levelList->slug)[1] :0;
        $levelList->user_total_point=$userList->total_point;
        $levelList->total_level=Level::all()->count();
        foreach ($levelList->level_detail as $value) {
            $checkLevel=UserLevelDetail::where('user_id',$loginuser['user']->id)->where('level_detail_id',$value->id)->count();
            $value->is_copmelete=($checkLevel==0)? 0:1;
        }
        $levelNext=Level::with('level_detail')->where('id','>',$userList->level_id)->first();
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'User level successfully','ResponseData'=>$levelList,'levelNext'=>$levelNext],200); 
    }

    public function levelPointList(Request $request)
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
        }
        $levelList=LevelPoint::all();
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Level point successfully','ResponseData'=>$levelList],200); 
    }
    
    // User wise level list  
    public function newuserLeveList(Request $request)
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
        }
        
        $loginuser=compact('user');
        $userList=User::where('id',$loginuser['user']->id)->first();
        $levelList=Level::where('id',$userList->level_id)->first();
        $levelList->user_total_point=$userList->total_point;               
        $levelNext=Level::where('id','>',$userList->level_id)->first();
        $levelpointList=LevelPoint::all();
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'User level successfully','ResponseData'=>['currentlevel'=>$levelList,'levelNext'=>$levelNext,'levelpointList'=>$levelpointList]],200); 
    }   

    public function chatLevelIncrease(Request $request)
    {
        // Log::info("message");
        // Log::info($request->data['type']);
        Log::info($request->all());
        
        $type = $request->data['type'];

        if (!isset($request->data['user_id'])) {
            Log::info("user_id IS NOT SET=====>".$request->data['from_id']);
            $user_id = $request->data['from_id'];
        }else{
            Log::info("user_id IF SET=====>".$request->data['user_id']);
            $user_id = $request->data['user_id'];
        }
        
        // return 1;
        // exit;


        // if (!isset($request->data['user_id']) &&  $request->data['user_id'] == "") {
        //     Log::info("from_id=====>".$request->data['from_id']);
        //     $user_id = $request->data['from_id'];
        // }else{
        //     Log::info("user_id=====>");
        //     Log::info("user_id=====>".$request->data['user_id']);
        //     $user_id = $request->data['user_id'];
        // }
        
        $userdetail=User::where('id',$user_id)->first();
        Log::info("userdetail=====>".$userdetail);

        if ($type == "send_message") {

            if($userdetail->level_id != ""){		
                BaseFunction::levelIncrease($userdetail,$user_id,2);
            }
        }elseif($type == "send_gift") {
            if($userdetail->level_id != ""){		
                BaseFunction::levelIncrease($userdetail,$user_id,5);
            }
        }elseif($type == "view") {
            Log::info("view");
            if($userdetail->level_id != ""){		
                BaseFunction::levelIncrease($userdetail,$user_id,1);
            }
        }

        return 1;
    }
}
