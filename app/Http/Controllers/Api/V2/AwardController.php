<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSpendGemsDetail;
use App\Models\UserFollower;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AwardController extends Controller
{
    public function userRewards(Request $request){
        $validate = Validator::make($request->all(), [            
            'type' => 'required',
        ]);
        try { 
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
            }

            $UserSpendGemsDetail = UserSpendGemsDetail::with(['user']);
            if($request->type == 'daily'){
                $UserSpendGemsDetail = $UserSpendGemsDetail->where('created_at','>=',date('Y-m-d').' 00:00:00');
            }
            if($request->type == 'monthly'){
                $UserSpendGemsDetail = $UserSpendGemsDetail->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            }        
            $UserSpendGemsDetail = $UserSpendGemsDetail->groupby('from_id')->selectRaw('sum(total_gems) as gems,from_id')->orderby('gems','DESC')->limit(10)->get();
            foreach ($UserSpendGemsDetail as $value) {
                $followercount = UserFollower::where('to_id',$value->from_id)->count();
                $is_follower=UserFollower::where('from_id',$user->id)->where('to_id',$value->from_id)->count();
                $value->is_follower=($is_follower==1)? true : false ;
                $value->followercount = $followercount;
            }
            return response()->json(['ResponseCode'=>1,'ResponseText'=>'User award list successfully. ','ResponseData'=>$UserSpendGemsDetail],200);
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


    public function broadcasterRewards(Request $request){
        $validate = Validator::make($request->all(), [            
            'type' => 'required',
        ]);
        try { 
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
            }
            $UserSpendGemsDetail = UserSpendGemsDetail::with(['boradcaster']);
            if($request->type == 'daily'){
                $todayDate = date('Y-m-d H:i:s');
                $UserSpendGemsDetail = $UserSpendGemsDetail->where('created_at','>=',date('Y-m-d').' 00:00:00');
            }
            if($request->type == 'monthly'){
                $UserSpendGemsDetail = $UserSpendGemsDetail->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            }        
            $UserSpendGemsDetail = $UserSpendGemsDetail->groupby('to_id')->selectRaw('sum(total_gems) as gems,to_id')->orderby('gems','DESC')->limit(10)->get();
            foreach ($UserSpendGemsDetail as $value) {
                $followercount = UserFollower::where('to_id',$value->to_id)->count();
                $is_follower=UserFollower::where('to_id',$value->to_id)->where('from_id',$user->id)->count();
                $value->is_follower=($is_follower==1)? true : false ;
                $value->followercount = $followercount;
            }
            return response()->json(['ResponseCode'=>1,'ResponseText'=>'broadcaster rewards list successfully. ','ResponseData'=>$UserSpendGemsDetail],200);
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
