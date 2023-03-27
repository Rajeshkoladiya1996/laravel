<?php

namespace App\Http\Controllers\Api;

use JWTAuth;
use Validator;
use App\Models\Gift;
use App\Models\User;
use App\Models\Reward;
use App\Models\ProgressPoints;
use Illuminate\Http\Request;
use App\Models\UserGemsDetail;
use App\Models\UserDailyReward;
use App\Models\UserRewardProgess;
use App\Models\Level;
use App\Http\Controllers\Controller;

class RewardController extends Controller
{
    public function allRewardList()
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
        }
        $total_days=date('t');
        $data = Reward::with(['gift'])->select('*','image',\DB::raw("CONCAT('".url('/storage/app/public/uploads/reward/')."/', image) AS image"))->limit($total_days)->get();
        
        $reward_progress = ProgressPoints::select('*','image',\DB::raw("CONCAT('".url('/storage/app/public/uploads/reward/')."/', image) AS image"))->get();

        
        $currdent_day = date("j",strtotime(date(now())));
        $from_day = date('Y-m')."-01";
        $to_day = date('Y-m-d');
        
        $is_collected_today = UserDailyReward::where('user_id',$user->id)->where('date',$to_day)->count();
        

        $collect_reward_data = UserDailyReward::where('user_id',$user->id)
                                            ->whereBetween('date',[$from_day,$to_day])
                                            ->get();
        $collect_progress_data = UserRewardProgess::where('user_id',$user->id)
                                            ->whereBetween('date',[$from_day,$to_day])
                                            ->get();
                                            
        foreach ($data as $value) {
            // 0. Upcoming Day Reward
            // 1. User Reward Taken 
            // 2. Skipped 
            // 3. Current Day

            $value->is_taken = 2;           
            if ($value->slug == 'day-'.$currdent_day) {
                $value->is_taken = 3; 
               
            }

            foreach ($collect_reward_data as $collect) {
                if ($value->id == $collect->reward_id) {
                    $value->is_taken = 1;
                }
            }
            if ($value->id > $currdent_day) {
                $value->is_taken = 0;
            }
        }

        foreach ($reward_progress as $value) {
            $value->is_taken = 0;    
            $value->name = 'EXP';    
            if ($value->slug == 'day-'.$currdent_day) {
                $value->is_taken = 3; 
            }   
            foreach ($collect_progress_data as $collect) {
                if ($value->id == $collect->progress_points_id) {
                    $value->is_taken = 1;
                }
            }    
        }
        
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Reward List successfully','ResponseData'=>['rewardlist'=>$data,'is_today_collect'=>$is_collected_today,'reward_progress'=>$reward_progress,'rewards_count'=>count($collect_reward_data)]],200); 
    }

    public function collectReward(Request $request)
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
        }

        $validate = Validator::make($request->all(), [            
            'reward_id' => 'required',
            'type'=>'required'
        ]);

        if($validate->fails()){
		  	return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],422);
		}

        $is_already_collect = UserDailyReward::where('reward_id',$request->reward_id)
                                                ->where('user_id',$user->id)
                                                ->where('date',date("Y-m-d"))->first();

        $assign_value = Reward::with('gift')->where('id',$request->reward_id)->first();

        if ($is_already_collect == "") {
            $data = new UserDailyReward;
            $data->reward_id = $request->reward_id;
            $data->user_id = $user->id;
            $data->date = date('Y-m-d');
            if($data->save()){

                $user_data = User::where('id',$user->id)->first();
                
                if ($request->type == 'Salmon Coins') {
                    User::where('id',$user->id)->update(['total_gems'=>$user_data->total_gems + $assign_value->type_value]);
                }
                if ($request->type == 'Gold Coins') {
                    User::where('id',$user->id)->update(['earned_gems'=>$user_data->earned_gems + $assign_value->type_value]);
                }
                if ($request->type == 'levelpoints') {
                    
                    $level=Level::where('id',$user_data->level_id)->first();

                    $point=$user_data->total_point + $assign_value->type_value;
                    $userdata['total_point']=$point;

                    if($point >= $level->total_point){
                        $levelNext=Level::where('id','>',$user_data->level_id)->first();
                        
                        if($levelNext!=""){
                            $userdata['level_id']=$levelNext->id;
                        }
                    }
                    User::where('id',$user->id)->update($userdata);
                }
                if ($request->type == 'gift') {
                    if ($assign_value->type == 'gift') {
                        $userGems = new UserGemsDetail;
                        $userGems->user_id = $user->id;
                        $userGems->gift_id = $assign_value->gift->id;
                        $userGems->gems = 0;
                        $userGems->qty = 1;
                        $userGems->spend_qty = 0;
                        $userGems->status = 1;
                        $userGems->save();
                    }
                }

                return response()->json(['ResponseCode'=>1,'ResponseText'=>'Reward collect successfully..','ResponseData'=>['is_taken'=>1]],200); 
            }else{
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'Something went wrong.'],500); 
            }
        }else{
            return response()->json(['ResponseCode'=>1,'ResponseText'=>'Reward already collected.'],200); 
        }
    }
    public function collectProgress(Request $request)
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
        }

        $validate = Validator::make($request->all(), [            
            'reward_progress_id' => 'required',
        ]);

        if($validate->fails()){
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],422);
        }
        $is_already_collect = UserRewardProgess::where('progress_points_id',$request->reward_progress_id)
                                                ->where('user_id',$user->id)
                                                ->where('date',date("Y-m-d"))->first();

        $assign_value = ProgressPoints::where('id',$request->reward_progress_id)->first();

        if ($is_already_collect == "") {
            $data = new UserRewardProgess;
            $data->progress_points_id = $request->reward_progress_id;
            $data->user_id = $user->id;
            $data->date = date('Y-m-d');
            if($data->save()){

                $user_data = User::where('id',$user->id)->first();
                $level=Level::where('id',$user_data->level_id)->first();

                $point=$user_data->total_point + $assign_value->points;
                $userdata['total_point']=$point;

                if($point >= $level->total_point){
                    $levelNext=Level::where('id','>',$user_data->level_id)->first();
                    
                    if($levelNext!=""){
                        $userdata['level_id']=$levelNext->id;
                    }
                }
                User::where('id',$user->id)->update($userdata);

                return response()->json(['ResponseCode'=>1,'ResponseText'=>'Reward progress collected successfully..','ResponseData'=>['is_taken'=>1]],200); 
            }else{
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'Something went wrong.'],500); 
            }
        }else{
            return response()->json(['ResponseCode'=>1,'ResponseText'=>'Reward progress already collected.'],200); 
        }
    }

}
