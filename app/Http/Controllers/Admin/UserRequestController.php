<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helper\BaseFunction;
use App\Models\UserRequest;
use App\Models\UserWalletRequest;
use App\Models\UserWalletDetail;
use App\Models\Config;
use App\Models\Country;
use Carbon\Carbon;
use Auth;

class UserRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin');
        }
        $requestList = UserRequest::where('type', 'request_for_live')->get();
        $walletList = UserWalletDetail::where('status', 0)->where('type', 1)->get();
        $cashWithdrawList = UserWalletDetail::where('status', 0)->where('type', 2)->get();
        $salmonWithdrawList = UserWalletDetail::where('status', 0)->where('type', 3)->get();
        return view('admin.userRequest.index', compact('requestList', 'walletList','cashWithdrawList','salmonWithdrawList'));
    }

    // list user request stream resource
    public function streamRequestList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        $members = UserRequest::with('user')->leftjoin('users', 'users.id', '=', 'user_requests.user_id')->where('user_requests.type', 'request_for_live');
        if ($search != "") {
            $members = $members->where(function ($q) use ($search) {
                $q->where('user_requests.type', 'like', '%' . $search . '%')
                    ->orWhere('user_requests.status', 'like', '%' . $search . '%')
                    ->orWhere('user_requests.created_at', 'like', '%' . $search . '%')
                    ->orWhere('users.username', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%')
                    ->orWhere('users.phone', 'like', '%' . $search . '%')
                    ->orWhere('users.stream_id', 'like','%'.$search.'%');
            });
        }
        if (!isset($request->order)) {
            $members = $members->orderby('user_requests.created_at', 'DESC');
        } else {
            $columns = $request->order[0]['column'];
            $order = $request->order[0]['dir'];
            $name_field = $request->columns[$columns]['data'];
            if ($name_field == 'date') {
                $name_field = 'created_at';
            }
            if ($request->order[0]['column'] != 0 && $request->order[0]['column'] != 1) {
                $members = $members->orderby($name_field, $order);
            } else {
                $members = $members->orderby('users.' . $name_field, $order);
            }
        }
        $members = $members->select('user_requests.*');
        $members = $members->paginate($length, ['*'], 'page', $page);

        foreach ($members as $key => $value) {
            $value->username = '<div class="d-flex nowrap"><span class="tabel-profile-img"><img src="' . $value['user']->profile_pic . '" alt=""></span><p class="ml-2 mb-0">' . $value['user']->username . '<br/>'.strtolower($value['user']->stream_id).'</p></div>';
            $value->email = strtolower($value['user']->email);
            $value->phone = $value['user']->phone;
            $country_name=Country::where('country_code',trim(strtoupper($value['user']->county_code)))->first();
            if($country_name!=null){
                $value->county= $country_name->country;
            }else{
                $value->county= $value['user']->county_code;
            }
            if ($value->status == '1') {
                $value->actions = '
                <a href="javascript:void(0)" class="btn btn-primary changeStatus" data-id="' . $value->id . '" data-user="' . $value['user']->id . '" data-status="2">Accept</a>
                <a href="javascript:void(0)" class="btn btn-danger changeStatus" data-id="' . $value->id . '" data-status="0" data-user="' . $value['user']->id . '" >Reject</a>';
            } else if ($value->status == '2') {
                $value->actions = '<a href="javascript:void(0)" class="btn btn-danger changeStatus" data-id="' . $value->id . '" data-status="0" data-user="' . $value['user']->id . '" >Reject</a>';
            } else if ($value->status == '3') {
                $value->actions = '
                <a href="javascript:void(0)" class="btn btn-primary changeStatus" data-id="' . $value->id . '" data-user="' . $value['user']->id . '" data-status="2">Accept</a>';
            }
            if ($value->status == '1') {
                $color = "yellow";
                $status = "Pending";
            } elseif ($value->status == '2') {
                $color = "green";
                $status = "Active";
            } else {
                $color = "red";
                $status = "Reject";
            }
            $value->status = '<span class="' . $color . '">' . $status . '</span>';
            $join_date = new Carbon($value->created_at);
            $join_date->timezone = env('APP_TIME_ZONE','Asia/Bangkok');
            $value->date =  date('d M, Y | h:i:s a',strtotime($join_date->toDayDateTimeString()));
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

    // list user Wallet request resource
    public function walletRequestList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        $members = UserWalletDetail::with('user')->where('user_wallet_details.status',0)->where('user_wallet_details.type',1)->leftjoin('users', 'users.id', '=', 'user_wallet_details.user_id');
        if ($search != "") {
            $members = $members->where(function ($q) use ($search) {
                $q->where('user_wallet_details.type', 'like', '%' . $search . '%')
                    ->orWhere('user_wallet_details.amount', 'like', '%' . $search . '%')
                    ->orWhere('user_wallet_details.created_at', 'like', '%' . $search . '%')
                    ->orWhere('users.username', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%')
                    ->orWhere('users.phone', 'like', '%' . $search . '%')
                    ->orWhere('users.stream_id', 'like','%'.$search.'%');
            });
        }
        if (!isset($request->order)) {
            $members = $members->orderby('user_wallet_details.id', 'DESC');
        } else {
            $columns = $request->order[0]['column'];
            $order = $request->order[0]['dir'];
            $name_field = $request->columns[$columns]['data'];
            if ($request->order[0]['column'] != 0 && $request->order[0]['column'] != 1) {
                $members = $members->orderby($name_field, $order);
            } else {
                $members = $members->orderby('users.' . $name_field, $order);
            }
        }
        $members = $members->select('user_wallet_details.*');
        $members = $members->paginate($length, ['*'], 'page', $page);

        foreach ($members as $key => $value) {
            $value->username = '<div class="d-flex nowrap"><span class="tabel-profile-img"><img src="' . $value['user']->profile_pic . '" alt=""></span><p class="ml-2 mb-0">' . $value['user']->username . '<br/>'.strtolower($value['user']->stream_id).'</p></div>';
            $value->email = strtolower($value['user']->email);
            $value->phone = ($value['user']->phone != 'null') ? $value['user']->phone : '';
            $join_date = new Carbon($value->created_at);
            $join_date->timezone = env('APP_TIME_ZONE','Asia/Bangkok');
            $value->date =  date('d M, Y | h:i:s a',strtotime($join_date->toDayDateTimeString()));
            if ($value->status == 0) {
                $value->actions = '<a href="javascript:void(0)" class="btn btn-primary accept_request" data-id="' . $value->id . '" data-user="' . $value['user']->id . '" data-status="1" data-type="'.$value->type.'">Accept</a>
                <a href="javascript:void(0)" class="btn btn-danger accept_request" data-id="' . $value->id . '" data-user="' . $value['user']->id . '" data-status="2" data-type="'.$value->type.'">Reject</a>';
            }
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

    // list user cashWithdrawalRequestList
    public function cashWithdrawalRequestList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        $members = UserWalletDetail::with('user')->where('user_wallet_details.status',0)->where('user_wallet_details.type',2)->leftjoin('users', 'users.id', '=', 'user_wallet_details.user_id');
        if ($search != "") {
            $members = $members->where(function ($q) use ($search) {
                $q->where('user_wallet_details.type', 'like', '%' . $search . '%')
                    ->orWhere('user_wallet_details.amount', 'like', '%' . $search . '%')
                    ->orWhere('user_wallet_details.created_at', 'like', '%' . $search . '%')
                    ->orWhere('users.username', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%')
                    ->orWhere('users.phone', 'like', '%' . $search . '%')
                    ->orWhere('users.stream_id', 'like','%'.$search.'%');
            });
        }
        if (!isset($request->order)) {
            $members = $members->orderby('user_wallet_details.id', 'DESC');
        } else {
            $columns = $request->order[0]['column'];
            $order = $request->order[0]['dir'];
            $name_field = $request->columns[$columns]['data'];
            if ($request->order[0]['column'] != 0 && $request->order[0]['column'] != 1) {
                $members = $members->orderby($name_field, $order);
            } else {
                $members = $members->orderby('users.' . $name_field, $order);
            }
        }
        $members = $members->select('user_wallet_details.*');
        $members = $members->paginate($length, ['*'], 'page', $page);

        foreach ($members as $key => $value) {
            $value->username = '<div class="d-flex nowrap"><span class="tabel-profile-img"><img src="' . $value['user']->profile_pic . '" alt=""></span><p class="ml-2 mb-0">' . $value['user']->username . '<br/>'.strtolower($value['user']->stream_id).'</p></div>';
            $value->email = strtolower($value['user']->email);
            $value->phone = ($value['user']->phone != 'null') ? $value['user']->phone : '';
            $join_date = new Carbon($value->created_at);
            $join_date->timezone = env('APP_TIME_ZONE','Asia/Bangkok');
            $value->date =  date('d M, Y | h:s a',strtotime($join_date->toDayDateTimeString()));
            $value->amount = number_format((float)$value->amount, 2, '.', '');
            $value->diamond = $value->diamond_amount;
            if ($value->status == 0) {
                $value->actions = '<a href="javascript:void(0)" class="btn btn-primary accept_request" data-id="' . $value->id . '" data-user="' . $value['user']->id . '" data-status="1" data-type="'.$value->type.'">Accept</a>
                <a href="javascript:void(0)" class="btn btn-danger accept_request" data-id="' . $value->id . '" data-user="' . $value['user']->id . '" data-status="2" data-type="'.$value->type.'">Reject</a>';
            }
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

    // list user salmonCoinsWithdrawalRequestList
    public function salmonCoinsWithdrawalRequestList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        $members = UserWalletDetail::with('user')->where('user_wallet_details.status',0)->where('user_wallet_details.type',3)->leftjoin('users', 'users.id', '=', 'user_wallet_details.user_id');
        if ($search != "") {
            $members = $members->where(function ($q) use ($search) {
                $q->where('user_wallet_details.type', 'like', '%' . $search . '%')
                    ->orWhere('user_wallet_details.amount', 'like', '%' . $search . '%')
                    ->orWhere('user_wallet_details.created_at', 'like', '%' . $search . '%')
                    ->orWhere('users.username', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%')
                    ->orWhere('users.phone', 'like', '%' . $search . '%')
                    ->orWhere('users.stream_id', 'like','%'.$search.'%');
            });
        }
        if (!isset($request->order)) {
            $members = $members->orderby('user_wallet_details.id', 'DESC');
        } else {
            $columns = $request->order[0]['column'];
            $order = $request->order[0]['dir'];
            $name_field = $request->columns[$columns]['data'];
            if ($request->order[0]['column'] != 0 && $request->order[0]['column'] != 1) {
                $members = $members->orderby($name_field, $order);
            } else {
                $members = $members->orderby('users.' . $name_field, $order);
            }
        }
        $members = $members->select('user_wallet_details.*');
        $members = $members->paginate($length, ['*'], 'page', $page);

        foreach ($members as $key => $value) {
            $value->username = '<div class="d-flex nowrap"><span class="tabel-profile-img"><img src="' . $value['user']->profile_pic . '" alt=""></span><p class="ml-2 mb-0">' . $value['user']->username . '<br/>'.strtolower($value['user']->stream_id).'</p></div>';
            $value->email = strtolower($value['user']->email);
            $value->phone = ($value['user']->phone != 'null') ? $value['user']->phone : '';
            $join_date = new Carbon($value->created_at);
            $join_date->timezone = env('APP_TIME_ZONE','Asia/Bangkok');
            $value->date =  date('d M, Y | h:i:s a',strtotime($join_date->toDayDateTimeString()));
            $value->diamond = $value->diamond_amount;
            if ($value->status == 0) {
                $value->actions = '<a href="javascript:void(0)" class="btn btn-primary accept_request" data-id="' . $value->id . '" data-user="' . $value['user']->id . '" data-status="1" data-type="'.$value->type.'">Accept</a>
                <a href="javascript:void(0)" class="btn btn-danger accept_request" data-id="' . $value->id . '" data-user="' . $value['user']->id . '" data-status="2" data-type="'.$value->type.'">Reject</a>';
            }
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

    /** 
     *changeStatus the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {

        $this->validate($request, [
            'id' => 'required',
            'status' => 'required',
            'user_id' => 'required',
        ]);

        $userrequest = new UserRequest;
        $userrequest->exists = true;
        $userrequest->id = $request->id;
        $userrequest->status = $request->status;
        if ($userrequest->save()) {
            $user = new  User;
            $user->exists = true;
            $user->id = $request->user_id;
            $title = "Stream Request";
            if ($request->status == 0) {
                // 0    
                $user->user_type = 0;

                $body = "Your request is rejected. Please contact us for more information";
            } else {
                // 1
                $body = "Your request is accepted. Now you can go live whenever you want.";
                $user->user_type = 1;
            }
            $user->save();
            // Start Send Notification From BaseFunction            
            $userData = User::where('id', $request->user_id)->first();
            BaseFunction::sendNotification($userData, $title, $body, 'stream_request', $userData);
            // End Send Notification From BaseFunction

            return 1;
        } else {
            return 0;
        }
    }
    public function changeWalletStatus(Request $request)
    {

        $this->validate($request, [
            'id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
        ]);

        // 1. Salmon coins/ 2. gold to cash/ 3.diamond 

        $wallet_request = UserWalletDetail::where('id', $request->id)->first();
        $userwalletdetail = UserWalletDetail::where('id', $request->id)->update(['status' => $request->status,'update_by'=>Auth::user()->id]);
        $userData = User::where('id', $request->user_id)->first();

        if(isset($request->type) && $request->type=='2' && $request->status=='1'){
            
            // cash
            $gemsamount = $wallet_request->gems_amount / $wallet_request->diamond_amount;
            $bkcommissionamount = $gemsamount - $wallet_request->amount;
            
            $diamond = $userData->earned_gems - $wallet_request->gems_amount;
            User::where('id', $request->user_id)->update(['earned_gems'=>$diamond]);
            $userwalletdetail = UserWalletDetail::where('id', $request->id)->update(['status' =>$request->status,'update_by'=>Auth::user()->id]);
            return 1;
        }else if(isset($request->type) && ($request->type=='1' || $request->type=='2' || $request->type=='3') && $request->status=='2'){
            return 3;
        }else if(isset($request->type) && $request->type=='1' && $request->status=='1'){
            if ($userwalletdetail) { 
                $data['total_gems'] = $userData->total_gems + $wallet_request->gems_amount;
                User::where('id', $request->user_id)->update($data);
                return 1;
            } else {
                return 0;
            }
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
        $this->validate($request, [
            'id' => 'required',
        ]);
        $data = UserRequest::where('id', $request->id)->delete();
        if ($data) {
            return 1;
        } else {
            return 0;
        }
    }
}
