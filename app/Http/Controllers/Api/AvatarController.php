<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAvatarAttribute;
use App\Models\UserAvatarCart;
use App\Models\AvtarComponent;
use App\Models\AvtarCategory;
use App\Models\AvtarType;
use App\Helper\BaseFunction;
use App\Models\UserAvatar;
use App\Models\User;
use App\Models\Notifications;
use Validator;
use JWTAuth;
use Carbon;

class AvatarController extends Controller
{
    public function avatarList(Request $request)
    {
        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }

        $checkAvatar=UserAvatar::where('user_id',$users->id)->where('status',1)->first();
        $avaterList=AvtarType::where('status',1)->get();
        $data['is_avatar']=$checkAvatar==""? 0 : 1;
        $data['avater_url']="";
        $data['cart_count']=0;
        $data['notification_count']=Notifications::where('user_id',$users->id)->where('type','avatar')->where('is_read','0')->count();

        if($checkAvatar!=""){
            $avater=AvtarType::where('id',$checkAvatar->avatar_id)->first();
            $data['cart_count']=UserAvatarCart::where('user_id',$users->id)->count();
            $data['avater_url']=\URL::to('godmode/avtar/view/').'/'.$avater->slug.'?user_id='.$users->id;
            $data['avater_clipboard']=\URL::to('godmode/avtar/clipboard/').'/'.$avater->slug.'?user_id='.$users->id;
        }
        $data['avater_list']=$avaterList;
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Avater List successfully','ResponseData'=>$data],200); 
    }

    public function avatarCreate(Request $request)
    {
        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }

        $validate = Validator::make($request->all(), [            
            'avatar_id' => 'required',
            
        ]);

        if($validate->fails()){
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }
        $checkAvatar=UserAvatar::where('user_id',$users->id)->where('status',1)->first();

        $avaterList=AvtarType::where('id',$request->avatar_id)->first();
        if($checkAvatar==""){
            $useravatar=new UserAvatar;
            $useravatar->user_id=$users->id;
            $useravatar->avatar_id=$request->avatar_id;
            $useravatar->avater_type=$avaterList->avtar_type;
            $useravatar->save();
        }
        $data['avater_url']=\URL::to('godmode/avtar/view/').'/'.$avaterList->slug.'?user_id='.$users->id;
        $data['avater_clipboard']=\URL::to('godmode/avtar/clipboard/').'/'.$avaterList->slug.'?user_id='.$users->id;
        $data['avater_list']=$avaterList;
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Avater List successfully','ResponseData'=>$data],200);
    }

    // avatarcartList
    public function avatarcartList(Request $request)
    {

        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }

        $componentlist = UserAvatarCart::join('avtar_components','user_avatar_carts.avatar_component_id','=','avtar_components.id')
          ->select('user_avatar_carts.*','avtar_components.image',\DB::raw("IF(avtar_components.image LIKE '%https://%' , avtar_components.image , ". "CONCAT('".url('/storage/app/public/uploads/avtar/component/')."/', avtar_components.image)) AS image"))
          ->where('user_id',$users->id)->get();

        $is_purchase=UserAvatarAttribute::where('user_id',$users->id)->get();

        foreach($componentlist as $value){  
                $value->is_purchase=0;
                if($is_purchase != ""){
                    foreach($is_purchase as $bdata){
                        if($value->avatar_component_id ==$bdata->avatar_component_id){
                            $value->is_purchase=1;
                        }
                    }
                }
            }


        $data['total_salmon']=User::where('id',$users->id)->select('total_gems')->first();  
        $data['componentlist']=$componentlist;  
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Cart List successfully','ResponseData'=>$data],200); 


    }

    // delete component cart list

    public function deleteitemCart(Request $request){

        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }

         $validate = Validator::make($request->all(), [            
            'component_id' => 'required',
        ]);

        if($validate->fails()){
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }
        $componentlist = explode(',',$request->component_id);
        foreach($componentlist as $value){
            $carlist = UserAvatarCart::where('id','=',$value)->delete();
        }
        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Delete component in Cart List successfully', 'ResponseData' => []], 200);
    }

    // purchase avatar component

    public function purchase(Request $request){

        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }

        $validate = Validator::make($request->all(), [            
            'component_id' => 'required',
        ]);

        if($validate->fails()){
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }
        $componentlist = explode(',',$request->component_id);
        $useravatar = UserAvatar::where('user_id','=',$users->id)->first();

        foreach($componentlist as $value){
          $amount=UserAvatarCart::where('id','=',$value)->first();
          $componentdata=AvtarComponent::with('avtarcategory')->where('id','=',$amount->avatar_component_id)->first(); 
          //  update saleman coin
          $coin = User::where('id',$users->id)->select('total_gems')->first();
          $finalcoin = intval($coin->total_gems) - $amount->amount;
          $coinupdate['total_gems'] = $finalcoin;

          $update = User::where('id',$users->id)->update($coinupdate);
          if($update){
              
              $cardelete = UserAvatarCart::where('id','=',$value)->delete();


              $data = new UserAvatarAttribute();
              $data->user_id = $users->id;
              $data->amount = $amount->amount;
              $data->user_avatar_id = $useravatar->id;
              $data->avatar_component_id = $amount->avatar_component_id;
              $data->type = 'buy';
              $data->save();
             

              $data->is_send=0;
              $data->image =url('/storage/app/public/uploads/avtar/component/').'/'.$componentdata->image;
              $title = 'Buy Gift';
              $body = 'You bought '.$componentdata->avtarcategory['name'].' from the shop';
              if($users->device_type == 0){
              $fcmFields = array(
                'registration_ids' =>array($users->device_token),
                'priority' => 'high',
                'data' =>array('message' => $body,'title' => $title,'sound' => "default","type"=>"normal",'data'=>$data));
                }else{
                    $fcmFields = array ('registration_ids' =>array($users->device_token),
                        'notification' =>array('title' => $title,'body' => $body,'sound' => "default","type"=>"normal",'data'=>$data));
                }

              $notification= new Notifications;
              $notification->user_id=$users->id;
              $notification->title=$title;
              $notification->message=$body;
              $notification->data=json_encode($fcmFields);
              $notification->type='avatar';
              $notification->save();
                  
          }

        }

        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Buy successfully','ResponseData'=>[]],200); 
    }

    // send gift 
    public function sendgift(Request $request){
      
      if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }

        $validate = Validator::make($request->all(), [            
            'component_id' => 'required',
            'user_id' => 'required'
        ]);

        if($validate->fails()){
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }

        $componentlist = explode(',',$request->component_id);
        $useravatar = UserAvatar::where('user_id','=',$request->user_id)->first(); // check user avatar girl or boy

        if($useravatar != ''){
            $checkavtar = 1;
            foreach($componentlist as $value){
              $cartdata=UserAvatarCart::where('id','=',$value)->first(); // cartdata
              if($cartdata != ''){
                $componentdata = AvtarComponent::with('avtartype')->where('id','=',$cartdata->avatar_component_id)->first();
                // dd($componentdata->avtartype['avtar_type']);
                if($useravatar->avater_type != $componentdata->avtartype['avtar_type']){
                   $checkavtar = 0;
                }  
              } 
            }

            if($checkavtar == 1){
                foreach($componentlist as $value){
                    $cartdata=UserAvatarCart::where('id','=',$value)->first();
                    $checkgift = UserAvatarAttribute::where('user_id',$request->user_id)->where('avatar_component_id',$cartdata->avatar_component_id)->count();
                    if($checkgift < 1){
                    if($cartdata != ''){
                        //update salemon coin
                        $coin = User::where('id',$users->id)->select('total_gems')->first();
                        $finalcoin = intval($coin->total_gems) - $cartdata->amount;
                        $coinupdate['total_gems'] = $finalcoin;
                        $update = User::where('id',$users->id)->update($coinupdate);
                        if($update){
                          $data = new UserAvatarAttribute();
                          $data->user_id = $request->user_id;
                          $data->send_user_id = $users->id;
                          $data->amount = $cartdata->amount;
                          $data->user_avatar_id = $useravatar->id;
                          $data->avatar_component_id = $cartdata->avatar_component_id;
                          $data->type = 'gift';
                          $data->status = '0';
                          if($data->save()){
                             $cardelete = UserAvatarCart::where('id','=',$value)->delete(); // delete component from cart 

                                $fromuser = User::where('id',$request->user_id)->first();
                                $body="You have received a special gift from ".$users->username;
                                $title="New Gift";
                                $avtardata=AvtarComponent::with('avtartype')->where('id','=',$cartdata->avatar_component_id)->first(); 
                                $avtardata->image = url('/storage/app/public/uploads/avtar/component/').'/'.$avtardata->image;
                                $avtardata->is_send = '1'; 
                                BaseFunction::sendNotification($fromuser,$title,$body,$avtardata,'avatar');
                          }
                        }

                    }else{
                        return response()->json(['ResponseCode'=>0,'ResponseText'=>'cart is empty.','ResponseData'=>[]],200);
                    }
                  }else{

                      return response()->json(['ResponseCode' => 0, 'ResponseText' => "You send the user already purchase this gift.", 'ResponseData' => []], 200);
                  }
                }
                 return response()->json(['ResponseCode'=>1,'ResponseText'=>'your gift has been sent successfully.','ResponseData'=>[]],200);

            }else{
              $msg = "Please select Same Component Another user Girl Avatar.";
              if($useravatar->avater_type == 1){
                $msg = "Please select Same Component Another user use boy Avatar.";
              }
              return response()->json(['ResponseCode' => 0, 'ResponseText' => $msg, 'ResponseData' => []], 200);
            }

     }else{
         return response()->json(['ResponseCode' => 0, 'ResponseText' =>"another user not selected any avatar you not send the gift.", 'ResponseData' => []], 200);
     }

    }

    // notification list
    public function notificationList(Request $request){

        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }
        
        $update = Notifications::where('user_id',$users->id)->where('type','avatar')->update(['is_read' => '1']);
        $notificationList = Notifications::where('user_id',$users->id)->where('type','avatar')->orderBy('id','desc')->get();
        $notification=[];
        foreach ($notificationList as $key => $value) {

            $data = json_decode($value->data);
            $val['id'] = $value->id;
            $val['title'] = $value->title;
            $val['user_id'] = $value->user_id;
            $val['message'] = $value->message;
            if(isset($data->notification)){
               $val['data'] = $data->notification; 
            }else{
               $val['data'] = $data->data;
            }
    
            $val['is_read'] = $value->is_read;
            $val['created_at'] = $value->created_at;
            $notification[] = $val;
        }

        return response()->json(['ResponseCode' => 1, 'ResponseText' =>"get notification list successfully.", 'ResponseData' => $notification], 200);
        
    }

    public function collectgift(Request $request){

        if (! $users = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 401);
        }

        $validate = Validator::make($request->all(), [            
            'component_id' => 'required',
            'type' => 'required',
            'notification_id' => 'required'
        ]);

        if($validate->fails()){
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }

        $userdata = UserAvatarAttribute::where('user_id',$users->id)->where('avatar_component_id',$request->component_id)->first();
       

        if($request->type == 'collect'){

            $touser = User::where('id',$userdata->send_user_id)->first();
            $body="You have sended a gift received by ".$users->username;
            $title="New Gift";
            $avtardata=AvtarComponent::with('avtartype')->where('id','=',$request->component_id)->first(); 
            $avtardata->image = url('/storage/app/public/uploads/avtar/component/').'/'.$avtardata->image;
            $avtardata->is_send = '0'; 
            BaseFunction::sendNotification($touser,$title,$body,$avtardata,'avatar');

            $fromuser = User::where('id',$users->id)->first();
            $body="You have collect a gift from ".$touser->username;
            $title="New Gift";
            $avtardata=AvtarComponent::with('avtartype')->where('id','=',$request->component_id)->first(); 
            $avtardata->image = url('/storage/app/public/uploads/avtar/component/').'/'.$avtardata->image;
            $avtardata->is_send = '0'; 
            BaseFunction::sendNotification($fromuser,$title,$body,$avtardata,'avatar');
   
            // notification status update
            $notification = Notifications::where('id',$request->notification_id)->first();
            $data = json_decode($notification->data);
            if(isset($data->notification)){
               $data->notification->data->is_send = 0;
            }else{
               $data->data->data->is_send = 0;
            }
            $notification = Notifications::where('id',$request->notification_id)->update(['data' => json_encode($data)]);
            

            $update = UserAvatarAttribute::where('user_id',$users->id)->where('avatar_component_id',$request->component_id)->update(['status' => '1']);

            if($update){
                return response()->json(['ResponseCode'=>1,'ResponseText'=>'your gift has been Received successfully.','ResponseData'=>[]],200);
            }else{
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'something went wrong.','ResponseData'=>[]],200);
            }


        }else{

            $touser = User::where('id',$userdata->send_user_id)->first();
            $body="You have sended a gift reject by ".$users->username;
            $title="New Gift";
            $avtardata=AvtarComponent::with('avtartype')->where('id','=',$request->component_id)->first(); 
            $avtardata->image = url('/storage/app/public/uploads/avtar/component/').'/'.$avtardata->image;
            $avtardata->is_send = '0'; 
            BaseFunction::sendNotification($touser,$title,$body,$avtardata,'avatar');

            $fromuser = User::where('id',$users->id)->first();
            $body="You reject a gift from ".$touser->username;
            $title="New Gift";
            $avtardata=AvtarComponent::with('avtartype')->where('id','=',$request->component_id)->first(); 
            $avtardata->image = url('/storage/app/public/uploads/avtar/component/').'/'.$avtardata->image;
            $avtardata->is_send = '0'; 
            BaseFunction::sendNotification($fromuser,$title,$body,$avtardata,'avatar');

            // return coin to send user
            $componentdata =AvtarComponent::where('id',$request->component_id)->first();
            $total_gems = $touser->total_gems + $componentdata->amount;
            $update = User::where('id',$userdata->send_user_id)->update(['total_gems'=>$total_gems]);


            // notification status update
            $notification = Notifications::where('id',$request->notification_id)->first();
            $data = json_decode($notification->data);
            if(isset($data->notification)){
               $data->notification->data->is_send = 0;
            }else{
               $data->data->data->is_send = 0;
            }
            $notification = Notifications::where('id',$request->notification_id)->update(['data' => json_encode($data)]);
           

            // update status component
            $delete = UserAvatarAttribute::where('user_id',$users->id)->where('avatar_component_id',$request->component_id)->where('type','gift')->delete();
             // dd($request->component_id);

            if($delete){
                return response()->json(['ResponseCode'=>1,'ResponseText'=>'your gift has been Reject successfully.','ResponseData'=>[]],200);
            }else{
                return response()->json(['ResponseCode'=>0,'ResponseText'=>'something went wrong.','ResponseData'=>[]],200);
            }


        }

    }

}
