<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\LiveStreamUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserReportController extends Controller
{
    public function index(Request $request)
    {
        $viewerList = User::users()->withCount('follower', 'following')->where('user_type', 1)->orderBy('id', 'desc')->get();
        return view('admin.userReport.index',compact('viewerList'));
    }

    public function userReportList(Request $request)
    {

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];
        $members=['total'=>0,'data'=>[]];
        if($start_date !='' && $end_date!=''){
            

            $members = User::users()->whereHas('liveStream',function($query) use($start_date,$end_date){
                $query->where('created_at', '>=',$start_date);
                $query->where('created_at','<=',$end_date);
            });
            if ($search != "") {
                $members = $members->where(function ($q) use ($search) {
                    $q->where('email', 'like', '%' . $search . '%')
                        ->orWhere('username', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('login_type', 'like', '%' . $search . '%')
                        ->orWhere('earned_gems', 'like', '%' . $search . '%');
                });
            }
            $members = $members->where('user_type', 1);
            if (!isset($request->order)) {
                $members = $members->orderby('users.id', 'DESC');
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
                if (!filter_var($value->profile_pic, FILTER_VALIDATE_URL)) {
                    if (\File::exists(storage_path('app/public/uploads/users' . '/' . $value->profile_pic))) {
                        $value->profile_pic = '<span class="tabel-profile-img"><img src="' . url('storage/app/public/uploads/users/' . $value->profile_pic) . '" alt=""></span>' . $value->username . '</br>'.strtolower($value->stream_id);
                    } else {
                        $value->profile_pic = '<span class="tabel-profile-img"><img src="' . url('storage/app/public/uploads/users/default.png') . '" alt=""></span>' . $value->username. '</br>'.strtolower($value->stream_id);
                    }
                } else {
                    $value->profile_pic = '<span class="tabel-profile-img"><img src="' . $value->profile_pic . '" alt=""></span>' . $value->username.'</br>'.strtolower($value->stream_id);
                }   

                $weeklydata = LiveStreamUser::where('user_id',$value->id)->where('created_at', '>=',$start_date)->where('created_at','<=',$end_date)->get();
                $total_time=0;
                foreach ($weeklydata as $key => $data) {
                    $interval = Carbon::parse($data->updated_at)->timestamp - Carbon::parse($data->created_at)->timestamp;
                    $total_time = $total_time + $interval;
                }

                $diff_in_days = LiveStreamUser::where('user_id',$value->id)->where('created_at', '>=',$start_date)->where('created_at','<=',$end_date)->select(\DB::raw('DATE(created_at) as date'))->groupBy('date')->get();
            $value->weekly = '<span style="color:#ec008c; font-weight:600;">'. count($diff_in_days) . '</span> | ' . gmdate('H:i:s',$total_time);
                $value->action = '<a href="javascript:void(0)" class="btn btn-info viewDetails" data-id="'.$value->id.'" id="view_report_retails">View</a>';

            }
            $members = (array)json_decode(json_encode($members));
        }
        $data = array(
            'draw' => $draw,
            'recordsTotal' => $members['total'],
            'recordsFiltered' => $members['total'],
            'data' => $members['data'],
        );
        echo json_encode($data);
    }
    

    public function userReportDetails(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $users = User::users()->where('id',$request->id)->first();
        $livesteamers=LiveStreamUser::where('created_at', '>=',$start_date)->where('created_at','<=',$end_date)->where('user_id',$request->id)->get();

        
        $weeklydata = LiveStreamUser::where('user_id',$request->id)->where('created_at', '>=',$start_date)->where('created_at','<=',$end_date)->get();
        $total_time=0;
        foreach ($weeklydata as $key => $data) {
            $interval = Carbon::parse($data->updated_at)->timestamp - Carbon::parse($data->created_at)->timestamp;
            $total_time = $total_time + $interval;
        }

        $diff_in_days = LiveStreamUser::where('user_id',$request->id)->where('created_at', '>=',$start_date)->where('created_at','<=',$end_date)->select(\DB::raw('DATE(created_at) as date'))->groupBy('date')->get();

        $rows = '<div class="profile_report">
                    <span class="tabel-profile-img mr-3">
                        <img src="' . url('storage/app/public/uploads/users/' . $users->profile_pic) . '" alt="">
                    </span>
                    <div>
                        <span class="d-block">'.$users->username.'</span>
                        <span>'.strtolower($users->stream_id).'</span>
                    </div>
                    <div class="px-5">
                        <span class="d-block">Total Days:'. count($diff_in_days).'</span>
                        <span>Time:'.gmdate('H:i:s',$total_time).'</span>
                    </div>
                    <div>
                        <span class="d-block">Start Date:'.date('d-m-Y',strtotime($start_date)).'</span>
                        <span>End Date:'.date('d-m-Y',strtotime($end_date)).'</span>
                    </div>
                </div>';
        
        $rows .= "<table class='table profile-report-tbl' id='viewerDetailsTable'><thead class='thead-light'><tr>
                <th>No.</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Duration</th>
                </tr></thead>
                ";
        $array  = [];
        $diff_in_days = LiveStreamUser::where('user_id',$request->id)->whereBetween('created_at', [$start_date, $end_date])->distinct('created_at')->get();
        foreach ($livesteamers as $key => $value) {
            $start_date_bankock = new Carbon($value->created_at);
            $start_date_bankock->timezone = 'Asia/Bangkok';

            $end_date_bankock = new Carbon($value->updated_at);
            $end_date_bankock->timezone = 'Asia/Bangkok';

            // env('APP_TIME_ZONE','Asia/Bangkok');
            
            // $start_time = Carbon::parse($value->created_at)->timestamp;
            

            // $end_time = $start_time + Carbon::parse($value->updated_at)->timestamp;
            // $end_time =  $start_time + $value->total_time;

           
            // env('APP_TIME_ZONE','Asia/Bangkok');
            // $date_a = new DateTime();
            // $date_b = new DateTime();

            $interval = date_diff($value->updated_at,$value->created_at);


            $rows.="<tr>";
            // $data = date_diff($date_b,$date_a);
            // LiveStreamUser::where('user_id',$request->id)->where('created_at',$value->created_at)->sum('total_time');
            $flag = 0;
            $rows .="<td>".++$key."</td>";
            $rows.= "<td>".date('d-m-Y',strtotime($value->created_at))."</td>";
            $rows.="<td>".date('H:i:s',strtotime($start_date_bankock->toDayDateTimeString()))."</td>";
            $rows.="<td>".date('H:i:s',strtotime($end_date_bankock->toDayDateTimeString()))."</td>";
            $rows.="<td>".$interval->format('%H:%I:%S')."</td>";
            $rows.="</tr>";
        }
        $rows .='</table>';
        return $rows;
    }
}
