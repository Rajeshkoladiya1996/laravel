<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAvatarAttribute;
use App\Models\UserAvatarCart;
use App\Models\AvtarComponent;
use App\Models\AvtarCategory;
use App\Models\AvtarType;
use App\Models\UserAvatar;
use App\Models\User;


class AvtarController extends Controller
{
    public function index($slug,Request $request){
        $svg = AvtarType::where('slug',$slug)->first();
        // $category=AvtarCategory::whereHas('avtarcomponent', function ($query) use ($svg) {
        //             $query->where('avtartype_id',$svg->id);
        //         });
       
        $category = AvtarCategory::with(['avtarcomponent' => function ($query) use ($svg) {
            $query->where('avtartype_id', $svg->id)->orderBy('id','desc');
        }])->get();

        $user = 0;
        $user_cart=array();
        $user_buy=array();
        if ($request->has('user_id')) {
            $user = User::where('id','=',$request->input('user_id'))->first();
            $user_cart=UserAvatarCart::where('user_id',$request->input('user_id'))->get();
            $user_buy=UserAvatarAttribute::where('user_id',$request->input('user_id'))->get();
        }
        foreach($category as $cdata){        
            foreach($cdata->avtarcomponent as $value){
                $value->is_cart=0;
                if($user_cart!=""){
                    foreach($user_cart as $vdata){
                        if($value->id==$vdata->avatar_component_id){
                            $value->is_cart=1;
                        }
                    }
                }
                
                $value->is_buy=0;
                if($user_buy != ""){
                    foreach($user_buy as $bdata){
                        if($value->id==$bdata->avatar_component_id){
                            $value->is_buy=1;
                        }
                    }
                }
            }
        }
        
        
        return view('admin.avtar.view',compact('svg','category','user'));

    }

    public function clipBoard($slug,Request $request){
        $svg = AvtarType::where('slug',$slug)->first();
        $category = AvtarCategory::with(['avtarcomponent' => function ($query) use ($svg) {
            $query->where('avtartype_id', $svg->id)->orderBy('id','desc');
        }])->get();

        $user = 0;
        $user_cart=array();
        $user_buy=array();
        if ($request->has('user_id')) {
            $user = User::where('id','=',$request->input('user_id'))->first();
            $user_cart=UserAvatarCart::where('user_id',$request->input('user_id'))->get();
            $user_buy=UserAvatarAttribute::where('user_id',$request->input('user_id'))->get();
        }
        foreach($category as $cdata){        
            foreach($cdata->avtarcomponent as $value){
                $value->is_cart=0;
                if($user_cart!=""){
                    foreach($user_cart as $vdata){
                        if($value->id==$vdata->avatar_component_id){
                            $value->is_cart=1;
                        }
                    }
                }
                
                $value->is_buy=0;
                if($user_buy != ""){
                    foreach($user_buy as $bdata){
                        if($value->id==$bdata->avatar_component_id){
                            $value->is_buy=1;
                        }
                    }
                }
            }
        }
        return view('admin.avtar.clipboard',compact('svg','category','user'));
    }

    public function saveAvatar(Request $request)
    {

        $getUser = User::where('id',$request->id)->first();
        if(\File::exists(storage_path('app/public/uploads/users/avatar'.'/'.$getUser->avatar_profile))){
            \File::delete(storage_path('app/public/uploads/users/avatar'.'/'.$getUser->avatar_profile));    
        }

        $user = new User;
        $user->exists = true;
        $user->id = $request->id;
        $images = explode(";base64,", $request->images);
        $image_type_aux = explode("/", $images[0]);
        $image_type = $image_type_aux[1];
        $safeName ="avatar".uniqid().'.'.$image_type;
        $success = file_put_contents(storage_path('/app/public/uploads/users/avatar').'/'.$safeName, base64_decode($images[1]));
        $user->avatar_profile=$safeName;
        if($user->save()){
            return 1;
        }else{
            return 0;
        }
    }
}
