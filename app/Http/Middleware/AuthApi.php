<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use App\Models\User;
use App\Helper\BaseFunction;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AuthApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('authorization')==""){
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'Authorization Token not found']],409);
        }
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $checkuser=User::where('id',$user->id)->first();
            if($checkuser->is_active=='0'){
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'Unauthorized','ResponseData'=>['errors'=>'User account deactive by admin']],422);
            }
            if($request->header('device')!=""){            

                if($checkuser->device_id!=$request->header('device')){
                    $ip_address=($request->header('comefrom') != null)? $request->header('comefrom') : $request->ip();
                    $device_type=($request->header('flag')!=null)? $request->header('flag') : 'mobile';
                    BaseFunction::loginLogs($checkuser->id,$ip_address,'logout',$device_type);
                    JWTAuth::invalidate(JWTAuth::getToken());
                    return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'Token is Invalid']],409);
                }
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'Token is Invalid']],409);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'Token is Expired']],409);
            }else{
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'You are logged in another device. Please log in again.']],409);
            }
        }
        return $next($request);
    }
}
