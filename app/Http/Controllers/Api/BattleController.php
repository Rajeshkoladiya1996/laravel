<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Battle;
use App\Models\BattlesViewerUser;
use App\Models\UserFollower;
use Validator;
use JWTAuth;
use Carbon;

class BattleController extends Controller
{

    /**---------------------------------------------------
     *  Create Battle Room  
     *  @Created By : Rajesh Koladiya
     *  @Created At : 24-07-2021
     *  function name : create
     * ---------------------------------------------------
    */
    public function create(Request $request)
    {

       $validate = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if($validate->fails())
        {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }
        $userdata=User::where('id',$request->user_id)->first();
        $to_user= Battle::whereNull('to_id')->where('status','0')->first();

        if($to_user != ''){
            // Join Battle Room 
            if($to_user->from_id != $request->user_id){ 
                $data['to_id'] = $request->user_id;
                $mytime = Carbon\Carbon::now()->addMinutes(15)->format('Y-m-d H:i:s');
                $data['battles_time'] = Carbon\Carbon::now()->format('Y-m-d H:i:s');
                $data['end_time'] = $mytime;
                Battle::where('from_id',$to_user->from_id)->where('status','0')->update($data);
                $get_battle_room = Battle::where('status','0')->where('from_id',$to_user->from_id)->where('to_id',$request->user_id)->first();
                $form_user=User::where('id',$to_user->from_id)->select('users.*',\DB::raw("IF(users.profile_pic LIKE '%https://%' , users.profile_pic , ". "CONCAT('".url('/storage/app/public/uploads/users/')."/', users.profile_pic)) AS profile_pic"))->first();

                return response()->json(['ResponseCode'=>1,'ResponseText'=>'Battle Room Created successfully','ResponseData'=>['battle'=>$get_battle_room,'form_user'=>$form_user,'stream_id' => $get_battle_room->stream_id,'status'=>2]],200);
            }else{
                return response()->json(['ResponseCode'=>1,'ResponseText'=>'Wait Find New User','ResponseData' =>['battle'=>$to_user,'token' => $to_user->from_user_token,'stream_id' => $to_user->stream_id,'status'=>1]],200);
            }
            
        }else{ 

            $stream_id='PKBK_'.$userdata->id.rand(1,50).rand(10,100).rand(10,1000).rand(10,10000);

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://bklive.stream:7800/access_token?channel_name='.$stream_id.'&user_id='.$userdata->id,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $tokendata=json_decode($response);

            // Insert Battle Room
            $data = new Battle;
            $data->from_id = $request->user_id;
            $data->stream_id = $stream_id;
            $data->from_user_token = $tokendata->data->token;
           
            if($data->save()){
                $get_battle_room=Battle::where('id',$data->id)->first();
                return response()->json(['ResponseCode'=>1,'ResponseText'=>'Wait Find New User','ResponseData' =>['battle'=>$get_battle_room,'token' => $get_battle_room->from_user_token,'stream_id' => $get_battle_room->stream_id,'status'=>1]],200);
             }else{
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'Server Error.'],200);
             }
        }
    }

    /**---------------------------------------------------
     *  Change Battle Status. 
     *  @Created By : Rajesh Koladiya
     *  @Created At : 27-07-2021
     *  function name: changeStatus
     * ---------------------------------------------------
    */
    public function changeStatus(Request $request){

        $validate = Validator::make($request->all(), [
            'battle_id' => 'required',
            'status' => 'required',
        ]);

        if($validate->fails())
        {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }
         
        $data['status'] = $request->status;
        $data['is_win'] = (isset($request->is_win))?$request->is_win:0;
       
        Battle::where('id',$request->battle_id)->update($data);

        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Battle Room Status Change Successfully'],200);

    }

    /**---------------------------------------------------
     *  Live Battle List. 
     *  @Created By : Rajesh Koladiya
     *  @Created At : 28-07-2021
     *  funcation name : livebattleList
     * ---------------------------------------------------
    */  
    public function livebattleList(Request $request)
    {
        $today = date('Y-m-d');
        $seachParam = $request->searchkey;
        if(isset($request->searchkey)){
            $livebattelslist = Battle::with(['from_user','to_user'])
                ->leftjoin('users as fu','battles.from_id','=','fu.id')
                ->leftjoin('users as tu','battles.to_id','=','tu.id')
                ->where(function($q) use ($seachParam){
                    $q->where('fu.username','LIKE','%'.$seachParam.'%')
                   ->orWhere('tu.username','LIKE','%'.$seachParam.'%');
                })
                ->where('battles.status','1')
                ->whereDate('battles.created_at',$today)
                ->select('battles.*')->get();  
        }else{
            $livebattelslist = Battle::with('from_user','to_user')->where('status','1')->whereDate('created_at', $today)->get();
        }
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Live Battle List','ResponseData' =>$livebattelslist],200);
    }

    /**---------------------------------------------------
     *  Live Battle List. 
     *  @Created By : Rajesh Koladiya
     *  @Created At : 28-07-2021
     *  funcatin name: battleviewer
     * ---------------------------------------------------
    */
    public function battleviewer(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'battle_id' => 'required',
        ]);
        if($validate->fails())
        {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }
        $battlesviwerlist = BattlesViewerUser::with('user')->where('battles_id',$request->battle_id)->get();
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Battles Viewer List','ResponseData' =>$battlesviwerlist],200);
    }

    /**---------------------------------------------------
     *  Live Battle List. 
     *  @Created By : Rajesh Koladiya
     *  @Created At : 28-07-2021
     *  funcatin name: userfollwing
     * ---------------------------------------------------
    */ 
    public function userfollwing(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'from_id' => 'required',
            'to_id' => 'required',
        ]);
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
        }
        $loginuser=compact('user');

        $from_following=UserFollower::where('from_id',$loginuser['user']->id)->where('to_id',$request->from_id)->count();
        $to_following=UserFollower::where('from_id',$loginuser['user']->id)->where('to_id',$request->to_id)->count();
        
        if($loginuser['user']->id == $request->from_id){
            $data['from_is_following']='true';
        }else{
            $data['from_is_following']=($from_following == 1)? true : false ;
        }

        if($loginuser['user']->id == $request->to_id){
            $data['to_is_following']="true";
        }else{

            $data['to_is_following']=($to_following == 1)? true : false ;
        }
        
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Get Details successfully','ResponseData'=>$data],200); 
    }
}
