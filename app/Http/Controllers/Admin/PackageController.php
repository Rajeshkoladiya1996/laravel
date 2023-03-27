<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Tag;

class PackageController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Bangkok');
    }
    
    public function index()
    {
        $tags=Tag::orderBy('name','ASC')->get();
        return view('admin.package.index',compact('tags'));
    }

    public function list(){
        $package=Package::orderBy('name','ASC')->get();
        return view('admin.package.packageList',compact('package'));   
    }

    public function store(Request $request){
         $this->validate($request,[
            'package_name'=>'required|unique:packages,name|min:2|regex:/^[a-zA-Z0-9 ]+$/u',
            'salmon_coin'=>'required|regex:/^[0-9]+$/u',
            'package_image'=>'required|mimes:jpeg,png,jpg',
            'price'=>'required|numeric',
            'sgd_price'=>'required|numeric',
            'thai_price'=>'required|numeric',
            'ios_product_id'=>'nullable|regex:/^[a-zA-Z0-9_.]+$/u',
            'android_product_id'=>'nullable|regex:/^[a-zA-Z0-9_.]+$/u',
        ]);

        $data = new Package;
        $data->name = $request->package_name;
        $data->slug = strtolower(str_replace(' ','-',$request->package_name));
        $data->salmon_coin=$request->salmon_coin;
        $image = $request->file('package_image');
        if ($image != null) {
            $new_name =  rand() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('/app/public/uploads/package/'), $new_name);
            $data->image = $new_name;
        }
        $data->price=$request->price;
        $data->sgd_price=$request->sgd_price;
        $data->thai_price=$request->thai_price;
        $data->ios_product_id = $request->ios_product_id;
        $data->android_product_id=$request->android_product_id;
        if($request->ios_product_id==null){
            $data->ios_is_active=0;
        }else{
            $data->ios_is_active=1;
        }
        if($request->android_product_id==null){
            $data->android_is_active=0;
        }else{
            $data->android_is_active=1;
        }

        if ($data->save()) {
            return 1;
        }else{
            return 0;
        }

    }

    public function edit($id)
    {
        $package=Package::where('id',$id)->first();
        return response()->json(['packageDetail'=>$package], 200);
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'edit_package_name'=>'required|unique:packages,name,'.$request->id.'|min:2|regex:/^[a-zA-Z0-9 ]+$/u',
            'edit_salmon_coin'=>'required|regex:/^[0-9]+$/u',
            'edit_price'=>'required|numeric',
            'edit_sgd_price'=>'required|numeric',
            'edit_thai_price'=>'required|numeric',
            'edit_package_image'=>'mimes:jpeg,png,jpg',
            'edit_ios_product_id'=>'nullable|regex:/^[a-zA-Z0-9_.]+$/u',
            'edit_android_product_id'=>'nullable|regex:/^[a-zA-Z0-9_.]+$/u',
        ]);

        $data = Package::findOrFail($request->id);
        $data->name = $request->edit_package_name;
        $data->slug=strtolower(str_replace(' ','-',$request->edit_package_name));
        $data->salmon_coin = $request->edit_salmon_coin;
        $image = $request->file('edit_package_image');
        if ($image != null) {
            $new_name =  rand() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('/app/public/uploads/package/'), $new_name);
            if(\File::exists(storage_path('app/public/uploads/package'.'/'.$data->image))){
                \File::delete(storage_path('app/public/uploads/package'.'/'.$data->image));             
            } 
            $data->image = $new_name;
        }
        $data->price=$request->edit_price;
        $data->SGD_price=$request->edit_sgd_price;
        $data->thai_price=$request->edit_thai_price;
        $data->ios_product_id=$request->edit_ios_product_id;
        $data->android_product_id = $request->edit_android_product_id;
        if($request->edit_ios_product_id==null){
            $data->ios_is_active=0;
        }else{
            $data->ios_is_active=1;
        }
        if($request->edit_android_product_id==null){
            $data->android_is_active=0;
        }else{
            $data->android_is_active=1;
        }

        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public function destroy(Request $request){
        $data=Package::where('id',$request->id)->first();
        if(\File::exists(storage_path('app/public/uploads/package'.'/'.$data->image))){
            \File::delete(storage_path('app/public/uploads/package'.'/'.$data->image));             
        }   
        $Package=Package::where('id', $request->id)->delete();
        if($Package){   
            return 1;
        }else{
            return 0;
        }
    }

    public function changeIOSStatus(Request $request)
    {
        $data = Package::findOrFail($request->id);
        if($request->status == 0){
            $data->ios_is_active = "1";
        }else{
            $data->ios_is_active = "0";
        }
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public function changeAndroidStatus(Request $request)
    {
        $data = Package::findOrFail($request->id);
        if($request->status == 0){
            $data->android_is_active = "1";
        }else{
            $data->android_is_active = "0";
        }
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }
}
