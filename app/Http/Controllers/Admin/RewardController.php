<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gift;
use App\Models\Reward;
use App\Models\ProgressPoints;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RewardController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Bangkok');
    }

    public function index()
    {
        $rewardType = ["gift","Salmon Coins","Gold Coins","levelpoints"];
        $giftList=Gift::where('status','1')->orderBy('name','ASC')->get();
        $rewardList = Reward::with('gift')->get();
        // dd($rewardList);
        $rewardpointsList = ProgressPoints::get();
        return view('admin.reward.index',compact('rewardList','rewardType','giftList','rewardpointsList'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'reward_name'=>'required|min:2',
            'description'=>'required',
            'reward_image'=>'required|mimes:jpeg,png,jpg,svg',
            'reward_type'=>'required',
        ]);

        if (isset($request->txt_gift)) {
            $type_value = $request->txt_gift;
        }else if(isset($request->reward_type_value)) {
            $type_value = $request->reward_type_value;
        }
        
        $data = new Reward;
        $data->name = $request->reward_name;
        $data->description = $request->description;
        $data->type = $request->reward_type;
        $data->type_value = $type_value;
        $data->slug=strtolower(str_replace(' ','-',$request->reward_name));
        $image = $request->file('reward_image');
        if ($image != null) {
            $new_name =  rand() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('/app/public/uploads/reward/'), $new_name);
            $data->image = $new_name;
        }
        if ($data->save()) {
            return 1;
        }else{
            return 0;
        }
    }

    public function getList()
    {
        $rewardList = Reward::all();
        return view('admin.reward.rewardList',compact('rewardList'));
    }

    public function destroy(Request $request)
    {
        $data=Reward::where('id',$request->id)->first();
        if(\File::exists(storage_path('app/public/uploads/reward'.'/'.$data->image))){
            \File::delete(storage_path('app/public/uploads/reward'.'/'.$data->image));             
        }   
        $reward=Reward::where('id', $request->id)->delete();
        if($reward){   
            return 1;
        }else{
            return 0;
        }
    }

    public function edit($id)
    {
        $rewardType = ["gift","Salmon Coins","Gold Coins","levelpoints"];
        $giftList=Gift::where('status','1')->orderBy('name','ASC')->get();
        $rewardDetail=Reward::where('id',$id)->first();
        return response()->json(['rewardDetail'=>$rewardDetail,'rewardType'=>$rewardType,'giftList'=>$giftList], 200);
    }  

    public function update(Request $request)
    {
        $this->validate($request,[
            'reward_name'=>'required|min:2',
            'description'=>'required',
            'reward_image'=>'mimes:jpeg,png,jpg,svg',
        ]);
        
        $data = Reward::findOrFail($request->id);
        $data->name = $request->reward_name;
        $data->description = $request->description;
        $data->slug=strtolower(str_replace(' ','-',$request->reward_name));
        if (isset($request->txt_gift)) {
            $type_value = $request->txt_gift;
        }else if(isset($request->reward_type_value)) {
            $type_value = $request->reward_type_value;
        }

        $data->type = $request->reward_type;
        $data->type_value = $type_value;

        if(isset($request->reward_image)){
            $image = $request->file('reward_image');
            if ($image != null) {
                $new_name =  rand() . '.' . $image->getClientOriginalExtension();
                $image->move(storage_path('/app/public/uploads/reward/'), $new_name);

                if(\File::exists(storage_path('app/public/uploads/reward'.'/'.$data->image))){
                    \File::delete(storage_path('app/public/uploads/reward'.'/'.$data->image));             
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
        $data = new Reward;
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
}
