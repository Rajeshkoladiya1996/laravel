<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserFollower;
use App\Models\UserFavourite;
use App\Models\Battle;
use App\Models\LiveStreamUser;
use App\Helper\BaseFunction;
use Log;

class LiveStreamController2 extends Controller
{
    public function index(Request $request)
    {
    	try{
            $response=BaseFunction::agoraliveStreamList();
                            
            $streamlist1=json_decode($response);
            $data=array();
            $streamlist=array();
            $streamlistbattel=array();
            foreach ($streamlist1->data->channels as $key=> $value) {
                $user=User::where('stream_id',$value->channel_name)->first();

                if($user!=""){     
                    $latest_live = LiveStreamUser::where('stream_id',$user->stream_id)->orderBy('id','DESC')->first();
                    $streamlist[$key]['startTime']=strtotime($latest_live->created_at);       
                    $streamlist[$key]['id']=$user->id;
                    $streamlist[$key]['username']=$user->username;
                    $streamlist[$key]['gender']=$user->gender;
                    $streamlist[$key]['email']=$user->email;
                    $streamlist[$key]['phone']=$user->phone;
                    $streamlist[$key]['stream_id']=$user->stream_id;
                    $streamlist[$key]['stream_token']=$user->stream_token;
                    $value->webRTCViewerCount=$value->user_count == 0 ? 0 : $value->user_count - 1;
                    $streamlist[$key]['county_code']=$user->county_code;
                    $streamlist[$key]['followers']=UserFollower::where('from_id',$user->id)->count();
                    $streamlist[$key]['following']=UserFollower::where('to_id',$user->id)->count();
                    $streamlist[$key]['favourite']=UserFavourite::where('from_id',$user->id)->count();                      
                    if($user->profile_pic!=""){
                        $streamlist[$key]['profile_pic']=URL('/storage/app/public/uploads/users/'.$user->profile_pic);
                    }else{
                       $streamlist[$key]['profile_pic']=URL('/storage/app/public/uploads/users/default.png');
                    }
                     $streamlist[$key]['type'] = 'solo';
                     //return view('admin.liveStream.index',compact('streamlist'));
                }                    
                 
            }
           

            foreach ($streamlist1->data->channels as $key=> $value) {
                $battles_user = Battle::with('from_user','to_user')->where('stream_id',$value->channel_name)->first();
                if(!empty($battles_user)){
                $streamlistbattel[$key]['id']=$battles_user->from_user->id;
                $streamlistbattel[$key]['username']=$battles_user->from_user->username;
                $streamlistbattel[$key]['to_username']=$battles_user->to_user->username;
                $streamlistbattel[$key]['gender']=$battles_user->from_user->gender;
                $streamlistbattel[$key]['email']=$battles_user->from_user->email;
                $streamlistbattel[$key]['phone']=$battles_user->from_user->phone;
                $streamlistbattel[$key]['stream_id']=$battles_user->stream_id;
                $streamlist[$key]['stream_token']=$battles_user->stream_token;
                $value->webRTCViewerCount=$value->user_count == 0 ? 0 : $value->user_count - 1;
                $streamlistbattel[$key]['county_code']=$battles_user->from_user->county_code;
                $streamlistbattel[$key]['followers']=UserFollower::where('from_id',$battles_user->from_user->id)->count();
                $streamlistbattel[$key]['following']=UserFollower::where('to_id',$battles_user->from_user->id)->count();
                $streamlistbattel[$key]['favourite']=UserFavourite::where('from_id',$battles_user->from_user->id)->count();  

                 if($battles_user->from_user->profile_pic!=""){
                    $streamlistbattel[$key]['profile_pic']=$battles_user->from_user->profile_pic;
                    $streamlistbattel[$key]['to_profile_pic']=$battles_user->to_user->profile_pic;
                }else{
                   $streamlistbattel[$key]['profile_pic']=URL('/storage/app/public/uploads/users/default.png');
                }   
                $streamlistbattel[$key]['type'] = 'battle';
             }

            }


          
            return view('admin.liveStream2.index',compact('streamlist','streamlistbattel'));
            
        }catch(\Exception $e){
            $streamlist=array();
            $streamlistbattel=array();
            return view('admin.liveStream2.index',compact('streamlist','streamlistbattel'));
        }
    }

