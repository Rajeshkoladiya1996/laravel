<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\User;
use App\Models\Level;
use App\Models\LevelPoint;
use App\Models\LevelDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LevelController extends Controller
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
        if(Auth::user()->hasRole('admin')){
            return redirect()->route('admin');
        }
        $levelList=Level::orderBy('id','DESC')->get();
        $levelPointsList = LevelPoint::orderBy('id')->get();
        return view('admin.level.index',compact('levelList','levelPointsList'));
    }

    public function list()
    {
        $levelList=Level::orderBy('id','DESC')->get();
        return view('admin.level.levelList',compact('levelList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.level.create');
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
            'level_name'=>'required|min:2|unique:levels,name',
            'description'=>'required',
            'points'=>'required',
        ]);

        $data = Level::latest()->first();
        if($request->points <= $data->total_point){
            return response()->json(["message"=>"The given data was invalid.","errors"=>["points"=>["Please enter higher point greater than ".$data->total_point]]],422);
        }

        $level=new Level;
        $level->name=$request->level_name;
        $level->slug=strtolower(str_replace(' ','-',$request->level_name));
        $level->description=$request->description;
        $level->total_point=$request->points;
        if($level->save()){
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
    public function edit($slug)
    {
        $levelDetail=Level::where('id',$slug)->first();
        return $levelDetail;
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
            'level_name'=>'required|min:2|unique:levels,name,'.$request->id,
            'description'=>'required',
            'points'=>'required',
        ]);

        $prev =  Level::where('id', '<', $request->id)->latest('id')->first();
        $next =  Level::where('id', '>', $request->id)->oldest('id')->first();

        if($prev != "" && $next != ""){
            if ($request->points >= $next->total_point && $request->points >= $prev->total_point) {
                return response()->json(["message"=>"The given data was invalid.","errors"=>["points"=>["Please enter point between ".$prev->total_point." and ".$next->total_point]]],422);
                
            }
        }else if($prev != ""){
            if($request->points <= $prev->total_point){
                return response()->json(["message"=>"The given data was invalid.","errors"=>["points"=>["Please enter higher point greater than ".$prev->total_point]]],422);
            }
        }else if($next != ""){
            if($request->points >= $next->total_point){
                return response()->json(["message"=>"The given data was invalid.","errors"=>["points"=>["Please enter higher point less than ".$next->total_point]]],422);
            }
        }

        $level = new Level;
        $level->id=$request->id;
        $level->exists = true;
        $level->name=$request->level_name;
        $level->slug=strtolower(str_replace(' ','-',$request->level_name));
        $level->description=$request->description;
        $level->total_point=$request->points;
        if($level->save()){
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
        $this->validate($request,[
            'id'=>'required',
        ]);
        $data=Level::where('id',$request->id)->delete();
        if($data){
            return 1;
        }else{
            return 0;
        }
    }

    public function destroyDetail(Request $request)
    {
        $this->validate($request,[
            'id'=>'required',
        ]);
        $data=LevelDetail::where('id',$request->id)->delete();
        if($data){
            return 1;
        }else{
            return 0;
        }
    }

    public function checkPoint(Request $request)
    {
        if(isset($request->id)){
            $prev =  Level::where('id', '<', $request->id)
                            ->latest('id')
                            ->first();
            $next =  Level::where('id', '>', $request->id)
            ->oldest('id')
            ->first();

            if($prev != "" && $next != ""){
                if ($request->points >= $next->total_point && $request->points >= $prev->total_point) {
                    return "Please enter point between ".$prev->total_point." and ".$next->total_point;
                }
            }else if($prev != ""){
                if($request->points <= $prev->total_point){
                    return "Please enter higher point greater than ".$prev->total_point;
                }
            }else if($next != ""){
                if($request->points >= $next->total_point){
                    return "Please enter higher point less than ".$next->total_point;
                }
            }
            return 0;
        }else{
            $data = Level::latest()->first();
            if($request->points <= $data->total_point){
                return $data;
            }else{
                return 0;
            }
        }
        
    }

    public function levelName(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'level_name'=>'required|unique:levels,name',
        ]);
        if($validation->fails())
        {   
            return 'false';
        }else{
            return 'true';
        }            
    }

    public function changeStatus(Request $request)
    {
        $data = Level::find($request->id);
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
