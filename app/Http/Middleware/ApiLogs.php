<?php

namespace App\Http\Middleware;

use Exception;
use Closure;
use JWTAuth;
use App\Models\ApiLog;

class ApiLogs
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
        $response = $next($request);
        try {

            $log = new ApiLog;
            $log->user_id = null;
            if ($request->header('authorization') != null) {
                $user = JWTAuth::parseToken()->authenticate();
                $log->user_id = $user->id;
            }

            if ($request->header('comefrom') != null) {
                $log->ip_address = $request->header('comefrom');
            }else{
                $log->ip_address = $request->ip();
            }
            $log->device_type = "none";
            if ($request->header('flag') != null) {
                $log->device_type = $request->header('flag');
            }
            $log->uri = $request->getUri();
            $log->method = $request->getMethod();
            $log->request_body = json_encode($request->all());
            $log->response_status = $response->status();
            $log->response = json_encode($response);
            $log->save();

            return $response;
        } catch (Exception $e) {
            return $response;
            // return response()->json(['ResponseCode' => 0, 'ResponseText' => 'log fail', 'ResponseData' => ['errors' => 'Somthing went wrong']], 409);
        }
    }
}
