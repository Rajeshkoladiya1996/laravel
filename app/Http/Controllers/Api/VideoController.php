<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use App\Models\User;
use App\Models\UserBlock;
use App\Models\UserFollower;
use App\Models\UserFavourite;
use App\Models\UserLevelDetail;
use App\Models\LiveStreamUser;
use App\Models\StreamViewerUser;
use App\Helper\BaseFunction;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    // Video Total View
    public function videoTotalView(Request $request)
    {

        $rule=[
            'stream_name'=>'required',
        ];
        $message=[
            'stream_name.required'=>'Stream Name is required',
        ];
        $validate=Validator::make($request->all(),$rule,$message);

        if($validate->fails())
        {
            return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }

        $url="http://bklive.stream:5080/WebRTCAppEE/rest/v2/broadcasts/".$request->stream_name."/broadcast-statistics";
        $response=BaseFunction::curlCallApi($url);
        $data=json_decode($response);
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Total Viewer Successfully','ResponseData'=>$data],200);
        
    }
    //Live Stream List 
    public function liveStreamList(Request $request)
    {
        try{
            if (! $users = JWTAuth::parseToken()->authenticate()) {
                  return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
            }
            $rule=[
                 'offset'=>'required',
                 'size'=>'required',
            ];
            $message=[
                 'offset.required'=>'Offset is required',
                 'size.required'=>'Size is required',
            ];
            $validate=Validator::make($request->all(),$rule,$message);

            if($validate->fails())
            {
                return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
            }
            // $response=BaseFunction::liveStreamList($request->offset,$request->size);
            $response=BaseFunction::agoraliveStreamList();
            
            $loginuser=compact('users');
            // echo $response;
            $streamlist=json_decode($response);
          

            // if(isset($request->search_text) && ($request->search_text != '')) {
            //     $user=$user->where('username', 'like', $request->search_text.'%');
            // }

            // $user = $user->get();

            $sorted=array(); 
            $viewer=array();
            $userdata=array();
            $is_live=array();

            foreach ($streamlist->data->channels as $key => $antdata) {
                $user=User::withCount(['followers','following','favourite'])->where('id','!=',$loginuser['users']->id)->where('stream_id',$antdata->channel_name)->where('user_type','1')->first();
                if($user!=""){
                    if($antdata->channel_name==$user->stream_id){
                        $is_block=UserBlock::where('from_id',$loginuser['users']->id)->where('to_id',$user->id)->count();
                        if($is_block==0){
                            $user->is_live=0;
                            $user->type='';
                            $user->streamId='';
                            $user->startTime=1613364473285;
                            $user->webRTCViewerCount=0;
                            $user->status='';
                            $user->publish='';
                            $user->date='';
                            $user->ipAddr='';
                        
                            $latest_live = LiveStreamUser::where('stream_id',$user->stream_id)->orderBy('id','DESC')->first();
                            $user->is_live=1;
                            $user->type=1;
                            $user->streamId=$antdata->channel_name;
                            $user->startTime=strtotime($latest_live->created_at);
                            $user->webRTCViewerCount=$antdata->user_count == 0 ? 0 : $antdata->user_count - 1;
                            $user->status='active';
                            $user->publish='publish';
                            $user->date=date('Y-m-d');
                            $user->ipAddr='0.0.0.0';
                            $user->profile_pic=url('/storage/app/public/uploads/users/')."/". $user->profile_pic;
                            $user->followers=$user->followers_count ;
                            $user->following=$user->following_count ;
                            $user->favourite=$user->favourite_count ;

                            $is_follower=UserFollower::where('from_id',$user->id)->where('to_id',$loginuser['users']->id)->count();
                            $is_following=UserFollower::where('from_id',$loginuser['users']->id)->where('to_id',$user->id)->count();
                            $is_favourite=UserFavourite::where('from_id',$loginuser['users']->id)->where('to_id',$user->id)->count();

                            $user->is_follower=($is_follower==1)? true : false ;
                            $user->is_following=($is_following==1)? true : false ;
                            $user->is_favourite=($is_favourite==1)? true : false ;
                            $userdata[$key]=$user;
                            $sorted[$key] = $user->startTime;
                            $viewer[$key] = $user->webRTCViewerCount;
                            $is_live[$key] = $user->is_live;
                        }
                    }
                }
            } 

            if(isset($request->search_text) && ($request->search_text != '')) {
                $temp=array();
                foreach($userdata as $key => $value){
                    if(strval(stripos($value->username, $request->search_text))!=""){
                        $temp[$key]=$value;
                        echo "<pre>";
                        print_r($temp);
                        die;
                    }
                }
                // $userdata=$temp;
            }    
            // array_multisort($sorted, SORT_DESC, $userdata);
            // array_multisort($viewer, SORT_DESC, $userdata);
            // array_multisort($is_live, SORT_DESC, $userdata);

            usort($userdata, function($a, $b) {
                return $b['webRTCViewerCount'] - $a['webRTCViewerCount'];
            });
            usort($userdata, function($a, $b) {
                return $b['is_live'] - $a['is_live'];
            });

            return response()->json(['ResponseCode'=>1,'ResponseText'=>'Live Streamer all list Successfully','ResponseData'=>$userdata],200);
            
        }catch(\Exception $e){
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'Something went wrong','ResponseData'=>$e],500);
        }
       
    }

    // User Category wise
    public function userCategorywise(Request $request)
    {
        try{
            if (! $users = JWTAuth::parseToken()->authenticate()) {
                  return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
            }
            $rule=[
                'category'=>'required',
            ];
            $message=[
                'category.required'=>'category is required',
            ];
            $validate=Validator::make($request->all(),$rule,$message);

            if($validate->fails())
            {
                return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
            }
            $response=BaseFunction::agoraliveStreamList();
            // $response=BaseFunction::liveStreamList(0,1000);
            $loginuser=compact('users');
            // echo $response;
            $streamlist=json_decode($response);
            // $user=User::withCount(['followers','following','favourite'])->where('id','!=',$loginuser['users']->id)->where('user_type','1');

            // if(isset($request->search_text) && ($request->search_text != '')) {
            //     $user=$user->where('username', 'like', $request->search_text.'%');
            // }

            // $user = $user->get();


            $sorted=array(); 
            $viewer=array();
            $followers=array(); 
            $is_live=array(); 
            $userdata=array();

           	foreach ($streamlist->data->channels as $key => $antdata) {
                $user=User::withCount(['followers','following','favourite'])->where('id','!=',$loginuser['users']->id)->where('stream_id',$antdata->channel_name)->where('user_type','1')->first();
                if($user!=""){
                    if($antdata->channel_name==$value->stream_id){
                        $is_block=UserBlock::where('from_id',$loginuser['users']->id)->where('to_id',$user->id)->count();
                        if($is_block==0){
                            $user->is_live=0;
                            $user->type='';
                            $user->streamId='';
                            $user->startTime=1613364473285;
                            $user->webRTCViewerCount=0;
                            $user->status='';
                            $user->publish='';
                            $user->date='';
                            $user->ipAddr='';

                            $latest_live = LiveStreamUser::where('stream_id',$user->stream_id)->orderBy('id','DESC')->first();
                        	$user->is_live=1;
                            $user->type=1;
                            $user->streamId=$antdata->channel_name;
                            $user->startTime=strtotime($latest_live->created_at);
                            $user->webRTCViewerCount=$antdata->user_count == 0 ? 0 : $antdata->user_count - 1;
                            $user->status='active';
                            $user->publish='publish';
                            $user->date=date('Y-m-d');
                            $user->ipAddr='0.0.0.0';
                                    
                            $user->profile_pic=url('/storage/app/public/uploads/users/')."/". $user->profile_pic;
                            $user->followers=$user->followers_count ;
                            $user->following=$user->following_count ;
                            $user->favourite=$user->favourite_count ;

                            $is_follower=UserFollower::where('from_id',$user->id)->where('to_id',$loginuser['users']->id)->count();
                            $is_following=UserFollower::where('from_id',$loginuser['users']->id)->where('to_id',$user->id)->count();
                            $is_favourite=UserFavourite::where('from_id',$loginuser['users']->id)->where('to_id',$user->id)->count();

                            $user->is_follower=($is_follower==1)? true : false ;
                            $user->is_following=($is_following==1)? true : false ;
                            $user->is_favourite=($is_favourite==1)? true : false ;
                            // search filter
                            
                            $userdata[$key]=$user;
                            $sorted[$key] = $user->startTime;
                            $followers[$key] = $user->followers;
                            $viewer[$key] = $user->webRTCViewerCount;
                            $is_live[$key] = $user->is_live;

                        
                        }
                    }
                }
            }

            if(isset($request->search_text) && ($request->search_text != '')) {
                $temp=array();
                foreach($userdata as $key => $value){
                    if(strval(stripos($value->username, $request->search_text))!=""){
                        $temp[$key]=$value;
                    }
                }
                $userdata=$temp;
            }
            // array_multisort($sorted, SORT_DESC, $userdata);
            // array_multisort($viewer, SORT_DESC, $userdata);
            // array_multisort($is_live, SORT_DESC, $userdata);
            usort($userdata, function($a, $b) {
                return $b['webRTCViewerCount'] - $a['webRTCViewerCount'];
            });
            usort($userdata, function($a, $b) {
                return $b['is_live'] - $a['is_live'];
            });



            $nowdate=date('Y-m-d');
            $dailypoint = UserLevelDetail::where('user_id',$loginuser['users']->id)->where('level_detail_id',6)->where('date',$nowdate)->count();
            if($request->category=="1"){                               
                // array_multisort($followers, SORT_DESC, $userdata);
                usort($userdata, function($a, $b) {
                    return $b['followers'] - $a['followers'];
                });
                return response()->json(['ResponseCode'=>1,'ResponseText'=>'Live Streamer List base on category Successfully','ResponseData'=>$userdata,'dailypoint'=>$dailypoint],200);
            }elseif($request->category=="2"){
                return response()->json(['ResponseCode'=>1,'ResponseText'=>'Live Streamer List base on category Successfully','ResponseData'=>$userdata,'dailypoint'=>$dailypoint],200);
            }else{     
                return response()->json(['ResponseCode'=>1,'ResponseText'=>'Live Streamer List base on category Successfully','ResponseData'=>$userdata,'dailypoint'=>$dailypoint],200);
            }
        }catch(\Exception $e){
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'Something went wrong','ResponseData'=>$e],500);
        }
    }

    // Follower and Favourite Live List
    public function followerLiveList(Request $request)
    {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
        }
        $loginuser=compact('user');
        $response=BaseFunction::liveStreamList(0,1000);
        $streamlist=json_decode($response);
        $followdata=UserFollower::with('followinguser')->where('from_id',$loginuser['user']->id)->get();
        $favouritedata=UserFavourite::with('favouriteuser')->where('from_id',$loginuser['user']->id)->get();
        $data=array();
        $fadata=array();
        $i=0;
        foreach ($followdata as $key => $value) {
            if($streamlist!=""){            
                foreach ($streamlist as $antdata) {
                    if($antdata->streamId==$value['followinguser']->stream_id){
                        $is_block=UserBlock::with('user')->where('from_id',$value['followinguser']->id)->where('to_id',$loginuser['users']->id)->count();
                        if($is_block==0){                        
                            $data[$i]['user_id']=$value['followinguser']->id;
                            $data[$i]['stream_id']=$value['followinguser']->stream_id;
                            $data[$i]['is_live']=1;
                            $data[$i]['startTime']=$antdata->startTime;
                            $data[$i]['webRTCViewerCount']=$antdata->webRTCViewerCount;
                            $i++;
                        }
                    }
                }
            }
        }
        $j=0;
        foreach ($favouritedata as $key => $value) {
            if($streamlist!=""){            
                foreach ($streamlist as $antdata) {
                    if($antdata->streamId==$value['favouriteuser']->stream_id){
                        $is_block=UserBlock::with('user')->where('from_id',$value['favouriteuser']->id)->where('to_id',$loginuser['users']->id)->count();
                        if($is_block==0){
                            $fadata[$j]['user_id']=$value['favouriteuser']->id;
                            $fadata[$j]['stream_id']=$value['favouriteuser']->stream_id;
                            $fadata[$j]['is_live']=1;
                            $fadata[$j]['startTime']=$antdata->startTime;
                            $fadata[$j]['webRTCViewerCount']=$antdata->webRTCViewerCount;
                            $j++;
                        }
                    }
                }
            }
        }

        return response()->json(['ResponseCode'=>1,'ResponseText'=>'My following user live list successfully','ResponseData'=>['follower'=>$data,'favourite'=>$fadata]],200);
    }

    // testApiAntMedia function
    public function testApiAntMedia(Request $request)
    {
        $rule=[
                'api_url'=>'required',
        ];
        $message=[
            'api_url.required'=>'Url is required',
        ];
        $validate=Validator::make($request->all(),$rule,$message);

        if($validate->fails())
        {
            return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }
        $response=BaseFunction::curlCallApi($request->api_url);
        $streamlist=json_decode($response);
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Data','ResponseData'=>$streamlist],200);
    }

    // testApisslAntMedia function
    public function testApisslAntMedia(Request $request)
    {
        $rule=[
                'api_url'=>'required',
        ];
        $message=[
            'api_url.required'=>'Url is required',
        ];
        $validate=Validator::make($request->all(),$rule,$message);

        if($validate->fails())
        {
            return response()->json(['ResponseCode'=>'0','ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }
        $response=BaseFunction::curlCallSSlApi($request->api_url);
        $streamlist=json_decode($response);
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'Data','ResponseData'=>$streamlist],200);
    }

    // viewerListInStream funcation
    public function viewerListInStream(Request $request)
    {
        $rule=[
                'stream_id'=>'required',
        ];
        $message=[
            'stream_id.required'=>'stream_id is required',
        ];
        $validate=Validator::make($request->all(),$rule,$message);

        if($validate->fails())
        {
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>$validate->errors()->all()]],499);
        }

        $data =  LiveStreamUser::where('stream_id',$request->stream_id)->orderBy('id','DESC')->first();
        $streamvieweruser = StreamViewerUser::with('user')->where('live_stream_id',$data->id)->groupBy('user_id')->get();
        return response()->json(['ResponseCode'=>1,'ResponseText'=>'viewer list in stream','ResponseData'=>$streamvieweruser],200);

    }

    //Search user function
    public function searchUser(Request $request)
    {
        try{
            if (! $users = JWTAuth::parseToken()->authenticate()) {
                  return response()->json(['ResponseCode'=>0,'ResponseText'=>'validation fail','ResponseData'=>['errors'=>'user_not_found']], 404);
            }
            
            $response=BaseFunction::agoraliveStreamList();
            
            $streamlist=json_decode($response);
          
            $user=User::users()->withCount(['followers','following','favourite'])->where('id','!=',$users->id)->where('user_type','1');

            if(isset($request->search) && ($request->search != '')) {
                $user=$user->where('username', 'like', $request->search.'%');
                $user=$user->orwhere('stream_id', 'like', '%'.$request->search.'%');
            }

            $user = $user->get();

            $sorted=array(); 
            $viewer=array();
            $userdata=array();
            $is_live=array();

            foreach ($user as $key => $value) {
                $is_block=UserBlock::where('from_id',$users->id)->where('to_id',$value->id)->count();
                if($is_block==0){
                    $value->is_live=0;
                    $value->type='';
                    $value->streamId='';
                    $value->startTime=1613364473285;
                    $value->webRTCViewerCount=0;
                    $value->status='';
                    $value->publish='';
                    $value->date='';
                    $value->ipAddr='';
                    foreach ($streamlist->data->channels as $antdata) {
                        if($antdata->channel_name==$value->stream_id){
                            $latest_live = LiveStreamUser::where('stream_id',$value->stream_id)->orderBy('id','DESC')->first();
                            $value->is_live=1;
                            $value->type=1;
                            $value->streamId=$antdata->channel_name;
                            $value->startTime=strtotime($latest_live->created_at);
                            $value->webRTCViewerCount=$antdata->user_count == 0 ? 0 : $antdata->user_count - 1;
                            $value->status='active';
                            $value->publish='publish';
                            $value->date=date('Y-m-d');
                            $value->ipAddr='0.0.0.0';
                            break;
                        }
                    }
                    $value->profile_pic=url('/storage/app/public/uploads/users/')."/". $value->profile_pic;
                    $value->followers=$value->followers_count ;
                    $value->following=$value->following_count ;
                    $value->favourite=$value->favourite_count ;

                    $is_follower=UserFollower::where('from_id',$value->id)->where('to_id',$users->id)->count();
                    $is_following=UserFollower::where('from_id',$users->id)->where('to_id',$value->id)->count();
                    $is_favourite=UserFavourite::where('from_id',$users->id)->where('to_id',$value->id)->count();

                    $value->is_follower=($is_follower==1)? true : false ;
                    $value->is_following=($is_following==1)? true : false ;
                    $value->is_favourite=($is_favourite==1)? true : false ;
                    $userdata[$key]=$value;
                    $sorted[$key] = $value->startTime;
                    $viewer[$key] = $value->webRTCViewerCount;
                    $is_live[$key] = $value->is_live;
                }
            }            

            usort($userdata, function($a, $b) {
                return $b['webRTCViewerCount'] - $a['webRTCViewerCount'];
            });
            usort($userdata, function($a, $b) {
                return $b['is_live'] - $a['is_live'];
            });

            return response()->json(['ResponseCode'=>1,'ResponseText'=>'Live Streamer all list Successfully','ResponseData'=>$userdata],200);
            
        }catch(\Exception $e){
            return response()->json(['ResponseCode'=>0,'ResponseText'=>'Something went wrong','ResponseData'=>$e],500);
        }
       
    }
}

// $2y$10$errR7Q.mKBOpxYO3tpMaUOJuBZFfqdKxGm1IpgdtivDCAWowWbSIO