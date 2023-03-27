<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppUpdateStatus;
use App\Models\HotTagSetting;
use App\Models\SocialMedia;

class AppSettingsController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Bangkok');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataList = AppUpdateStatus::all();
        $hotTag = HotTagSetting::first();
        return view('admin.app-settings.index',compact('dataList','hotTag'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $dataList = AppUpdateStatus::all();
        return view('admin.app-settings.appSettingList',compact('dataList'));
    }

    public function getHotTagSetting(){
        $dataList = HotTagSetting::all();
        return view('admin.app-settings.hotTagSettingList',compact('dataList'));
    }

    public function getSocialMedia(){
        $dataList = SocialMedia::first();
        return view('admin.app-settings.socialMedia',compact('dataList'));
    }

    public function updateSocialMedia(Request $request){
        $data =SocialMedia::first();
        $data->facebook = $request->facebook;
        $data->instagram=$request->instagram;
        $data->tiktok =  $request->tiktok;
        $data->mail = $request->mail;
        $data->bklive = $request->site;
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public function editHotTag($id){
        $data=HotTagSetting::where('id',$id)->first();
        return $data;
    }

    public function updateHotTag(Request $request)
    {
        $this->validate($request,[
            'follower'=>'required',
            'salmonCoin'=>'required'
        ]);

        $data = HotTagSetting::find($request->htid);
        $data->followers = $request->follower;
        $data->salmon_coin = $request->salmonCoin;
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'device_type'=>'required',
            'app_version'=>'required',
            'update_force'=>'required',
            'is_production'=>'required',
            'contant_update_day'=>'required',
        ]);
        
        $appupdate = new AppUpdateStatus;
        $appupdate->device_type = $request->device_type;
        $appupdate->app_version = $request->app_version;
        $appupdate->update_force = $request->update_force;
        $appupdate->is_production = $request->is_production;
        $appupdate->message = $request->message;
        $appupdate->contant_update_day = $request->contant_update_day;
        if($appupdate->save()){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return AppUpdateStatus::where('id',$id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'device_type'=>'required',
            'app_version'=>'required',
            'update_force'=>'required',
            'is_production'=>'required',
            'contant_update_day'=>'required',
        ]);

        $appupdate= new AppUpdateStatus;
        $appupdate->exists = true;
        $appupdate->id = $request->id;
        $appupdate->device_type = $request->device_type;
        $appupdate->app_version = $request->app_version;
        $appupdate->update_force = $request->update_force;
        $appupdate->is_production = $request->is_production;
        $appupdate->message = $request->message;
        $appupdate->contant_update_day = $request->contant_update_day;
        if($appupdate->save()){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $appupdate=AppUpdateStatus::where('id', $request->id)->delete();
        if($appupdate){   
            return 1;
        }else{
            return 0;
        }
    }

    public function changeAppUpdateStatus(Request $request)
    {
        $data = new AppUpdateStatus;
        $data->exists = true;
        $data->id = $request->id;
        if($request->update_force == "0"){
            $data->update_force =1;
        }else{
            $data->update_force = 0;
        }
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public function changeAppProductionStatus(Request $request)
    {
        $data = new AppUpdateStatus;
        $data->exists = true;
        $data->id = $request->id;
        if($request->is_production == "0"){
            $data->is_production =1;
        }else{
            $data->is_production = 0;
        }
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public function changeAppFestiveStatus(Request $request)
    {
        $data = new AppUpdateStatus;
        $data->exists = true;
        $data->id = $request->id;
        if($request->is_festival == 0){
            $data->is_festival = 1;
        }else{
            $data->is_festival = 0;
        }
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public function changeAppDevelopStatus(Request $request)
    {
        $data = new AppUpdateStatus;
        $data->exists = true;
        $data->id = $request->id;
        if($request->is_develop == "0"){
            $data->is_develop =1;
        }else{
            $data->is_develop = 0;
        }
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }
}
