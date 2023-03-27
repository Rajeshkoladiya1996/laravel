<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Hash;
use Mail;
use Carbon\Carbon;
use App\Models\Gift;
use App\Models\User;
use App\Models\Config;
use App\Models\UserBlock;
use App\Models\UserRequest;
use App\Helper\BaseFunction;
use App\Models\UserFollower;
use App\Models\Tag;
use App\Models\UserTag;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\UserFavourite;
use App\Models\TopupRate;
use App\Models\UserWalletDetail;
use App\Models\UserSpendGemsDetail;
use App\Models\LiveStreamUser;
use App\Models\SpendGiftDetail;
use App\Http\Controllers\Controller;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $streamList = User::users()->withCount('follower', 'following', 'liveStream')->where('user_type', 1)->orderBy('id', 'desc')->get();
        $viewerList = User::users()->withCount('follower', 'following')->where('user_type', 0)->orderBy('id', 'desc')->get();
        $giftList = Gift::where('status', '1')->get();
        $cofigs =  Config::where('id', '1')->first();
        $users =  User::users()->get();
        return view('admin.user.index', compact('streamList', 'viewerList', 'giftList', 'cofigs','users'));
    }

    // streamList
    public function streamList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        $members = User::users()->withCount('follower', 'following', 'liveStream')->where('user_type', 1);
        if ($search != "") {
            $members = $members->where(function ($q) use ($search) {
                $q->where('email', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('stream_id', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('login_type', 'like', '%' . $search . '%')
                    ->orWhere('device_type', 'like', '%' . $search . '%')
                    ->orWhere('total_gems', 'like', '%' . $search . '%')
                    ->orWhere('earned_gems', 'like', '%' . $search . '%');
            });
        }
        if (!isset($request->order)) {
            $members = $members->orderby('users.id', 'DESC');
        } else {
            $columns = $request->order[0]['column'];
            $order = $request->order[0]['dir'];
            $name_field = $request->columns[$columns]['data'];
            if ($request->order[0]['column'] == 0){
                $members = $members->orderby('stream_id', $order);
                $members = $members->orderby('username', $order);
            }
            if($request->order[0]['column'] == 3){
                $members = $members->orderby('login_type', $order);
                $members = $members->orderby('device_type', $order);
            }
            if($request->order[0]['column'] == 8){
                $members = $members->orderby('created_at', $order);
            }
            if ($request->order[0]['column'] != 0 && $request->order[0]['column'] != 3 && $request->order[0]['column'] != 6 && $request->order[0]['column'] != 7 && $request->order[0]['column'] != 8) {
                $members = $members->orderby($name_field, $order);
            }
        }
        $members = $members->paginate($length, ['*'], 'page', $page);

        foreach ($members as $key => $value) {
            //live stream
            $live_stream=$value->live_stream_count;

            $login_types=$value->login_type;
            if($login_types=="email"){
                $value->login_type="phone";
            }

            $value->live_stream_count='<a href="javascript:void(0)" class="live-stream-model" id="live-stream-model" data-id="' . $value->id . '" data-type="streamer" title="Live stream count">
                      ' . $live_stream .'</a>';

            //followers 
            $count= $value->follower_count; 
            $value->follower_count='<a href="javascript:void(0)" class="followers-details-model" id="followers-details-model" data-id="' . $value->id . '" data-type="streamer" title="Followers details">
                      ' . $count .'</a>';
            //Gold coin
            $earned_gems_count=$value->earned_gems;
            $value->earned_gems='<a href="javascript:void(0)" class="earned_gems-details-model" id="earned_gems-details-model" data-id="' . $value->id . '" data-type="streamer" title="Gold coin details">
                      ' . $earned_gems_count .'</a>';

            if (!filter_var($value->profile_pic, FILTER_VALIDATE_URL)) {
                if (\File::exists(storage_path('app/public/uploads/users' . '/' . $value->profile_pic))) {
                    $value->profile_pic = '<span class="tabel-profile-img"><img src="' . url('storage/app/public/uploads/users/' . $value->profile_pic) . '" alt=""></span>' . $value->username . '<br/>' . strtolower($value->stream_id);
                } else {
                    $value->profile_pic = '<span class="tabel-profile-img"><img src="' . url('storage/app/public/uploads/users/default.png') . '" alt=""></span>' . $value->username . '<br/>' . strtolower($value->stream_id);
                }
            } else {
                $value->profile_pic = '<span class="tabel-profile-img"><img src="' . $value->profile_pic . '" alt=""></span>' . $value->username . '<br/>' . $value->stream_id;
            }
            $join_date = new Carbon($value->created_at);
            $join_date->timezone = env('APP_TIME_ZONE', 'Asia/Bangkok');
            $value->date =  date('d M, Y | h:i:s a', strtotime($join_date->toDayDateTimeString()));
            $value->total_gems = '<a href="javascript:void(0)" class="salmon-details-model" id="salmon-details-model" data-id="' . $value->id . '" data-type="streamer" title="Salmon coin details">
                      $' . $value->total_gems .'</a>';
            if ($value->device_type == 0) {
                $device_type = "Android";
            } else {
                $device_type = "iOS";
            }
            $value->login_types = '<span class="imgsModel" data-id="' . $value->id . '">' . $value->login_type . '</span> | ' . $device_type;
            // $value->created_at=date('d M, Y | H:i a', strtotime($value->created_at));
            $value->actions = '<ul class="action-wrap">';
            $value->actions .= '<li>
                      <a href="javascript:void(0)" class="assign-model" id="assign-model" data-id="' . $value->id . '" data-type="streamer" title="Gems Top-up">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                          <path fill="none" d="M0 0h24v24H0z"/>
                          <path fill="#d6b755"
                            d="M21 8v12.993A1 1 0 0 1 20.007 22H3.993A.993.993 0 0 1 3 21.008V2.992C3 2.455 3.449 2 4.002 2h10.995L21 8zm-2 1h-5V4H5v16h14V9zM8 7h3v2H8V7zm0 4h8v2H8v-2zm0 4h8v2H8v-2z" />
                        </svg>
                      </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="blocked-user-list-model" id="blocked-user-list-model" data-id="' . $value->id . '" data-type="streamer" title="View Blocked User List">
                            <svg height="20" viewBox="0 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg">
                                <path d="m512 511.992188h-512v-78.367188c0-26.914062 16.832031-50.945312 42.128906-60.144531l133.871094-48.6875v-31.457031l-48-64v-96.816407c0-68.113281 51.28125-127.679687 119.230469-132.222656 74.53125-5.007813 136.769531 54.222656 136.769531 127.695313v101.328124l-48 64v31.472657l133.871094 48.6875c25.296875 9.183593 42.128906 33.214843 42.128906 60.144531zm0 0" fill="#64ccf4"/><path d="m288 223.992188h-64v-96h32v64h32zm0 0" fill="#40a2e7"/><path d="m336 324.792969v-31.457031l48-64v-5.34375c-88.222656 0-160 71.777343-160 160 0 35.632812 11.96875 68.351562 31.761719 94.925781h-255.761719v33.074219h512v-123.199219zm0 0" fill="#43ade8"/><path d="m288 47.992188h32v32h-32zm0 0" fill="#fff"/><path d="m384 255.992188c-70.574219 0-128 57.421874-128 128 0 70.574218 57.425781 128 128 128s128-57.425782 128-128c0-70.578126-57.425781-128-128-128zm-96 128c0-52.945313 43.054688-96 96-96 20.671875 0 39.792969 6.640624 55.488281 17.792968l-133.679687 133.679688c-11.167969-15.679688-17.808594-34.800782-17.808594-55.472656zm96 96c-20.671875 0-39.792969-6.640626-55.488281-17.792969l133.679687-133.679688c11.167969 15.679688 17.808594 34.800781 17.808594 55.472657 0 52.945312-43.054688 96-96 96zm0 0" fill="#e76e54"/>
                            </svg>
                        </a>
                    </li>';
            if (Auth::user()->hasRole('super-admin')) {
                $value->actions .= '<li>
                          <a href="' . url('godmode/user/edit', $value->id) . '" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16.473" height="16.473" viewBox="0 0 16.473 16.473">
                              <path id="Path_376" data-name="Path 376"
                                d="M14.667,9.131l-1.3-1.3L4.833,16.373v1.3h1.3l8.538-8.538Zm1.3-1.3,1.3-1.3-1.3-1.3-1.3,1.3ZM6.889,19.5H3V15.613L15.315,3.3a.917.917,0,0,1,1.3,0L19.2,5.891a.917.917,0,0,1,0,1.3L6.889,19.5Z"
                                transform="translate(-3 -3.029)" fill="#00b247" />
                            </svg>
                          </a>
                        </li>';
                $value->actions .= '<li>
                            <a href="javascript:void(0)" data-toggle="modal" id="userBlockUnblock" data-id="' . $value->id . '" data-status="' . $value->is_active . '" title="Block User">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19">
                                <g id="Group_101" data-name="Group 101" transform="translate(-1841 -242)">
                                <g id="Ellipse_22" data-name="Ellipse 22" transform="translate(1841 242)" fill="none"
                                    stroke="#ff1a1a" stroke-width="2">
                                    <circle cx="9.5" cy="9.5" r="9.5" stroke="none" />
                                    <circle cx="9.5" cy="9.5" r="8.5" fill="none" />
                                </g>
                                <path id="Path_377" data-name="Path 377" d="M3807.308,222.913l-11.119,11.119"
                                    transform="translate(-1951 23)" fill="none" stroke="#ff1a1a" stroke-width="2" />
                                </g>
                            </svg>
                            </a>
                        </li>';

                // if($value->login_type=="email"){
                //     $value->actions .='<li>
                //           <a href="javascript:void(0)" class="reset_password" data-id="'.$value->id.'" id="reset_password" title="Reset Password">
                //             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 16 19">
                //               <path id="Path_374" data-name="Path 374"
                //                 d="M5.667,7.333v-.9a5.334,5.334,0,1,1,10.667,0v.9h1.778a.9.9,0,0,1,.889.9V19.1a.9.9,0,0,1-.889.9H3.889A.9.9,0,0,1,3,19.1V8.238a.9.9,0,0,1,.889-.9Zm11.556,1.81H4.778V18.19H17.222Zm-7.111,5.186a1.823,1.823,0,0,1-.828-2.035,1.77,1.77,0,0,1,3.434,0,1.823,1.823,0,0,1-.828,2.035v2.052H10.111Zm-2.667-7h7.111v-.9a3.556,3.556,0,1,0-7.111,0Z"
                //                 transform="translate(-3 -1)" fill="#68aeff" />
                //             </svg>
                //           </a>
                //         </li>';
                // }else{
                //     $value->actions .="<li></li>";
                // }        
            }
            $value->actions .= '</ul>';
            $value->is_active = ($value->is_active == '1') ? '<span class="green">Active</span>' : '<span class="red">De-active</span>';
            if($value->recommended==0){
                $value->recommended='<span class="green recommended-status" data-status='.$value->recommended.' data-id='.$value->id.'>Recommended</span>';
            }else if($value->recommended==1){
                $value->recommended='<span class="green recommended-status" data-status='.$value->recommended.' data-id='.$value->id.'>Popular</span>';
            }else if($value->recommended==2){
                $value->recommended='<span class="green recommended-status" data-status='.$value->recommended.' data-id='.$value->id.'>Hot</span>';
            }else{
                $value->recommended='<span class="green recommended-status" data-status='.$value->recommended.' data-id='.$value->id.'>None</span>';
            };
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

    // changeRecommended
    public function changeRecommended(Request $request)
    {
        $data = User::find($request->id);
        $data->recommended =$request->user;
        
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    }

    // viewerList
    public function viewerList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        $members = User::users()->withCount('follower', 'following');
        if ($search != "") {
            $members = $members->where(function ($q) use ($search) {
                $q->where('email', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('stream_id', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('login_type', 'like', '%' . $search . '%')
                    ->orWhere('device_type', 'like', '%' . $search . '%')
                    ->orWhere('total_gems', 'like', '%' . $search . '%')
                    ->orWhere('earned_gems', 'like', '%' . $search . '%');
            });
        }
        $members = $members->where('user_type', 0);
        if (!isset($request->order)) {
            $members = $members->orderby('users.id', 'DESC');
        } else {
            $columns = $request->order[0]['column'];
            $order = $request->order[0]['dir'];
            $name_field = $request->columns[$columns]['data'];
            if ($request->order[0]['column'] == 0){
                $members = $members->orderby('stream_id', $order);
                $members = $members->orderby('username', $order);
            }
            if($request->order[0]['column'] == 3){
                $members = $members->orderby('login_type', $order);
                $members = $members->orderby('device_type', $order);
            }
            if($request->order[0]['column'] == 7){
                $members = $members->orderby('created_at', $order);
            }
            if ($request->order[0]['column'] != 0 && $request->order[0]['column'] != 3 && $request->order[0]['column'] != 6 && $request->order[0]['column'] != 7 ) {
                $members = $members->orderby($name_field, $order);
            }
        }
        $members = $members->paginate($length, ['*'], 'page', $page);

        foreach ($members as $key => $value) {
            $count= $value->follower_count; 
            $login_types=$value->login_type;
            if($login_types=="email"){
                $value->login_type="phone";
            }
            $value->follower_count='<a href="javascript:void(0)" class="followers-details-model" id="followers-details-model" data-id="' . $value->id . '" data-type="streamer" title="Followers details">
                      ' . $count .'</a>';
            if (!filter_var($value->profile_pic, FILTER_VALIDATE_URL)) {
                if (\File::exists(storage_path('app/public/uploads/users' . '/' . $value->profile_pic))) {
                    $value->profile_pic = '<span class="tabel-profile-img"><img src="' . url('storage/app/public/uploads/users/' . $value->profile_pic) . '" alt=""></span>' . $value->username . '<br/>' . strtolower($value->stream_id);
                } else {
                    $value->profile_pic = '<span class="tabel-profile-img"><img src="' . url('storage/app/public/uploads/users/default.png') . '" alt=""></span>' . $value->username . $value->username . '<br/>' . strtolower($value->stream_id);
                }
            } else {
                $value->profile_pic = '<span class="tabel-profile-img"><img src="' . $value->profile_pic . '" alt=""></span>' . $value->username . '<br/>' . $value->stream_id;
            }
            $join_date = new Carbon($value->created_at);
            $join_date->timezone = env('APP_TIME_ZONE', 'Asia/Bangkok');
            $value->date =  date('d M, Y | h:i:s a', strtotime($join_date->toDayDateTimeString()));
            
            $value->total_gems = '<a href="javascript:void(0)" class="salmon-details-model" id="salmon-details-model" data-id="' . $value->id . '" data-type="streamer" title="Salmon coin details">
                      $' . $value->total_gems .'</a>';
            if ($value->device_type == 0) {
                $device_type = "Android";
            } else {
                $device_type = "iOS";
            }
            $value->login_types = '<span class="imgsModel" data-id="' . $value->id . '">' . $value->login_type . '</span> | ' . $device_type;
            $value->actions = '<ul class="action-wrap">';
            $value->actions .= '<li>
                      <a href="javascript:void(0)" class="assign-model" id="assign-model" data-id="' . $value->id . '" data-type="streamer" title="Gems Top-up">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                          <path fill="none" d="M0 0h24v24H0z" />
                          <path fill="#d6b755"
                            d="M21 8v12.993A1 1 0 0 1 20.007 22H3.993A.993.993 0 0 1 3 21.008V2.992C3 2.455 3.449 2 4.002 2h10.995L21 8zm-2 1h-5V4H5v16h14V9zM8 7h3v2H8V7zm0 4h8v2H8v-2zm0 4h8v2H8v-2z" />
                        </svg>
                      </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="blocked-user-list-model" id="blocked-user-list-model" data-id="' . $value->id . '" data-type="streamer" title="View Blocked User List">
                            <svg height="20" viewBox="0 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg">
                                <path d="m512 511.992188h-512v-78.367188c0-26.914062 16.832031-50.945312 42.128906-60.144531l133.871094-48.6875v-31.457031l-48-64v-96.816407c0-68.113281 51.28125-127.679687 119.230469-132.222656 74.53125-5.007813 136.769531 54.222656 136.769531 127.695313v101.328124l-48 64v31.472657l133.871094 48.6875c25.296875 9.183593 42.128906 33.214843 42.128906 60.144531zm0 0" fill="#64ccf4"/><path d="m288 223.992188h-64v-96h32v64h32zm0 0" fill="#40a2e7"/><path d="m336 324.792969v-31.457031l48-64v-5.34375c-88.222656 0-160 71.777343-160 160 0 35.632812 11.96875 68.351562 31.761719 94.925781h-255.761719v33.074219h512v-123.199219zm0 0" fill="#43ade8"/><path d="m288 47.992188h32v32h-32zm0 0" fill="#fff"/><path d="m384 255.992188c-70.574219 0-128 57.421874-128 128 0 70.574218 57.425781 128 128 128s128-57.425782 128-128c0-70.578126-57.425781-128-128-128zm-96 128c0-52.945313 43.054688-96 96-96 20.671875 0 39.792969 6.640624 55.488281 17.792968l-133.679687 133.679688c-11.167969-15.679688-17.808594-34.800782-17.808594-55.472656zm96 96c-20.671875 0-39.792969-6.640626-55.488281-17.792969l133.679687-133.679688c11.167969 15.679688 17.808594 34.800781 17.808594 55.472657 0 52.945312-43.054688 96-96 96zm0 0" fill="#e76e54"/>
                            </svg>
                        </a>
                    </li>';

            if (Auth::user()->hasRole('super-admin')) {

                $value->actions .= '<li>
                          <a href="' . url('godmode/user/edit', $value->id) . '" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16.473" height="16.473" viewBox="0 0 16.473 16.473">
                              <path id="Path_376" data-name="Path 376"
                                d="M14.667,9.131l-1.3-1.3L4.833,16.373v1.3h1.3l8.538-8.538Zm1.3-1.3,1.3-1.3-1.3-1.3-1.3,1.3ZM6.889,19.5H3V15.613L15.315,3.3a.917.917,0,0,1,1.3,0L19.2,5.891a.917.917,0,0,1,0,1.3L6.889,19.5Z"
                                transform="translate(-3 -3.029)" fill="#00b247" />
                            </svg>
                          </a>
                        </li>';
                $value->actions .= '<li>
                            <a href="javascript:void(0)" data-toggle="modal" id="userBlockUnblock" data-id="' . $value->id . '" data-status="' . $value->is_active . '" title="Block User">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19">
                                <g id="Group_101" data-name="Group 101" transform="translate(-1841 -242)">
                                <g id="Ellipse_22" data-name="Ellipse 22" transform="translate(1841 242)" fill="none"
                                    stroke="#ff1a1a" stroke-width="2">
                                    <circle cx="9.5" cy="9.5" r="9.5" stroke="none" />
                                    <circle cx="9.5" cy="9.5" r="8.5" fill="none" />
                                </g>
                                <path id="Path_377" data-name="Path 377" d="M3807.308,222.913l-11.119,11.119"
                                    transform="translate(-1951 23)" fill="none" stroke="#ff1a1a" stroke-width="2" />
                                </g>
                            </svg>
                            </a>
                        </li>';
                // if($value->login_type=="email"){            
                //     $value->actions .='<li>
                //               <a href="javascript:void(0)" class="reset_password" data-id="'.$value->id.'" id="reset_password" title="Reset Password">
                //                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 16 19">
                //                   <path id="Path_374" data-name="Path 374"
                //                     d="M5.667,7.333v-.9a5.334,5.334,0,1,1,10.667,0v.9h1.778a.9.9,0,0,1,.889.9V19.1a.9.9,0,0,1-.889.9H3.889A.9.9,0,0,1,3,19.1V8.238a.9.9,0,0,1,.889-.9Zm11.556,1.81H4.778V18.19H17.222Zm-7.111,5.186a1.823,1.823,0,0,1-.828-2.035,1.77,1.77,0,0,1,3.434,0,1.823,1.823,0,0,1-.828,2.035v2.052H10.111Zm-2.667-7h7.111v-.9a3.556,3.556,0,1,0-7.111,0Z"
                //                     transform="translate(-3 -1)" fill="#68aeff" />
                //                 </svg>
                //               </a>
                //             </li>';
                // }else{
                //     $value->actions .="<li></li>";
                // }        
            }
            $value->actions .= '</ul>';
            $value->is_active = ($value->is_active == '1') ? '<span class="green">Active</span>' : '<span class="red">De-active</span>';
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
        $userDetail = User::where('id', $id)->first();
        $tags = Tag::orderBy('name', 'ASC')->get();
        $userTag = UserTag::where('user_id', $id)->get();
        $userProfile=UserProfile::where('user_id',$id)->get();
        return view('admin.user.editProfile', compact('userDetail', 'tags', 'userTag','userProfile'));
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
        $this->validate($request, [
            'username' => 'min:2|unique:users,username,' . $request->id,
        ]);

        if ($request->email != "") {
            $this->validate($request, [
                'email' => 'email|unique:users,email,' . $request->id,
            ]);
        }

        if($request->phone!=null){
            $this->validate($request, [
                'phone' => 'unique:users,phone,' . $request->id,
            ]); 
        }

        $data = User::where('id', $request->id)->first();
        $user = new User;
        $user->exists = true;
        $user->id = $request->id;
        if($request->username!=null){
            $user->username = $request->username;
        }
        if($request->email!=null){
            $user->email = $request->email;
        }

        if($request->phone!=null){
            $user->phone = $request->phone;
        }
        $user->gender = $request->gender;
        $user->city = $request->city;

        // UserTag
        $tagU = UserTag::where('user_id', $request->id)->get();
        if($request->tags!=null){
            $count=UserTag::where('user_id', $request->id)->get();
            if($count!=null){
                $delete=UserTag::where('user_id', $request->id)->delete();
            }
            
            foreach($request->tags as $key){
                $tagUser=new UserTag;
                $tagUser->user_id=$request->id;
                $tagUser->tag_id=$key;
                $tagUser->save();
            }
        } 

        if (isset($request->images)) {
            $images = explode(";base64,", $request->images);
            if (isset($images[1])) {
                $image_type_aux = explode("image/", $images[0]);
                $image_type = $image_type_aux[1];
                $safeName = "profile_" . uniqid() . '.' . $image_type;
                $destinationPath = storage_path('/app/public/uploads/users');
                $success = file_put_contents(storage_path('/app/public/uploads/users') . '/' . $safeName, base64_decode($images[1]));
                $user->profile_pic = $safeName;
                if ($data->profile_pic != 'default.png') {
                    if (\File::exists(storage_path('app/public/uploads/users' . '/' . $data->profile_pic))) {
                        \File::delete(storage_path('app/public/uploads/users' . '/' . $data->profile_pic));
                    }
                }
            }
        }
        if ($user->save()) {
            return 1;
        } else {
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
        $data = User::where('id', $request->id)->first();
        if ($data->profile_pic != 'default.png') {
            if (\File::exists(storage_path('app/public/uploads/users' . '/' . $data->profile_pic))) {
                \File::delete(storage_path('app/public/uploads/users' . '/' . $data->profile_pic));
            }
        }
        $user = \DB::table('model_has_roles')->where('model_id', $request->id)->delete();
        $user = User::where('id', $request->id)->delete();
        if ($user) {
            return 1;
        } else {
            return 0;
        }
    }

    /*
    *Change User Password.
    */
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'password' => 'required|min:6|max:12',
        ]);
        $data = User::where('id', $request->user_id)->update(['password' => Hash::make($request->password)]);
        if ($data) {
            return 1;
        } else {
            return 0;
        }
    }


    public function blockUserByAdmin(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'status' => 'required'
        ]);

        $userData = new User;
        $userData->exists = true;
        $userData->id = $request->user_id;

        if ($request->status == '1') {
            $userData->is_active = '0';
        } else {
            $userData->is_active = '1';
        }
        if ($userData->save()) {
            return 1;
        } else {
            return 0;
        }
    }

    public function assignDiamond(Request $request)
    {

        $this->validate($request, [
            'diamond' => 'required',
            'amount' => 'required',
            'rate' => 'required',
            'user_id' => 'required'
        ]);

        // if ($request->diamond == 0 || $request->amount == 0) {
        //     return 2;
        // }

        $userwalletdetail = new UserWalletDetail;
        $userwalletdetail->user_id = $request->user_id;
        $userwalletdetail->amount = $request->amount;
        $userwalletdetail->diamond_amount = $request->rate;
        $userwalletdetail->gems_amount = $request->diamond;
        $userwalletdetail->create_by = Auth::user()->id;
        if ($userwalletdetail->save()) {

            $userData = User::where('id', $request->user_id)->first();
            $data['total_gems'] = $userData->total_gems + $request->diamond;
            User::where('id', $request->user_id)->update($data);

            //send notification
            BaseFunction::sendNotification($userData, 'Salmon coin assign', $request->diamond . ' Salmon coin assign Successfully');

            return 1;
        } else {
            return 0;
        }
    }

    // blockedUserList
    public function blockedUserList(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
        ]);
        $blockUser = UserBlock::with(['user'])->where('from_id', $request->user_id)->get();
        return $blockUser;
    }
    
    //spendCoinUser
    public function spendCoinUser(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
        ]);

        $user=User::where('id',$request->user_id)->first();
        return view('admin.user.spendCoinUserList',compact('user'));
    }

    public function spendCoinUserList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($start_date !='' && $end_date!=''){
            // $members = SpendGiftDetail::with('userspendgemsdetail','gift_details')->whereHas('userspendgemsdetail',function($q) use($request){
            //     return $q->with('boradcaster')->where('from_id',$request->user_id);
            // })->where('created_at', '>=',$start_date)->where('created_at','<=',$end_date);
            $members= SpendGiftDetail::with('userspendgemsdetail','gift_details')->whereHas('userspendgemsdetail',function($q) use($request){
                return $q->with('boradcaster')->where('from_id',$request->user_id);
            })->leftjoin('gifts', 'spend_gift_details.gift_id', '=', 'gifts.id')->leftjoin('gift_categories','gift_categories.id','=','gifts.gift_category_id')->leftjoin('user_spend_gems_details','user_spend_gems_details.id','=','spend_gift_details.spend_id')->leftjoin('users','users.id','=','user_spend_gems_details.to_id')->where('spend_gift_details.created_at', '>=',$start_date)->where('spend_gift_details.created_at','<=',$end_date);
        }else{
            // $members = SpendGiftDetail::with('userspendgemsdetail','gift_details')->whereHas('userspendgemsdetail',function($q) use($request){
            //     return $q->with('boradcaster')->where('from_id',$request->user_id);
            // });
            $members= SpendGiftDetail::with('userspendgemsdetail','gift_details')->whereHas('userspendgemsdetail',function($q) use($request){
                return $q->with('boradcaster')->where('from_id',$request->user_id);
            })->leftjoin('gifts', 'spend_gift_details.gift_id', '=', 'gifts.id')->leftjoin('gift_categories','gift_categories.id','=','gifts.gift_category_id')->leftjoin('user_spend_gems_details','user_spend_gems_details.id','=','spend_gift_details.spend_id')->leftjoin('users','users.id','=','user_spend_gems_details.to_id');
        }
        if ($search != "") {
            $members = $members->where(function ($q) use ($search) {
                $q->where('users.username', 'like', '%' . $search . '%')
                    ->orWhere('gifts.name', 'like', '%' . $search . '%')
                    ->orWhere('gift_categories.name', 'like', '%' . $search . '%')
                    ->orWhere('spend_gift_details.gems', 'like', '%' . $search . '%')
                    ->orWhere('spend_gift_details.created_at', 'like', '%' . $search . '%')
                    ->orWhere('users.stream_id', 'like','%'.$search.'%');
            });
        }
        if (!isset($request->order)) {
            $members = $members->orderby('spend_gift_details.created_at', 'DESC');
        } else {
            $columns = $request->order[0]['column'];
            $order = $request->order[0]['dir'];
            $name_field = $request->columns[$columns]['data'];
            if ($name_field == 'date') {
                $name_field = 'spend_gift_details.created_at';
            }
            if($name_field=='giftname'){
                $name_field = 'gifts.name';
            }
            if($name_field=='giftCategoryName'){
                $name_field = 'gift_categories.name';
            }
            if($name_field=='giftCategoryName'){
                $name_field = 'gift_categories.name';
            }
            if($name_field=='username'){
                $name_field = 'users.username';
            }
            if ($request->order[0]['column'] != 0 && $request->order[0]['column'] != 1) {
                $members = $members->orderby($name_field, $order);
            } else {
                $members = $members->orderby($name_field, $order);
            }
        }
        $members = $members->select('spend_gift_details.*');
        $members = $members->paginate($length, ['*'], 'page', $page);

        foreach ($members as $key => $value) {
            $value->username = '<div class="d-flex nowrap">
                <p class="ml-2 mb-0">' . $value->userspendgemsdetail->boradcaster->username . '<br/>'.strtolower($value->userspendgemsdetail->boradcaster->stream_id).'</p>
            </div>';
            $value->giftname = $value->gift_details->name;
            $value->giftCategoryName = $value->gift_details->gift_category->name;
            $value->gems = $value->gems ;
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

    // followers User Report
    public function followersUserReport(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
        ]);
        $user=User::where('id',$request->user_id)->first();
        return view('admin.user.followersReport',compact('user'));
    }

    public function followersUserReportList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($start_date !='' && $end_date!=''){
            // $members = UserFollower::with(['followinguser'])->where('from_id', $request->user_id)->where('created_at', '>=',$start_date)->where('created_at','<=',$end_date);
            $members = UserFollower::with(['followinguser'])->leftjoin('users','users.id','=','user_followers.to_id')->where('user_followers.from_id', $request->user_id)->where('user_followers.created_at', '>=',$start_date)->where('user_followers.created_at','<=',$end_date);
        }else{
            // $members = UserFollower::with(['followinguser'])->where('from_id', $request->user_id);
            $members = UserFollower::with(['followinguser'])->leftjoin('users','users.id','=','user_followers.to_id')->where('user_followers.from_id', $request->user_id);
        }
        if ($search != "") {
            $members = $members->where(function ($q) use ($search) {
                $q->where('users.username', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%')
                    ->orWhere('users.stream_id', 'like', '%' . $search . '%')
                    ->orWhere('users.phone', 'like', '%' . $search . '%');
            });
        }
        if (!isset($request->order)) {
            $members = $members->orderby('user_followers.created_at', 'DESC');
        } else {
            $columns = $request->order[0]['column'];
            $order = $request->order[0]['dir'];
            $name_field = $request->columns[$columns]['data'];
            if ($name_field == 'date') {
                $name_field = 'user_followers.created_at';
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
            if (!filter_var($value->followinguser->profile_pic, FILTER_VALIDATE_URL)){
                if (\File::exists(storage_path('app/public/uploads/users/$value->followinguser->profile_pic'))){
                    $value->username=`<span class="tabel-profile-img">
                        <img src="{{asset('storage/app/public/uploads/users/'.$value->followinguser->profile_pic)}}" alt="">
                    </span>`.$value->followinguser->username!='' ? $value->followinguser->username : '-' ;
                }else{
                    $value->username=`<span class="tabel-profile-img">
                        <img src="asset('storage/app/public/uploads/users/default.png')" alt="">
                    </span>`.$value->followinguser->username!='' ? $value->followinguser->username : '-' ;
                }
            }else{
                $value->username=`<span class="tabel-profile-img">
                    <img src="{{$value->followinguser->profile_pic}}" alt="">
                </span>`.$value->followinguser->username!='' ? $value->followinguser->username : '-';
            }
            $value->email = $value->followinguser->email;
            $value->stream_id = $value->followinguser->stream_id;
            $value->phone =$value->followinguser->phone!=null ? $value->followinguser->phone : '-' ;
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

    // live Stream Report
    public function liveStreamReport(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
        ]);
        $liveStreamUser = LiveStreamUser::with(['user'])->where('user_id', $request->user_id)->get();
        $users=User::where('id', $request->user_id)->first();
        $diff_in_days = LiveStreamUser::where('user_id',$request->user_id)->select(\DB::raw('DATE(created_at) as date'))->groupBy('date')->get();
        $diff_in_days=count($diff_in_days);
        $total_time=0;
        foreach ($liveStreamUser as $key => $data) {
            $interval = Carbon::parse($data->updated_at)->timestamp - Carbon::parse($data->created_at)->timestamp;
            $total_time = $total_time + $interval;
        }
        $total_time=gmdate('H:i:s',$total_time);
        return view('admin.user.liveStreamUserReport',compact('diff_in_days','total_time','users'));
    }

    public function liveStreamReportList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($start_date !='' && $end_date!=''){
            // $members = LiveStreamUser::with(['user'])->where('user_id', $request->user_id)->where('created_at', '>=',$start_date)->where('created_at','<=',$end_date);
            $members = LiveStreamUser::with(['user'])->where('live_stream_users.user_id', $request->user_id)->where('live_stream_users.created_at', '>=',$start_date)->where('live_stream_users.created_at','<=',$end_date);
        }else{
            // $members = LiveStreamUser::with(['user'])->where('user_id', $request->user_id);
            $members = LiveStreamUser::with(['user'])->where('live_stream_users.user_id', $request->user_id);
        }
        if ($search != "") {
            $members = $members->where(function ($q) use ($search) {
                $q->where('live_stream_users.created_at', 'like', '%' . $search . '%');
            });
        }
        if (!isset($request->order)) {
            $members = $members->orderby('live_stream_users.created_at', 'DESC');
        } else {
            $columns = $request->order[0]['column'];
            $order = $request->order[0]['dir'];
            $name_field = $request->columns[$columns]['data'];
            if ($name_field == 'date') {
                $name_field = 'live_stream_users.created_at';
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
            $start_date_bankock = Carbon::createFromTimestamp(strtotime($value->created_at))->timezone('Asia/Bangkok');
            $end_date_bankock = Carbon::createFromTimestamp(strtotime($value->updated_at))->timezone('Asia/Bangkok');
            $interval = date_diff($value->updated_at,$value->created_at);

            $date=$value->created_at;
            $value->date = $date->format('d-m-Y');
            $value->startTime = date('H:i:s',strtotime($start_date_bankock->toDayDateTimeString()));
            $value->endTime =date('H:i:s',strtotime($end_date_bankock->toDayDateTimeString()));
            $value->duration=$interval->format('%H:%I:%S');
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

    // check Rate
    public function checkRate(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
        ]);

        $topuprate = TopupRate::where('from_price', '<=', intval($request->amount))->where('to_price', '>=', intval($request->amount))->first();
        $salmoncoin['coin'] = 0;
        $salmoncoin['rate'] = 0;
        if ($topuprate) {
            $salmoncoin['rate'] = $topuprate->rate;
            $salmoncoin['coin'] = $request->amount * $topuprate->rate;
        }
        return $salmoncoin;
    }

    // multiple  profileList
    public function profileList(Request $request)
    {
        try {
            if ($profiles = UserProfile::where('user_id', $request->id)->get()) {
                $imgs = [];
                foreach ($profiles as $profile) {
                    $imgs[] = $profile->image;
                }
                return response()->json(['responseCode' => 1, 'data' => $imgs]);
            }
            return response()->json(['responseCode' => 0, 'data' => 'No data found']);
        } catch (Exception $ex) {
            return response()->json(['responseCode' => 0, 'data' => 'Something went wrong!']);
        }
    }

    // gold Coin Report
   public function goldCoinReport(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
        ]);
        $goldCoinUser=SpendGiftDetail::with('userspendgemsdetail','gift_details')->whereHas('userspendgemsdetail',function($q) use($request){
            return $q->with('boradcaster')->where('to_id',$request->user_id);
        });
        $user=User::where('id',$request->user_id)->first();
        $totalGoldCoin=0;
        foreach($goldCoinUser as $key => $value){
            $totalGoldCoin+=$value->gems;
        }
        return view('admin.user.goldCoinList',compact('user','totalGoldCoin'));
    }

    public function goldCoinReportList(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        if($start_date !='' && $end_date!=''){
            // $members=SpendGiftDetail::with('userspendgemsdetail','gift_details')->whereHas('userspendgemsdetail',function($q) use($request,$start_date,$end_date){
            //     return $q->with('boradcaster')->where('to_id',$request->user_id);
            // })->where('created_at', '>=',$start_date)->where('created_at','<=',$end_date);
            $members= SpendGiftDetail::with('userspendgemsdetail','gift_details')->whereHas('userspendgemsdetail',function($q) use($request){
                return $q->with('boradcaster')->where('to_id',$request->user_id);
            })->leftjoin('gifts', 'spend_gift_details.gift_id', '=', 'gifts.id')->leftjoin('gift_categories','gift_categories.id','=','gifts.gift_category_id')->leftjoin('user_spend_gems_details','user_spend_gems_details.id','=','spend_gift_details.spend_id')->leftjoin('users','users.id','=','user_spend_gems_details.to_id')->where('spend_gift_details.created_at', '>=',$start_date)->where('spend_gift_details.created_at','<=',$end_date);
        }else{
            // $members=SpendGiftDetail::with('userspendgemsdetail','gift_details')->whereHas('userspendgemsdetail',function($q) use($request){
            //     return $q->with('boradcaster')->where('to_id',$request->user_id);
            // });
            $members= SpendGiftDetail::with('userspendgemsdetail','gift_details')->whereHas('userspendgemsdetail',function($q) use($request){
                return $q->with('boradcaster')->where('to_id',$request->user_id);
            })->leftjoin('gifts', 'spend_gift_details.gift_id', '=', 'gifts.id')->leftjoin('gift_categories','gift_categories.id','=','gifts.gift_category_id')->leftjoin('user_spend_gems_details','user_spend_gems_details.id','=','spend_gift_details.spend_id')->leftjoin('users','users.id','=','user_spend_gems_details.to_id');
        }
        if ($search != "") {
            $members = $members->where(function ($q) use ($search) {
                $q->where('users.username', 'like', '%' . $search . '%')
                    ->orWhere('gifts.name', 'like', '%' . $search . '%')
                    ->orWhere('gift_categories.name', 'like', '%' . $search . '%')
                    ->orWhere('spend_gift_details.gems', 'like', '%' . $search . '%')
                    ->orWhere('spend_gift_details.created_at', 'like', '%' . $search . '%')
                    ->orWhere('users.stream_id', 'like','%'.$search.'%');
            });
        }
        if (!isset($request->order)) {
            $members = $members->orderby('spend_gift_details.created_at', 'DESC');
        } else {
            $columns = $request->order[0]['column'];
            $order = $request->order[0]['dir'];
            $name_field = $request->columns[$columns]['data'];

            if ($name_field == 'date') {
                $name_field = 'spend_gift_details.created_at';
            }
            if($name_field=='giftname'){
                $name_field = 'gifts.name';
            }
            if($name_field=='giftCategoryName'){
                $name_field = 'gift_categories.name';
            }
            if($name_field=='giftCategoryName'){
                $name_field = 'gift_categories.name';
            }
            if($name_field=='username'){
                $name_field = 'users.username';
            }
            if($name_field=='gems'){
                $name_field = 'spend_gift_details.gems';
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
            $value->username = '<div class="d-flex nowrap">
                <p class="ml-2 mb-0">' . $value->userspendgemsdetail->user->username . '<br/>'.strtolower($value->userspendgemsdetail->user->stream_id).'</p>
            </div>';
            $value->giftname = $value->gift_details->name;
            $value->giftCategoryName = $value->gift_details->gift_category->name;
            $value->gems = $value->gems ;
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

    // transfer Gold Coin
    public function transferGoldCoin(Request $request){
        $this->validate($request,[
            'from_userid'=>'required',
            'to_userid'=>'required'
        ]);
        $fromdata = User::find($request->from_userid);
        $todata = User::find($request->to_userid);
        $goldCoin=$fromdata->earned_gems;
        $fromdata->earned_gems = 0;
        $toGold=$todata->earned_gems;
        if($goldCoin>0){
            $todata->earned_gems = $toGold + $goldCoin;
        }
        if($fromdata->save()){
            $todata->save();
            return 1;
        }else{
            return 0;
        }
    }
}

