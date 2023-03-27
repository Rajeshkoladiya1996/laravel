<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AvtarType;
use App\Models\AvtarCategory;

class AvtarTypeController extends Controller
{
    public function index(){
        $avtar = AvtarType::all();
        $category = AvtarCategory::all();
        return view('admin.avtar.index',compact('avtar','category'));
    }

    public function store(Request $request){

        $this->validate($request,[
            'avtar_name'=>'required',
            'avtar_slug'=>'required',
            'avtar_image'=>'required|mimes:jpeg,png,jpg,svg',
            'avtar_type'=>'required',
        ]);

        $data = new AvtarType;
        $data->name = $request->avtar_name;
        $data->avtar_type = $request->avtar_type;
        $data->slug=strtolower(str_replace(' ','-',$request->avtar_slug));
        $image = $request->file('avtar_image');
        if ($image != null) {
            $new_name =  rand() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('/app/public/uploads/avtar/'), $new_name);
            $data->image = $new_name;
        }
        if ($data->save()) {
            return 1;
        }else{
            return 0;
        }
    }

    public function list()
    {
        $avtar = AvtarType::all();
        return view('admin.avtar.avtarList',compact('avtar'));
    }

    public function edit($id)
    {
        $avtar=AvtarType::where('id',$id)->first();
        return response()->json(['avtar'=>$avtar], 200);
    } 

    public function destroy(Request $request)
    {
        $data=AvtarType::where('id',$request->id)->first();
        if(\File::exists(storage_path('app/public/uploads/avtar'.'/'.$data->image))){
            \File::delete(storage_path('app/public/uploads/avtar'.'/'.$data->image));             
        }   
        $avtar=AvtarType::where('id', $request->id)->delete();
        if($avtar){   
            return 1;
        }else{
            return 0;
        }
    }

    public function update(Request $request){

        $this->validate($request,[
            'edit_avtar_name'=>'required',
            'edit_avtar_slug'=>'required',
        ]);

        $data = AvtarType::findOrFail($request->id);
        $data->name = $request->edit_avtar_name;
        $data->slug=strtolower(str_replace(' ','-',$request->edit_avtar_slug));
        $data->avtar_type = $request->edit_avtar_type;

        if(isset($request->edit_avtar_image)){
            $image = $request->file('edit_avtar_image');
            if ($image != null) {
                $new_name =  rand() . '.' . $image->getClientOriginalExtension();
                $image->move(storage_path('/app/public/uploads/avtar/'), $new_name);

                if(\File::exists(storage_path('app/public/uploads/reward/avtar'.'/'.$data->image))){
                    \File::delete(storage_path('app/public/uploads/reward/avtar'.'/'.$data->image));             
                } 
                $data->image = $new_name;
            }
        }
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public function changeStatus(Request $request)
    {
        $data = new AvtarType;
        $data->exists = true;
        $data->id = $request->id;
        if($request->status == "0"){
            $data->status =1;
        }else{
            $data->status = 0;
        }
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }


    //  avtar Category 

    public function category(Request $request){
        $category = AvtarCategory::all();
        return view('admin.avtar.category',compact('category'));
    }

    public function storecategory(Request $request){
        $this->validate($request,[
            'category_name'=>'required',
            'category_image'=>'required',
            'class_name'=>'required',
        ]);

        $data = new AvtarCategory;
        $data->name = $request->category_name;
        $data->class_name = $request->class_name;
        $image = $request->file('category_image');
        if ($image != null) {
            $new_name =  rand() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('/app/public/uploads/avtar/category/'), $new_name);
            $data->image = $new_name;
        }
        if ($data->save()) {
            return 1;
        }else{
            return 0;
        }
    }

    public function categorylist()
    {
        $category = AvtarCategory::all();
        return view('admin.avtar.categoryList',compact('category'));
    }

    public function categorystatus(Request $request){
        $data = new AvtarCategory;
        $data->exists = true;
        $data->id = $request->id;
        if($request->status == "0"){
            $data->status =1;
        }else{
            $data->status = 0;
        }
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public function categorydelete(Request $request)
    {
        $data=AvtarCategory::where('id',$request->id)->first();
        if(\File::exists(storage_path('app/public/uploads/avtar/category'.'/'.$data->image))){
            \File::delete(storage_path('app/public/uploads/avtar/category'.'/'.$data->image));             
        }   
        $category=AvtarCategory::where('id', $request->id)->delete();
        if($category){   
            return 1;
        }else{
            return 0;
        }
    }

    public function editcategory($id)
    {
        $category=AvtarCategory::where('id',$id)->first();
        return response()->json(['category'=>$category], 200);
    } 

    public function updatecategory(Request $request)
    {
        $this->validate($request,[
            'edit_category_name'=>'required',
            'edit_class_name'=>'required',
  
        ]);

        $data = AvtarCategory::findOrFail($request->id);
        $data->name = $request->edit_category_name;
        $data->class_name = $request->edit_class_name;
        if(isset($request->edit_category_image)){
            $image = $request->file('edit_category_image');
            if ($image != null) {
                $new_name =  rand() . '.' . $image->getClientOriginalExtension();
                $image->move(storage_path('/app/public/uploads/avtar/category'), $new_name);

                if(\File::exists(storage_path('app/public/uploads/reward/avtar/category'.'/'.$data->image))){
                    \File::delete(storage_path('app/public/uploads/reward/avtar/category'.'/'.$data->image));             
                } 
                $data->image = $new_name;
            }
        }
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
        
    }

}
