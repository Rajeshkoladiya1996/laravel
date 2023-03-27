<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLoginLog;
use Auth;
use Hash;
use Session;
use Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Bangkok');
    }
    
    public function login(Request $request)
    {
    	if(Auth::user()){
    		return redirect()->route('admin');
    	}else{
    		return view('admin.auth.login');
    	}
    }

    public function doLogin(Request $request)
    {
	    $this->validate($request,[
	        'email' => 'required|email',
	        'password' => 'required|min:6|max:20',
	    ]);
	    
	    if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
	    {	
            if(Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('admin')){
                $this->loginLogs(Auth::user()->id,$request->ip(),'login','');
	    	    return redirect()->route('admin');
            }      
            Session::flash('error', 'Invalid user login'); 
            return redirect()->back()->withInput();
	    }
	    Session::flash('error', 'Oops! There was an error'); 
	    return redirect()->back()->withInput();
    }

    public function logout(Request $request)
    {
        $this->loginLogs(Auth::user()->id,$request->ip(),'logout','');
    	Auth::logout();
       	return redirect()->route('admin.login');
    }


    public function profile(Request $request)
    {

        $authdetail=User::where('id',Auth::user()->id)->first();
        return view('admin.auth.profile',compact('authdetail'));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'phone' => 'required',
        ]);

        $user= new User;
        $user->username=$request->name;
        $user->exists = true;
        $user->id = Auth::user()->id;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->bod=$request->bod;
        if(isset($request->images)){           
            $images = explode(";base64,", $request->images);
            if(isset($images[1])){
                $image_type_aux = explode("image/", $images[0]);
                $image_type = $image_type_aux[1];
                $safeName ="profile_".uniqid().'.'.$image_type;
                $destinationPath = storage_path('/app/public/uploads/users');
                $success = file_put_contents(storage_path('/app/public/uploads/users').'/'.$safeName, base64_decode($images[1]));
                
                $user->profile_pic=$safeName;
                if(Auth::user()->profile_pic!='default.png'){
                    if(\File::exists(storage_path('app/public/uploads/users'.'/'.Auth::user()->profile_pic))){
                        \File::delete(storage_path('app/public/uploads/users'.'/'.Auth::user()->profile_pic));
                        // \Storage::delete('/app/public/uploads/gift/'.'/'.$giftold->image);             
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


    public function changePassowrd(Request $request)
    {
       
        $this->validate($request, [            
            'old_password' => 'required|min:6|max:20',
            'new_password' => 'required|min:6|max:20',
            'confirm_password' => 'required|min:6|max:20'
        ]);


        if($request->old_password == $request->new_password){
           return response()->json('new password should not be same as old password');
        }

        if($request->confirm_password!=$request->new_password){
            return response()->json('Password and confim password does not match');
        }

        $userdata=User::findOrFail(Auth::user()->id);
        if(Hash::check($request->old_password,$userdata->password)){
            User::where('id',Auth::user()->id)->update(['password'=>Hash::make($request->new_password)]);
            return 1; 
        }else{
            return response()->json('The old password does not match our records.');
        }
    }

    public function loginLogs($user_id,$ip_address,$type,$device_type)
    {
        $userlog = new UserLoginLog;
        $userlog->user_id=$user_id;
        $userlog->ip_address=($ip_address!='')? $ip_address : '0.0.0.0';
        $userlog->type=$type;
        $userlog->date=date("Y-m-d h:i:s");
        $userlog->device_type=$device_type;
        $userlog->save();
    } 
}
