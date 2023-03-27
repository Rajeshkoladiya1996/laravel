<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveStreamReport;

class LivestreamReportController extends Controller
{
    public function index(Request $request)
    {
        $liveStreamReport = LiveStreamReport::with('from_user','to_user')->get();
        return view('admin.liveStreamReport.index',compact('liveStreamReport'));
    }

    public function liveStreamReportList(Request $request)
    {      
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        $members = LiveStreamReport::with('from_user','to_user');
        // $members = $members->where('is_active', 1);
        if (!isset($request->order)) {
            $members = $members->orderby('id', 'DESC');
        } else {
            $columns = $request->order[0]['column'];
            $order = $request->order[0]['dir'];
            $name_field = $request->columns[$columns]['data'];
            if ($request->order[0]['column'] == 0) {
                $members = $members->orderby($name_field, $order);
            }
        }
        $members = $members->paginate($length, ['*'], 'page', $page);

        foreach ($members as $key => $value) {
            if (!filter_var($value['from_user']->profile_pic, FILTER_VALIDATE_URL)) {
                if (\File::exists(storage_path('app/public/uploads/users' . '/' . $value['from_user']->profile_pic))) {
                    $value->from_profile_pic = '<span class="tabel-profile-img"><img src="' . url('storage/app/public/uploads/users/' . $value['from_user']->profile_pic) . '" alt=""></span>' . $value['from_user']->username.'<br/>'.strtolower($value['from_user']->stream_id);
                } else {
                    $value->from_profile_pic = '<span class="tabel-profile-img"><img src="' . url('storage/app/public/uploads/users/default.png') . '" alt=""></span>' . $value['from_user']->username.'<br/>'.strtolower($value['from_user']->stream_id);
                }
            } else {
                $value->from_profile_pic = '<span class="tabel-profile-img"><img src="' . $value['from_user']->profile_pic . '" alt=""></span>' . $value['from_user']->username.'<br/>'.strtolower($value['from_user']->stream_id);
            }  

            if (!filter_var($value->to_user->profile_pic, FILTER_VALIDATE_URL)) {
                if (\File::exists(storage_path('app/public/uploads/users' . '/' . $value->to_user->profile_pic))) {
                    $value->to_profile_pic = '<span class="tabel-profile-img"><img src="' . url('storage/app/public/uploads/users/' . $value->to_user->profile_pic) . '" alt=""></span>' . $value->to_user->username.'<br/>'.strtolower($value->to_user->stream_id);
                } else {
                    $value->to_profile_pic = '<span class="tabel-profile-img"><img src="' . url('storage/app/public/uploads/users/default.png') . '" alt=""></span>' . $value->to_user->username.'<br/>'.strtolower($value->to_user->stream_id);
                }
            } else {
                $value->to_profile_pic = '<span class="tabel-profile-img"><img src="' . $value->to_user->profile_pic . '" alt=""></span>' . $value->to_user->username.'<br/>'.strtolower($value->to_user->stream_id);
            } 
            if($value->is_active==0){
                $value->status="<p class='pending check_status ' data-id='".$value->id."' data-status='".$value->is_active."' >De-active</p>";
            }else{
                $value->status="<p class='paid check_status ' data-id='".$value->id."' data-status='".$value->is_active."' >Active</p>";
            }

            $value->action = "<a href='javascript:void(0)' id='deleteLiveStreamReport' data-id='".$value->id."' data-type='liveStreamReportlist'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'><path fill='none' d='M0 0h24v24H0z' /><path d='M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm-8 5v6h2v-6H9zm4 0v6h2v-6h-2zM9 4v2h6V4H9z' fill='rgba(255,0,0,1)' /></svg></a>";
        }
        $members = (array)json_decode(json_encode($members));
        $data = array(
        'draw' => $draw,
        'recordsTotal' => $members['total'],
        'recordsFiltered' => $members['total'],
        'data' => $members['data'],
        );

        echo json_encode($data);
       
    }

    public function changeStatus(Request $request)
    {
        $data = LiveStreamReport::find($request->id);
        if($data->is_active==1){
            $data->is_active = 0;
        }else{
            $data->is_active = 1;
        }
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public function destroy(Request $request)
    {
        $data=LiveStreamReport::where('id', $request->id)->delete();
        if($data){   
            return 1;
        }else{
            return 0;
        }
    }
}
