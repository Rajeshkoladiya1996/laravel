<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebLog;
use Illuminate\Http\Request;

class WebLogController extends Controller
{
    //Api Log list
    public function webLogList(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        // \DB::enableQueryLog(); 
        if (isset($request->order)) {
            $order = $request->order[0]['dir'];
            $columns = $request->order[0]['column'];
            $name_field = '';
            if ($request->order[0]['column'] == 1 && $request->order[0]['column'] == 0 && $request->order[0]['column'] == 2) {
                $name_field = $request->columns[$columns]['data'];
            }
        }
        $members = WebLog::with('user')->leftjoin('users', 'users.id', '=', 'web_logs.user_id');
        // dd($members);
        if ($search != "") {
            $members = $members->where(function ($q) use ($search) {
                $q->where('web_logs.ip_address', 'like', '%' . $search . '%')
                    ->orWhere('web_logs.browser', 'like', '%' . $search . '%')
                    ->orWhere('web_logs.uri', 'like', '%' . $search . '%')
                    ->orWhere('web_logs.updated_at', 'like', '%' . $search . '%')
                    ->orWhere('web_logs.response_status', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%')
                    ->orWhere('users.username', 'like', '%' . $search . '%')
                    ->orWhere('users.phone', 'like', '%' . $search . '%');
            });
        }
        if (!isset($request->order)) {
            $members = $members->orderby('web_logs.id', 'DESC');
        } else {

            $name_field = $request->columns[$columns]['data'];
            if ($name_field == 'date') {
                $name_field = "updated_at";
            }
            if ($request->order[0]['column'] != 1 && $request->order[0]['column'] != 0 && $request->order[0]['column'] != 2) {
                $members = $members->orderby($name_field, $order);
            } else {
                $members = $members->orderby('users.' . $name_field, $order);
            }
        }

        $members = $members->select('web_logs.*');
        $members = $members->paginate($length, ['*'], 'page', $page);

        foreach ($members as $key => $value) {
             if ($value->user == "") {
                $profile_pic = url('storage/app/public/uploads/users/default.png');
                $email='';
                $username='';
            } else {
                $profile_pic = $value->user['profile_pic'];
                $email= $value->user['email'];
                $username=$value->user['username'];
            }
            $uri = [];
            // parse_str($value->uri, $uri);
            // $value->uri = json_encode($uri);
            $value->device_type = ($value->device_type == NULL) ? 'Web' : $value->device_type;
            $value->username = '<span class="tabel-profile-img"><img src="' . $profile_pic . '" alt=""></span> ' . $username;
            $value->email = $email;
            $value->uri = $value->uri . " : " . $value->method;
            $value->date = $value->updated_at->format('d M, Y | h:s a');
            $value->action = '<a href="javascript:void(0)" class="changeStatus" id="view-web-request-body" data-id="' . $value->id . '"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" 
            fill="#007bff"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm0 9H8v2h4v3l4-4-4-4v3z"/></svg></a>
                <a href="javascript:void(0)" class="changeStatus" id="view-web-response" data-id="' . $value->id . '"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="green"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 2c5.52 0 10 4.48 10 10s-4.48 10-10 10S2 17.52 2 12 6.48 2 12 2zm0 9V8l-4 4 4 4v-3h4v-2h-4z"/></svg></a>
                <a href="javascript:void(0)" class="deletLog" id="delete-web-log" data-id="' . $value->id . '"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="red"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 8h16v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8zm2 2v10h12V10H6zm3 2h2v6H9v-6zm4 0h2v6h-2v-6zM7 5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v2h5v2H2V5h5zm2-1v1h6V4H9z"/></svg></a>';
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

    //Request Body
    public function getRequestBody(Request $request)
    {
        $data = WebLog::where('id', $request->id)->first();
        return response()->json(['data' => json_decode($data->request_body)]);
    }

    //Response
    public function getResponse(Request $request)
    {
        $data = WebLog::where('id', $request->id)->first();
        return response()->json(['data' => json_decode($data->response)]);
    }

    // Delete Request
    public function delete(Request $request)
    {
        $data = WebLog::where('id', $request->id)->delete();
        if ($data) {
            return 1;
        } else {
            return 0;
        }
    }

    public function deleteAll()
    {
        $data = WebLog::truncate();
        if ($data) {
            return 1;
        } else {
            return 0;
        }
    }
}
