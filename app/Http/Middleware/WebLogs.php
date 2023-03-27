<?php

namespace App\Http\Middleware;

use Exception;
use Closure;
use Auth;
use App\Models\WebLog;

class WebLogs
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
            // \Artisan::call('schedule:run');
            $log = new WebLog;
            $log->user_id = null;
            if ($user = Auth::user()) {
                $log->user_id = $user->id;
            }
            $log->ip_address = $request->ip();
            $log->browser = $request->header('user-agent');
            $log->uri = $request->getUri();
            $log->method = $request->getMethod();
            $log->request_body = json_encode($request->all());
            $log->response_status = $response->status();
            $log->response = json_encode($response);
            $log->save();

            return $response;
        } catch (Exception $e) {
            return $response;
        }
    }
}
