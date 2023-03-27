<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gift;
use App\Models\Config;
use App\Helper\BaseFunction;
use App\Models\UserGemsDetail;
use App\Models\UserWalletDetail;
use App\Models\UserWalletRequest;
use App\Models\User;
use App\Models\TopupRate;
use App\Models\PackagePurchase;
use Carbon\Carbon;
use DB;

class FinancialController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $config=Config::where('id','1')->first();
        // $cofigs =  Config::where('id','1')->first();


        $gemstopup = UserWalletDetail::with('user')->where('type',1)->get();
        $topuprates = TopupRate::all();
        $users =  User::users()->get();
        $packagePurchases = PackagePurchase::with('user','package')->get();
        return view('admin.finanical.index',compact('gemstopup','users','topuprates','packagePurchases'));
    }

    // listGemsPaginate function resource
    public function listGemsPaginate(Request $request){

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length =(int)$request->get('length');
        $page=($request->start/$length)+1;
        $search=$request->search['value'];

        $members =UserWalletDetail::with('user')->where('user_wallet_details.type',1)->leftjoin('users','users.id','=','user_wallet_details.user_id');

        // $members_req =UserWalletRequest::with('user')->leftjoin('users','users.id','=','user_wallet_requests.user_id')->select('user_wallet_requests.id','user_id','type','amount',DB::raw("NULL as diamond_amount"),DB::raw("NULL as gems_amount"),DB::raw("NULL as create_by"),DB::raw("NULL as update_by"),'status','users.username');
        // $members = $members->unionAll($members_req);

        if($search!=""){
            $members =$members->where(function($q) use($search){
                $q->where('user_wallet_details.gems_amount', 'like', '%' .$search . '%')
                ->orWhere('user_wallet_details.amount', 'like', '%' .$search . '%')
                ->orWhere('user_wallet_details.created_at', 'like', '%' .$search . '%')
                ->orWhere('users.username', 'like', '%' .$search . '%');
            });
        }
        if(!isset($request->order)){
            $members =$members->orderby('updated_at','DESC')->orderBy('status', 'ASC');
        }else{
            $columns=$request->order[0]['column'];
            $order=$request->order[0]['dir'];
            $name_field=$request->columns[$columns]['data'];
            if($request->order[0]['column']!=0){
                $members =$members->orderby($name_field,$order);
            }else{
                $members =$members->orderby('users.'.$name_field,$order);
            }
        }
        $members =$members->select('user_wallet_details.*');
        $members =$members->paginate($length, ['*'], 'page', $page);


        foreach ($members as $key => $value) {

            $value->username='<div class="d-flex nowrap"><span class="tabel-profile-img"><img src="'.$value['user']->profile_pic.'" alt=""></span><p class="ml-2 mb-0">'.$value['user']->username.'</p></div>'.'<br/>'.strtolower($value['user']->stream_id);
            $join_date = new Carbon($value->created_at);
            $join_date->timezone = env('APP_TIME_ZONE','Asia/Bangkok');
            $value->date =  date('d M, Y | h:s a',strtotime($join_date->toDayDateTimeString()));
            if($value->status==1){
                $value->status='<a href="javascript:void(0)" title="Edit" data-id='.$value->id.' id="update_salmon_coin" data-amount='.$value->amount.' data-user-id='.$value['user']->id.' data-user-salmon='.$value->gems_amount.' class="mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16.473" height="16.473" viewBox="0 0 16.473 16.473">
                              <path id="Path_376" data-name="Path 376" d="M14.667,9.131l-1.3-1.3L4.833,16.373v1.3h1.3l8.538-8.538Zm1.3-1.3,1.3-1.3-1.3-1.3-1.3,1.3ZM6.889,19.5H3V15.613L15.315,3.3a.917.917,0,0,1,1.3,0L19.2,5.891a.917.917,0,0,1,0,1.3L6.889,19.5Z" transform="translate(-3 -3.029)" fill="#00b247"></path>
                            </svg>
                          </a>
                          <p class="paid">PAID</p>';

            }
            else{
                $value->status='<p class="pending is_paid" data-user-id='.$value['user']->id.' data-id='.$value->id.'>UNPAID</p>';
            }
            $value->amount='$'.$value->amount;
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
     * editFinancial
     */
    public function editFinancial($id){
        $data=UserWalletDetail::where('id',$id)->first();
        // $users =  User::users()->get();
        return array('data'=>$data);
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
     * Show Top up Rates
     */
    public function list(){
        $topuprates=TopupRate::orderBy('from_price','ASC')->get();
        return view('admin.finanical.salmoncoinList',compact('topuprates'));
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
            'minTHB'=>'required',
            'maxTHB'=>'required',
            'rate'=>'required|numeric',
        ]);

        $data = new TopupRate;
        $data->from_price = $request->minTHB;
        $data->to_price = $request->maxTHB;
        $data->rate = $request->rate;
        if($data->save()){
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
    public function edit($id)
    {
        $previous=TopupRate::where('id','<',$id)->orderby('id','desc')->first();
        $data=TopupRate::where('id',$id)->first();
        $next=TopupRate::where('id','>',$id)->orderby('id','desc')->first();

        return array('data'=>$data,'previous'=>$previous,'next'=>$next);
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
            'minTHB'=>'required',
            'maxTHB'=>'required',
            'rate'=>'required|numeric',
        ]);

        $data = TopupRate::find($request->id);
        $data->from_price = $request->minTHB;
        $data->to_price = $request->maxTHB;
        $data->rate = $request->rate;
        if($data->save()){
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
        $data=TopupRate::where('id', $request->id)->delete();
        if($data){
            return 1;
        }else{
            return 0;
        }
    }

 	public function lastData(){
        $data=TopupRate::orderBy('from_price','desc')->first();
        return array('last'=>$data);
    }

    public function updateTopUp(Request $request)
    {
        $this->validate($request,[
            'idDimoand'=>'required',
            'user_id'=>'required',
            'amount'=>'required|numeric',
            'diamond'=>'required|numeric',
        ]);

        // if($request->amount == 0 || $request->salmoncoin==0){
        //     return 2;
        // }

        $user = User::findOrFail($request->user_id);
        $UserWalletDetail = UserWalletDetail::findOrFail($request->idDimoand);
        $data = new User;
        $data->exists = true;
        $data->id = $user->id;
        $data->total_gems = ($user->total_gems - $UserWalletDetail->gems_amount) + $request->diamond;
        if($data->save()){
            $userWallet = new UserWalletDetail;
            $userWallet->exists = true;
            $userWallet->id = $request->idDimoand;
            $userWallet->gems_amount = $request->diamond;
            $userWallet->amount =  $request->amount;
            if($userWallet->save()){
                    return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
}
