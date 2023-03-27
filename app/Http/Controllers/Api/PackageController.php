<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Package;
use App\Models\PackagePurchase;
use JWTAuth;
use Validator;

class PackageController extends Controller
{
    // packageList
    public function packageList(Request $request)
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
        }
        // \Log::info($request->header('flag'));
        if ($request->header('flag') != null) {
            if ($request->header('flag') == "iOS" || $request->header('flag') == "ios") {
                $data=Package::where('ios_is_active',1)->select('*',\DB::raw("IF(image LIKE '%https://%' , image , ". "CONCAT('".url('/storage/app/public/uploads/package/')."/', image)) AS image"))->get();
            }else if ($request->header('flag') == "Android" || $request->header('flag') == "android") {
                $data=Package::where('android_is_active',1)->select('*',\DB::raw("IF(image LIKE '%https://%' , image , ". "CONCAT('".url('/storage/app/public/uploads/package/')."/', image)) AS image"))->get(); 
            }else{
                $data=Package::where('ios_is_active',1)->orWhere('android_is_active',1)->select('*',\DB::raw("IF(image LIKE '%https://%' , image , ". "CONCAT('".url('/storage/app/public/uploads/package/')."/', image)) AS image"))->get(); 
            }
        }else{
            $data=Package::where('ios_is_active',1)->orWhere('android_is_active',1)->select('*',\DB::raw("IF(image LIKE '%https://%' , image , ". "CONCAT('".url('/storage/app/public/uploads/package/')."/', image)) AS image"))->get(); 
        }

        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Package list successfully. ','ResponseData'=>$data],200);
    }

    public function purchasePackage(Request $request)
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
        }
        $validate = Validator::make($request->all(), [            
            'package_id'=>'required',
            'purchase_date'=>'required',
            'device_type'=>'required',
            'purchase_details'=>'required',
            'purchase_status' => 'required',
        ]);

        if($validate->fails()){
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }

        $purchase = new PackagePurchase;
        $purchase->user_id=$user->id;
        $purchase->package_id=$request->package_id;
        $purchase->transaction_id=$request->transaction_id;
        $purchase->purchase_date=$request->purchase_date;
        $purchase->device_type=($request->header('flag') != null && $request->header('flag')!="")? $request->header('flag') : $request->device_type ;
        $purchase->purchase_details=json_encode($request->purchase_details);
        $purchase->purchase_status=$request->purchase_status;
        $purchase->save();
        if($request->purchase_status=="purchased"){  
            $package=Package::where('id',$request->package_id)->first();      
            $userData = User::where('id', $user->id)->first();
            $data['total_gems'] = $userData->total_gems + $package->salmon_coin;
            // $data['total_gems'] = $userData->total_gems + 1;
            User::where('id', $user->id)->update($data);
            return response()->json(['ResponseCode'=>1,'ResponseText'=>'Package Purchase successfully. ','ResponseData'=>[]],200);    
        }else{
            return response()->json(['ResponseCode'=>1,'ResponseText'=>'Package Purchase fails. ','ResponseData'=>[]],200);   
        }
    }

}