    public function liveStreamList(Request $request)
    {
    	try{
            
            $response=BaseFunction::agoraliveStreamList();
                            
            $streamlist1=json_decode($response);
            $data=array();
            $streamlist=array();
            $streamlistbattel=array();
             
            if($request->type=="solo"){
                foreach ($streamlist1->data->channels as $key=> $value) {

                    $user=User::where('stream_id',$value->channel_name)->first();

                    if($user!=""){     

                        $streamlist[$key]['id']=$user->id;
                        $streamlist[$key]['username']=$user->username;
                        $streamlist[$key]['gender']=$user->gender;
                        $streamlist[$key]['email']=$user->email;
                        $streamlist[$key]['phone']=$user->phone;
                        $streamlist[$key]['stream_id']=$user->stream_id;
                        $streamlist[$key]['stream_token']=$user->stream_token;
                        $value->webRTCViewerCount=$value->user_count == 0 ? 0 : $value->user_count - 1;
                        $streamlist[$key]['county_code']=$user->county_code;
                        $streamlist[$key]['followers']=UserFollower::where('from_id',$user->id)->count();
                        $streamlist[$key]['following']=UserFollower::where('to_id',$user->id)->count();
                        $streamlist[$key]['favourite']=UserFavourite::where('from_id',$user->id)->count();                      
           
                        if($user->profile_pic!=""){
                            $streamlist[$key]['profile_pic']=URL('/storage/app/public/uploads/users/'.$user->profile_pic);
                        }else{
                           $streamlist[$key]['profile_pic']=URL('/storage/app/public/uploads/users/default.png');
                        }
                        $streamlist[$key]['type'] = 'solo';
                    }                    
                     
                }

                return view('admin.liveStream2.streamList', compact('streamlist'));
                
            }else{
                foreach ($streamlist1->data->channels as $key=> $value) {
                    $battles_user = Battle::with('from_user','to_user')->where('stream_id',$value->channel_name)->first();
                    if(!empty($battles_user)){
                    $streamlistbattel[$key]['id']=$battles_user->from_user->id;
                    $streamlistbattel[$key]['username']=$battles_user->from_user->username;
                    $streamlistbattel[$key]['to_username']=$battles_user->to_user->username;
                    $streamlistbattel[$key]['gender']=$battles_user->from_user->gender;
                    $streamlistbattel[$key]['email']=$battles_user->from_user->email;
                    $streamlistbattel[$key]['phone']=$battles_user->from_user->phone;
                    $streamlistbattel[$key]['stream_id']=$battles_user->stream_id;
                    $streamlist[$key]['stream_token']=$battles_user->stream_token;
                    $value->webRTCViewerCount=$value->user_count == 0 ? 0 : $value->user_count - 1;
                    $streamlistbattel[$key]['county_code']=$battles_user->from_user->county_code;
                    $streamlistbattel[$key]['followers']=UserFollower::where('from_id',$battles_user->from_user->id)->count();
                    $streamlistbattel[$key]['following']=UserFollower::where('to_id',$battles_user->from_user->id)->count();
                    $streamlistbattel[$key]['favourite']=UserFavourite::where('from_id',$battles_user->from_user->id)->count();  
                     if($battles_user->from_user->profile_pic!=""){
                        $streamlistbattel[$key]['profile_pic']=$battles_user->from_user->profile_pic;
                        $streamlistbattel[$key]['to_profile_pic']=$battles_user->to_user->profile_pic;
                    }else{
                       $streamlistbattel[$key]['profile_pic']=URL('/storage/app/public/uploads/users/default.png');
                    }   
                    $streamlistbattel[$key]['type'] = 'battle';
                  }
                }
                return view('admin.liveStream2.battlesList', compact('streamlistbattel'));
            }    
                      
        }catch(\Exception $e){
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'Something went wrong','ResponseData'=>$e],500);
        }
    }

    public function liveStreamView(Request $request)
    {
        // try{
            // $url="http://bklive.stream:5080/WebRTCAppEE/rest/v2/broadcasts/conference-rooms/".$request->stream_id."/room-info";
            // $response=BaseFunction::curlCallApi($url);
            // $streamlist=json_decode($response);
           $streamlist=User::where('stream_id',$request->stream_id)->first(); 
            return $streamlist;                
        // }catch(\Exception $e){
        //     return response()->json(['ResponseCode'=>0,'ResponseText'=>'Something went wrong','ResponseData'=>$e],500);
        // }
    }

    public function livebattlesStreamView(Request $request){

      $streamlist = Battle::with('from_user','to_user')->where('stream_id',$request->stream_id)->first(); 
      return $streamlist; 

    }
}
