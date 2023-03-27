<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Gift;
use App\Models\EventWiner;
use App\Models\RewardEvent;
use App\Helper\BaseFunction;
use App\Models\GiftCategory;
use App\Models\EventParticipant;
use DB;

class EventController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Bangkok');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventList = Event::orderBy('status','DESC')->orderBy('updated_at','DESC')->get();
        $giftCategory=GiftCategory::orderBy('updated_at','DESC')->get();
        $giftList=Gift::get();
        return view('admin.event.index',compact('eventList','giftCategory','giftList'));
    }

    /**---------------------------------------------------
     *  Store Event Detail
     *  @Created By : Rajesh Koladiya
     *  @Created At : 16-07-2021
     * ---------------------------------------------------
     */

    public function store(Request $request){

         $this->validate($request,[
            'event_name'=>'required',
            'event_thai_name'=>'required',
            'description'=>'required',
            'thai_description'=>'required',
            'terms_condition'=>'required',
            'thai_terms_condition'=>'required',
            'start_date'=>'required',
            'end_date'=>'required|after:start_date',
            'stream_type'=>'required',
            'reward_type'=>'required',
            'primary_color'=>'required',
            'secondry_color'=>'required',
            'reward_desc.*'=>'required',
            'thai_reward_desc.*'=>'required',
            'reward_day.*'=>'required|regex:/^[0-9]+$/u',
            'event_type'=>'required',
            'event_image'=>'mimes:jpeg,png,jpg,svg',
            'win_reward_type'=>'required',
        ]);

        // dd($request->file('frame_image'));
        // 'event_points'=>'required',
        // 'reward_point.*'=>'required|regex:/^[0-9]+$/u',
        // 'rgift.*'=>'required',
        // 'frmae_image.*'=>'required',
        // 'frame_days.*'=>'required',
        $data = new Event;
        $data->event_name = $request->event_name;
        $data->event_thai_name=$request->event_thai_name;
        $data->description = $request->description;
        $data->thai_description=$request->thai_description;
        $data->start_date=$request->start_date;
        $data->end_date=$request->end_date;
        $data->terms_condition=$request->terms_condition;
        $data->thai_terms_condition=$request->thai_terms_condition;
        $streamData="";
        foreach($request->stream_type as $key=>$value){
            $streamData.= $value.',';
        }

        $data->stream_type=$streamData;
        $data->reward_type=$request->reward_type;
        if($request->reward_type=="gift"){
            $this->validate($request,[
                'gift_catgeory'=>'required',
                'giftSalmon'=>'required'
            ]);
            $data->gift_category_id=$request->gift_catgeory;
            $gift="";
            foreach ($request->giftSalmon as $value) {
                $gift.=$value.",";
            }
            $data->gift_id=$gift;
        }
        $data->primary_color=$request->primary_color;
        $data->secondry_color=$request->secondry_color;
        if($request->is_gradient){
            $data->isGradient=1;
        }else{
            $data->isGradient=0;
        }
        $data->start_gradient=$request->start_gradient;
        $data->end_gradient=$request->end_gradient;
        // $data->points = $request->event_points;
        $data->slug=strtolower(str_replace(' ','-',$request->event_name));
        $data->event_type=$request->event_type;

        //win reward type
        $data->win_reward_type=$request->win_reward_type;

        $image = $request->file('event_image');
        if ($image != null) {
            $new_name =  rand() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('/app/public/uploads/event/'), $new_name);
            $data->image = $new_name;
        }
        if ($data->save()) {
            foreach($request->reward_desc as $key=>$value){
                $rdata=new RewardEvent();
                $rdata->event_id=$data->id;
                $rdata->description=$request->reward_desc[$key];
                $rdata->thai_description=$request->thai_reward_desc[$key];
                $rdata->days=$request->reward_day[$key];
                //win reward type data
                $rdata->points=NULL;
                $rdata->gift_id=NULL;
                $rdata->frame_days=NULL;
                $rdata->frame_file=NULL;
                if($data->win_reward_type=="gift"){
                    $rdata->gift_id=$request->rgift[$key];
                }else if($data->win_reward_type=="salmon" || $data->win_reward_type=="exp" || $data->win_reward_type=="baht"){
                    $rdata->points=$request->reward_point[$key];
                }else if($data->win_reward_type=="frame"){
                    $rdata->frame_days=$request->frame_days[$key];
                    $fimage = $request->file('frame_image');
                    $fi=$fimage[$key];
                    if ($fi != null) {
                        $fnew_name =  rand() . '.' . $fi->getClientOriginalExtension();
                        $fi->move(storage_path('/app/public/uploads/event/frame'), $fnew_name);
                        $rdata->frame_file = $fnew_name;
                    }
                }
                $rdata->win_reward_type=$data->win_reward_type;

                $rdata->save();
            }
            return 1;
        }else{
            return 0;
        }

    }

    /**---------------------------------------------------
     *  Get Event list
     *  @Created By : Rajesh Koladiya
     *  @Created At : 16-07-2021
     * ---------------------------------------------------
     */

    public function list(){
        $eventList = Event::orderBy('status','DESC')->orderBy('updated_at','DESC')->get();
        return view('admin.event.eventList',compact('eventList'));
    }

    public function eventData($id){
        $EventDetail=Event::where('id',$id)->with('rewardEvent','gift_category')->first();
        return view('admin.event.displayEventData',compact('EventDetail'));
    }

    public function giftData($id){
        $giftList=Gift::where('gift_category_id',$id)->get();
        return response()->json(['giftList'=>$giftList], 200);
    }

    public function edit($id)
    {
        $EventDetail=Event::where('id',$id)->with('rewardEvent','gift_category')->first();
        return response()->json(['eventDetail'=>$EventDetail], 200);
    }


     public function update(Request $request)
    {
        $this->validate($request,[
            'edit_event_name'=>'required',
            'edit_event_thai_name'=>'required',
            'edit_description'=>'required',
            'edit_thai_description'=>'required',
            'edit_terms_condition'=>'required',
            'edit_thai_terms_condition'=>'required',
            'edit_start_date'=>'required',
            'edit_end_date'=>'required|after:edit_start_date',
            'edit_stream_type'=>'required',
            'edit_reward_type'=>'required',
            'edit_primary_color'=>'required',
            'edit_secondry_color'=>'required',
            'edit_reward_desc.*'=>'required',
            'edit_thai_reward_desc.*'=>'required',
            'edit_reward_day.*'=>'required|regex:/^[0-9]+$/u',
            'editevent_type'=>'required',
            'editwin_reward_type'=>'required',
            'edit_event_image'=>'mimes:jpeg,png,jpg,svg'
        ]);
        // 'edit_event_points'=>'required',
        // 'edit_reward_point.*'=>'required|regex:/^[0-9]+$/u',

        $data = Event::findOrFail($request->id);
        $data->event_name = $request->edit_event_name;
        $data->event_thai_name=$request->edit_event_thai_name;
        $data->description = $request->edit_description;
        $data->thai_description=$request->edit_thai_description;
        $data->slug=strtolower(str_replace(' ','-',$request->edit_event_name));
        // $data->points = $request->edit_event_points;

        $data->start_date=$request->edit_start_date;
        $data->end_date=$request->edit_end_date;
        $data->terms_condition=$request->edit_terms_condition;
        $data->thai_terms_condition=$request->edit_thai_terms_condition;
        $streamData="";
        foreach($request->edit_stream_type as $key=>$value){
            $streamData.= $value.',';
        }

        $data->stream_type=$streamData;
        $data->reward_type=$request->edit_reward_type;
        if($request->edit_reward_type=="gift"){
            $this->validate($request,[
                'edit_gift_catgeory'=>'required',
                'editgiftSalmon'=>'required'
            ]);
            $data->gift_category_id=$request->edit_gift_catgeory;
            $gift="";
            foreach ($request->editgiftSalmon as $value) {
                $gift.=$value.",";
            }
            $data->gift_id=$gift;
        }
        $data->event_type=$request->editevent_type;
        $data->primary_color=$request->edit_primary_color;
        $data->secondry_color=$request->edit_secondry_color;
        if($request->edit_is_gradient){
            $data->isGradient=1;
        }else{
            $data->isGradient=0;
        }
        $data->start_gradient=$request->edit_start_gradient;
        $data->end_gradient=$request->edit_end_gradient;


        if(isset($request->edit_event_image)){
            $image = $request->file('edit_event_image');
            if ($image != null) {
                $new_name =  rand() . '.' . $image->getClientOriginalExtension();
                $image->move(storage_path('/app/public/uploads/event/'), $new_name);

                if(\File::exists(storage_path('app/public/uploads/event'.'/'.$data->image))){
                    \File::delete(storage_path('app/public/uploads/event'.'/'.$data->image));
                }
                $data->image = $new_name;
            }
        }
        //win reward type
        $data->win_reward_type=$request->editwin_reward_type;

        if($data->save()){
            $fdata=RewardEvent::where('event_id',$data->id)->first();
            if($fdata!=null){
                $RewardEvent=RewardEvent::where('event_id', $data->id)->delete();
            }
            foreach($request->edit_reward_desc as $key=>$value){
                $rdata=new RewardEvent();
                $rdata->event_id=$data->id;
                $rdata->description=$request->edit_reward_desc[$key];
                $rdata->thai_description=$request->edit_thai_reward_desc[$key];
                $rdata->days=$request->edit_reward_day[$key];

                if($data->win_reward_type=="gift"){
                    $rdata->gift_id=$request->edit_rgift[$key];
                }else if($data->win_reward_type=="salmon" || $data->win_reward_type=="exp" || $data->win_reward_type=="baht"){
                    $rdata->points=$request->edit_reward_point[$key];
                }else if($data->win_reward_type=="frame"){
                    $rdata->frame_days=$request->edit_frame_days[$key];
                    $fimage = $request->file('edit_frame_image');
                    if($fimage!=null){
                        $fi=$fimage[$key];
                        if ($fi != null) {
                            $fnew_name =  rand() . '.' . $fi->getClientOriginalExtension();
                            $fi->move(storage_path('/app/public/uploads/event/frame'), $fnew_name);
                            $rdata->frame_file = $fnew_name;
                        }
                    }
                }
                $rdata->win_reward_type=$data->win_reward_type;

                $rdata->save();
            }
            return 1;
        }else{
            return 0;
        }
    }


    /**---------------------------------------------------
     *  change status
     *  @Created By : Rajesh Koladiya
     *  @Created At : 16-07-2021
     * ---------------------------------------------------
     */

    public function changeStatus(Request $request)
    {
        $data = new Event;
        $data->exists = true;
        $data->id = $request->id;
        if($request->status == 0){
            $data->status = "1";
        }else{
            $data->status = "0";
        }

        if($data->save()){
            if($request->status == 0){
                $event=Event::where('id',$request->id)->first();
                if($event!=""){
                    $userList = User::users()->orderBy('id', 'desc')->get();
                    
                    $title=$event->event_name." event";
                    $body=$event->event_name." event coming soon!";
                    $eventData=array('id'=>$event->id,'start_date'=>$event->start_date,'end_date'=>$event->end_date,'image'=>url('app/public/uploads/event'.'/'.$event->image)); 
                    BaseFunction::allSendNotification($userList,$title,$body,'event',$eventData);
                }
            }
            return 1;
        }else{
            return 0;
        }
    }

    /**---------------------------------------------------
     *  Delete Event
     *  @Created By : Rajesh Koladiya
     *  @Created At : 16-07-2021
     * ---------------------------------------------------
     */

    public function destroy(Request $request){
        $data=Event::where('id',$request->id)->first();
        if(\File::exists(storage_path('app/public/uploads/event'.'/'.$data->image))){
            \File::delete(storage_path('app/public/uploads/event'.'/'.$data->image));
        }
        $Event=Event::where('id', $request->id)->delete();
        if($Event){
            return 1;
        }else{
            return 0;
        }
    }

    //Event wise user data
    public function eventUserReport(Request $request)
    {
        $this->validate($request, [
            'event_id' => 'required',
        ]);
        $event=Event::where('id', $request->event_id)->first();
        return view('admin.event.eventUserList',compact('event'));
    }
    public function eventUserList(Request $request){
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        $members = EventParticipant::with(['user','event'])->leftjoin('users','users.id','=','event_participants.user_id')->leftjoin('events','events.id','=','event_participants.event_id')->where('events.id', $request->event_id);

        if ($search != "") {
            $members = $members->where(function ($q) use ($search) {
                $q->where('users.username', 'like', '%' . $search . '%')
                    ->orWhere('users.stream_id', 'like', '%' . $search . '%')
                    ->orWhere('event.win_reward_type', 'like', '%' . $search . '%')
                    ->orWhere('event_participants.event_counts', 'like', '%' . $search . '%');
            });
        }

        if (!isset($request->order)) {
            $members = $members->orderby('event_participants.event_counts', 'DESC');
        } else {
            $columns = $request->order[0]['column'];
            $order = $request->order[0]['dir'];
            $name_field = $request->columns[$columns]['data'];
            if ($name_field == 'date') {
                $name_field = 'event_participants.created_at';
            }
            if ($name_field == 'win_reward_type') {
                $name_field = 'event.win_reward_type';
            }
            if ($request->order[0]['column'] != 0 && $request->order[0]['column'] != 1) {
                $members = $members->orderby($name_field, $order);
            } else {
                $members = $members->orderby($name_field, $order);
            }
        }
        $members = $members->select('*');
        $members = $members->paginate($length, ['*'], 'page', $page);

        foreach ($members as $key => $value) {
            $winuser=EventWiner::where('user_id',$value->user->id)->where('event_id',$request->event_id)->first();
            if (!filter_var($value->user->profile_pic, FILTER_VALIDATE_URL)) {
                if (\File::exists(storage_path('app/public/uploads/users' . '/' . $value->user->profile_pic))) {
                    $value->user->username = '<span class="tabel-profile-img"><img src="' . url('storage/app/public/uploads/users/' . $value->user->profile_pic) . '" alt=""></span>' . $value->user->username.'<br/>'.strtolower($value->user->stream_id);
                } else {
                    $value->username = '<span class="tabel-profile-img"><img src="' . url('storage/app/public/uploads/users/default.png') . '" alt=""></span>' . $value->user->username .'<br/>'.strtolower($value->user->stream_id);
                }
            } else {
                $value->username = '<span class="tabel-profile-img"><img src="' . $value->user->profile_pic . '" alt=""></span>' . $value->user->username.'<br/>'.$value->user->stream_id;
            }
            $value->win_reward_type = $value->event->win_reward_type;
            $value->event_counts =$value->event_counts;
            $value->winner="";
            if($winuser !=null){
                $value->winner = $winuser->reward_point;
            }else{
                $value->winner="-";
            }
            $value->action="";
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


}
