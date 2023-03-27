<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLoginLog;
use App\Models\UserGemsDetail;
use App\Models\UserWalletDetail;
use Carbon\Carbon;

class AuditlogController extends Controller
{
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $logList=UserLoginLog::with('user')->orderBy('id','DESC')->paginate(10);

        $gemstopup = UserWalletDetail::with('user')->get();
        return view('admin.auditLogs.index',compact('logList','gemstopup'));
    }
    
    // listLogPaginate 
    public function listLogPaginate(Request $request){
       
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length =(int)$request->get('length');
        $page=($request->start/$length)+1;
        $search=$request->search['value'];
        
        // \DB::enableQueryLog(); 
        if(isset($request->order)){
            $order=$request->order[0]['dir'];
            $columns=$request->order[0]['column'];
            if($request->order[0]['column']==1 && $request->order[0]['column']==0 && $request->order[0]['column']==2){
                $name_field=$request->columns[$columns]['data'];
            }
        }
        $members =UserLoginLog::with('user')->leftjoin('users','users.id','=','user_login_logs.user_id');
        if($search!=""){            
            $members =$members->where(function($q) use($search){
                $q->where('user_login_logs.type', 'like', '%' .$search. '%')
                ->orWhere('user_login_logs.ip_address', 'like', '%' .$search. '%')
                ->orWhere('user_login_logs.device_type', 'like', '%' .$search. '%')
                ->orWhere('user_login_logs.date', 'like', '%' .$search. '%')
                ->orWhere('users.email', 'like', '%' .$search. '%')
                ->orWhere('users.username', 'like', '%' .$search. '%')
                ->orWhere('users.stream_id', 'like','%'.$search.'%');
            });
        }
        if(!isset($request->order)){
            $members =$members->orderby('user_login_logs.id','DESC');
        }else{
            
            $name_field=$request->columns[$columns]['data'];
            if($request->order[0]['column']!=1 && $request->order[0]['column']!=0 && $request->order[0]['column']!=2){ 
                $members =$members->orderby($name_field,$order);
            }else{
                $members =$members->orderby('users.'.$name_field,$order);
            }
        }

        $members =$members->select('user_login_logs.*'); 
        $members =$members->paginate($length,['*'], 'page',$page); 
        // dd(\DB::getQueryLog());   

        foreach ($members as $key => $value) {

            $value->profile_pic='<span class="tabel-profile-img"><img src="'.$value['user']->profile_pic.'" alt=""></span></br>'.strtolower($value['user']->stream_id);
            if($value['user']->role_id==1){
                $value->role='Admin';                                              
            }elseif($value['user']->role_id==2){
                $value->role='Subadmin';                                              
            }elseif($value['user']->role_id==3){
                $value->role='Agent';                                              
            }else{
                $value->role='User';                                              
            }
            $value->device_type=($value->device_type==NULL)? 'Web' : $value->device_type;
            $value->username=$value['user']->username;
            $value->email=$value['user']->email;
            $value->phone=$value['user']->phone;
            $join_date = new Carbon($value->date);
            $join_date->timezone = env('APP_TIME_ZONE','Asia/Bangkok');
            $value->date =  date('d M, Y | h:i:s a',strtotime($join_date->toDayDateTimeString()));  
            $value->type=($value->type=='login')? '<span class="green">'.$value->type.'</span>': '<span class="red">'.$value->type.'</span>';            
        }
        
        $members=(array)json_decode(json_encode($members));
        
       
        $data = array(
           'draw' => $draw,
           'recordsTotal' => $members['total'],
           'recordsFiltered' =>$members['total'],
           'data' => $members['data'],
        );
        echo json_encode($data);
    }

    // listGemsPaginate 
    public function listGemsPaginate(Request $request){
       
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length =(int)$request->get('length');
        $page=($request->start/$length)+1;
        $search=$request->search['value'];

        $members =UserWalletDetail::with('user')->where('type',1)->leftjoin('users','users.id','=','user_wallet_details.user_id');
        if($search!=""){            
            $members =$members->where(function($q) use($search){
                $q->where('user_wallet_details.gems_amount', 'like', '%' .$search. '%')
                ->orWhere('user_wallet_details.created_at', 'like', '%' .$search. '%')
                ->orWhere('users.email', 'like', '%' .$search. '%')
                ->orWhere('users.username', 'like', '%' .$search. '%')
                ->orWhere('users.stream_id', 'like','%'.$search.'%');
            });
        }
        if(!isset($request->order)){
            $members =$members->orderby('user_wallet_details.id','DESC');
        }else{
            $columns=$request->order[0]['column'];
            $order=$request->order[0]['dir'];
            $name_field=$request->columns[$columns]['data'];
            if($request->order[0]['column']!=1 && $request->order[0]['column']!=0 && $request->order[0]['column']!=2){            
                $members =$members->orderby($name_field,$order);
            }else{
                $members =$members->orderby('users.'.$name_field,$order);
            }
        }
        $members =$members->select('user_wallet_details.*'); 
        $members =$members->paginate($length, ['*'], 'page', $page); 
            
        foreach ($members as $key => $value) {

            $value->profile_pic='<span class="tabel-profile-img"><img src="'.$value['user']->profile_pic.'" alt=""></span></br>'.strtolower($value['user']->stream_id);
            $value->username=$value['user']->username;
            $value->email=$value['user']->email;
            $value->phone=$value['user']->phone;
            $join_date = new Carbon($value->created_at);
            $join_date->timezone = env('APP_TIME_ZONE','Asia/Bangkok');
            $value->date =  date('d M, Y | h:i:s a',strtotime($join_date->toDayDateTimeString()));                       
        }
        
        $members=(array)json_decode(json_encode($members));
        
       
        $data = array(
           'draw' => $draw,
           'recordsTotal' => $members['total'],
           'recordsFiltered' =>$members['total'],
           'data' => $members['data'],
        );
        echo json_encode($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        
        return view('admin.auditLogs.auditList');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
