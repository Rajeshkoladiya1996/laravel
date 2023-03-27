<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppUpdateStatus;

class AppSettingsController extends Controller
{
    public function checkApp(Request $request)
    {
        if ($request->header('flag') != null) {
            $data=AppUpdateStatus::where('device_type',$request->header('flag'))->first();
            if($data->device_type=="iOS"){
                $data->ios_build="64";
            }
        }else{
            $data=AppUpdateStatus::all();
        }
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'App Update Status successfully. ','ResponseData'=>$data],200);
    }
}
