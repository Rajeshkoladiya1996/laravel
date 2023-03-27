<?php

namespace App\Http\Controllers\Admin;

use App\Models\LevelPoint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LevelPointController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Bangkok');
    }

    public function create()
    {
        $category = ["live room","consume","social networks","mission center"];
        return view('admin.level.create',compact('category'));
    }
   
    public function list()
    {
        $levelPointsList=LevelPoint::orderBy('id','DESC')->get();
        return view('admin.level.levelPointList',compact('levelPointsList'));
    }

    public function store(Request $request)
    {
        
        foreach ($request->level_detail['name'] as $key =>$value) {
            $level_point=new LevelPoint;
            $level_point->name=$request->level_detail['name'][$key];
            $level_point->description=$request->level_detail['description'][$key];        
            $level_point->category=$request->level_detail['category'][$key];        
            $level_point->points=$request->level_detail['point'][$key];
            $level_point->per_day=$request->level_detail['per_day'][$key];
            $level_point->save();
        }       
        return redirect()->route('admin.level');
    }

    public function edit($id)
    {
        $category = ["live room","consume","social networks","mission center"];
        $levelDetail=LevelPoint::where('id',$id)->first();
        return view('admin.level.create',compact('levelDetail','category'));
    }  

    public function update(Request $request)
    {
        foreach ($request->level_detail['name'] as $key =>$value) {
            $level_point=new LevelPoint;
            $level_point->exists = true;
            $level_point->id = $request->level_detail['id'][$key];
            $level_point->name=$request->level_detail['name'][$key];
            $level_point->description=$request->level_detail['description'][$key];        
            $level_point->category=$request->level_detail['category'][$key];        
            $level_point->points=$request->level_detail['point'][$key];
            $level_point->per_day=$request->level_detail['per_day'][$key];
            $level_point->save();
        }       
        return redirect()->route('admin.level');
    }

    public function destroy(Request $request)
    {
        $data=LevelPoint::where('id',$request->id)->delete();
        if($data){
            return 1;
        }else{
            return 0;
        }
    }
    
    public function changeStatus(Request $request)
    {
        $data = LevelPoint::find($request->id);
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

}

