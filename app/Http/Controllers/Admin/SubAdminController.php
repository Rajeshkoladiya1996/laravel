<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\User;
use Auth;
use Hash;

class SubAdminController extends Controller
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
        if(Auth::user()->hasRole('admin')){
            return redirect()->route('admin');
        }
        $userList=User::subadmin()->orderBy('id','desc')->get();
        return view('admin.subadmin.index',compact('userList'));
    }

    public function list(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length =(int)$request->get('length');
        $page=($request->start/$length)+1;
        $search=$request->search['value'];

        $members =User::subadmin();
        if($search!=""){            
            $members =$members->where(function($q) use($search) {      
                $q->where('email', 'like', '%' .$search . '%')
                ->orWhere('username', 'like', '%' .$search . '%')
                ->orWhere('phone', 'like', '%' .$search . '%');
            });
        }
        if(!isset($request->order)){
            $members =$members->orderby('users.id','DESC');
        }else{
            $columns=$request->order[0]['column'];
            $order=$request->order[0]['dir'];
            $name_field=$request->columns[$columns]['data'];
            if($request->order[0]['column']!=0 && $request->order[0]['column']!=4){            
                $members =$members->orderby($name_field,$order);
            }
        }
        $members =$members->paginate($length, ['*'], 'page', $page);
        foreach ($members as $key => $value) {
            $photo=$value->profile_pic;
            $value->profile_pic='<div class="d-flex align-items-center">';
            if(!filter_var($photo, FILTER_VALIDATE_URL)){
                if(file_exists(storage_path('app/public/uploads/users/'.$photo))){
                    $value->profile_pic .='<span class="tabel-profile-img"><img src="'.url('storage/app/public/uploads/users/'.$photo).'" alt=""></span>';
                }else{
                    $value->profile_pic .='<span class="tabel-profile-img"><img src="'.url('storage/app/public/uploads/users/default.png').'" alt=""></span>';
                }
            }else{
                $value->profile_pic .='<span class="tabel-profile-img"><img src="'.$photo.'" alt=""></span>';
            }                      
            $value->profile_pic .='<p class="mb-0 ml-3">'.$value->username.'</p>';
            $value->profile_pic .='</div">';
            $value->email=strtolower($value->email);
            $value->actions='<ul class="action-wrap">';
            if(Auth::user()->hasRole('super-admin')){  
                $value->actions .='<li>
                      <a href="javascript:void(0)" class="reset_password" data-id="'.$value->id.'" id="reset_password" title="Reset Password">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 16 19">
                          <path id="Path_374" data-name="Path 374"
                            d="M5.667,7.333v-.9a5.334,5.334,0,1,1,10.667,0v.9h1.778a.9.9,0,0,1,.889.9V19.1a.9.9,0,0,1-.889.9H3.889A.9.9,0,0,1,3,19.1V8.238a.9.9,0,0,1,.889-.9Zm11.556,1.81H4.778V18.19H17.222Zm-7.111,5.186a1.823,1.823,0,0,1-.828-2.035,1.77,1.77,0,0,1,3.434,0,1.823,1.823,0,0,1-.828,2.035v2.052H10.111Zm-2.667-7h7.111v-.9a3.556,3.556,0,1,0-7.111,0Z"
                            transform="translate(-3 -1)" fill="#68aeff" />
                        </svg>
                      </a>
                    </li>'; 

                $value->actions .='<li>
                          <a href="javascript:void(0)" data-id="'.$value->id.'" id="editSubadmin" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16.473" height="16.473" viewBox="0 0 16.473 16.473">
                              <path id="Path_376" data-name="Path 376"
                                d="M14.667,9.131l-1.3-1.3L4.833,16.373v1.3h1.3l8.538-8.538Zm1.3-1.3,1.3-1.3-1.3-1.3-1.3,1.3ZM6.889,19.5H3V15.613L15.315,3.3a.917.917,0,0,1,1.3,0L19.2,5.891a.917.917,0,0,1,0,1.3L6.889,19.5Z"
                                transform="translate(-3 -3.029)" fill="#00b247" />
                            </svg>
                          </a>
                        </li>';
                $value->actions .='<li>
                            <a href="javascript:void(0)" id="deleteSubadmin" data-id="'.$value->id.'" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                  <path fill="none" d="M0 0h24v24H0z" />
                                  <path
                                    d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm-8 5v6h2v-6H9zm4 0v6h2v-6h-2zM9 4v2h6V4H9z"
                                    fill="rgba(255,0,0,1)" />
                                </svg>
                            </a>
                        </li>';
            
                      
            }
            $value->actions .='</ul>'; 
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'name'=>'required|min:2|regex:/^[a-zA-Z0-9 ]+$/u',
            'email'=>'required|email|unique:users,email',
            'phone'=>'required|unique:users,phone',
            'password'=>'required|max:12',
            'image'=>'mimes:jpeg,png,jpg',
        ]);
        $data['first_name']=$request->name;
        $data['username']=$request->name;
        $data['email']=$request->email;
        $data['phone']=$request->phone;
        $data['password']=Hash::make($request->password);
        if(isset($request->images)){           
            $images = explode(";base64,", $request->images);
            $image_type_aux = explode("image/", $images[0]);
            $image_type = $image_type_aux[1];
            $safeName ="profile_".uniqid().'.'.$image_type;
            $destinationPath = storage_path('/app/public/uploads/users');
            $success = file_put_contents(storage_path('/app/public/uploads/users').'/'.$safeName, base64_decode($images[1]));
            
            $data['profile_pic']=$safeName;
        }else{
            $data['profile_pic']='default.png';
        }
        $user=User::create($data)->assignRole(\Spatie\Permission\Models\Role::where('name','admin')->first());
        if($user){
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
        $data=User::where('id',$id)->first();
        return $data;
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
            'name'=>'required|min:2|regex:/^[a-zA-Z0-9 ]+$/u',
            'email'=>'required|email|unique:users,email,'.$request->id,
            'phone'=>'required|unique:users,phone,'.$request->id,
            'image'=>'mimes:jpeg,png,jpg',
        ]);
        $data=User::where('id',$request->id)->first();
        $user= new User;
        $user->exists = true;
        $user->id = $request->id;
        $user->first_name=$request->name;        
        $user->username=$request->name;
        $user->email=$request->email;
        $user->phone=$request->phone;
        if(isset($request->images)){           
            $images = explode(";base64,", $request->images);
            if(isset($images[1])){            
                $image_type_aux = explode("image/", $images[0]);
                $image_type = $image_type_aux[1];
                $safeName ="profile_".uniqid().'.'.$image_type;
                $destinationPath = storage_path('/app/public/uploads/users');
                $success = file_put_contents(storage_path('/app/public/uploads/users').'/'.$safeName, base64_decode($images[1]));                
                $user->profile_pic=$safeName;
                if($data->profile_pic!='default.png'){ 
                    if(\File::exists(storage_path('app/public/uploads/users'.'/'.$data->profile_pic))){
                        \File::delete(storage_path('app/public/uploads/users'.'/'.$data->profile_pic));             
                    }
                }
            }
        }
        
        if($user->save()){
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
        $data=User::where('id',$request->id)->first();
        if($data->profile_pic!='default.png'){    
            if(\File::exists(storage_path('app/public/uploads/users'.'/'.$data->profile_pic))){
                \File::delete(storage_path('app/public/uploads/users'.'/'.$data->profile_pic));             
            }
        }
        $user=\DB::table('model_has_roles')->where('model_id', $request->id)->delete();
        $user=User::where('id', $request->id)->delete();
        if($user){   
            return 1;
        }else{
            return 0;
        }
    }

    // changePassword 
    public function changePassword(Request $request)
    {
        $this->validate($request, [            
            'user_id' => 'required',
            'password' => 'required|min:6|max:12',
        ]);
        $data=User::where('id',$request->user_id)->update(['password'=>Hash::make($request->password)]);
        
        if($data){    

            return 1;
        }else{
            return 0;
        }
    }
}
