<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    
    public function __construct()
    {
        date_default_timezone_set('Asia/Bangkok');
    }
    
    public function index()
    {
        $tags=Tag::orderBy('name','ASC')->get();
        return view('admin.tag.index',compact('tags'));
    }

    public function list(){
        $tags=Tag::orderBy('name','ASC')->get();
        return view('admin.tag.tagList',compact('tags'));   
    }


    public function store(Request $request){
        $this->validate($request,[
            'tagname'=>'required|unique:tags,name|regex:/^[a-zA-Z0-9 ]+$/u',
            'color'=>'required|regex:/^[a-zA-Z0-9#]+$/u',
        ]);

        $data = new Tag;
        $data->name = $request->tagname;
        $data->color=$request->color;
        $data->slug =  strtolower(str_replace(' ', '-', $request->tagname));
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public function edit($id)
    {
        $tag=Tag::where('id',$id)->first();
        return $tag;
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:tags,name,'.$request->id.'|regex:/^[a-zA-Z0-9 ]+$/u',
            'color'=>'required|regex:/^[a-zA-Z0-9#]+$/u',
        ]);

        $data = Tag::find($request->id);
        $data->exists = true;
        $data->id = $request->id;
        $data->name = $request->name;
        $data->color=$request->color;
        $data->slug =  strtolower(str_replace(' ', '-', $request->name));
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public function changeStatus(Request $request)
    {
        $data = Tag::find($request->id);
        if($data->status==1){
            $data->status = 0;
        }else{
            $data->status = 1;
        }
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public function destroy(Request $request)
    {
        $data=Tag::where('id', $request->id)->delete();
        if($data){   
            return 1;
        }else{
            return 0;
        }
    }
}
