<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gift;
use App\Models\Reward;
use App\Models\ProgressPoints;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgessPointsController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Bangkok');
    }
    
    public function index()
    {
        $rewardType = ["gift","gems","diamonds","levelpoints"];
        $giftList=Gift::where('status','1')->orderBy('name','ASC')->get();
        $rewardList = Reward::with('gift')->get();
        $rewardpointsList = ProgressPoints::get();
        return view('admin.reward.index',compact('rewardList','rewardType','giftList','rewardpointsList'));
    }
    
    public function edit($slug)
    {
        $levelDetail=ProgressPoints::where('id',$slug)->first();
        return $levelDetail;
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'reward_name'=>'required|min:2',
            'day'=>'required',
            'reward_image'=>'mimes:jpeg,png,jpg,svg',
        ]);

        $data = ProgressPoints::findOrFail($request->id);
        $data->name = $request->reward_name;
        $data->day = $request->day;
        $data->points = $request->reward_points;
        $data->slug=strtolower(str_replace(' ','-',$request->reward_name));

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

    public function getList(){
        $rewardpointsList = ProgressPoints::all();
        return view('admin.reward.rewardPointList',compact('rewardpointsList'));
    }

}
