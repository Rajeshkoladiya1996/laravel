<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Gift;
use App\Models\User;
use App\Models\GiftCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class GiftController extends Controller
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
        // $giftList=Gift::with('giftcategory')->orderBy('updated_at','DESC')->get();
        $giftList=GiftCategory::with('gift')->orderBy('updated_at','DESC')->get();
        return view('admin.gift.index',compact('giftList'));
    }

    public function list()
    {
        $giftList=GiftCategory::with('gift')->orderBy('updated_at','DESC')->get();
        return view('admin.gift.giftList',compact('giftList'));
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

        $this->validate($request,[
            'name'=>'required|unique:gifts,name|min:2|regex:/^[a-zA-Z0-9 ._\/]+$/u',
            'gems'=>'required',
            'image'=>'max:5120|mimes:gif,json',
            'images'=>'required',
            'audio'=>'mimes:wav'
        ]);
        
        $gift= new Gift;
        $gift->name = $request->name;
        $gift->slug = strtolower(str_replace(' ','-',$request->name));
        $gift->gems = $request->gems;
        $gift->gift_category_id = $request->gift_catgeory_id;
        $gift->type = $request->gift_type;
        
        if(isset($request->images)){           
            $images = explode(";base64,", $request->images);
            $image_type_aux = explode("/", $images[0]);
            $image_type = $image_type_aux[1];
            $safeName ="gift".uniqid().'.'.$image_type;
            $destinationPath = storage_path('/app/public/uploads/gift');
            $success = file_put_contents(storage_path('/app/public/uploads/gift').'/'.$safeName, base64_decode($images[1]));
            $gift->image=$safeName;
        }

        if(isset($request->audio)){
            $audio = $request->file('audio');
            $filename = 'gift-' . uniqid() . '.' . $audio->getClientOriginalExtension();
            $audio->move(storage_path('/app/public/uploads/gift'), $filename);
            $gift->audio = $filename;
        }

        if($gift->save()){
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gift=Gift::where('id',$id)->first();
        return $gift;
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
            'name'=>'required|regex:/^[a-zA-Z0-9 ._\/]+$/u|min:2|unique:gifts,name,'.$request->id,
            'gems'=>'required',
            'image_edit'=>'max:5120|mimes:gif,json',
            'audio'=>'mimes:wav'
        ]);
        $giftold=Gift::where('id',$request->id)->first();
        $gift= new Gift;
        $gift->exists = true;
        $gift->id = $request->id;
        $gift->name = $request->name;
        $gift->slug = strtolower(str_replace(' ','-',$request->name));
        $gift->gems = $request->gems;
        $gift->gift_category_id = $request->gift_catgeory_id;
        $gift->type = $request->gift_type;
        if(isset($request->images)){           
            $images = explode(";base64,", $request->images);
            if(isset($images[1])){
                $image_type_aux = explode("/", $images[0]);
                $image_type = $image_type_aux[1];
                $safeName ="gift".uniqid().'.'.$image_type;
                $destinationPath = storage_path('/app/public/uploads/gift');
                $success = file_put_contents(storage_path('/app/public/uploads/gift').'/'.$safeName, base64_decode($images[1]));
                
                $gift->image=$safeName;
                if(\File::exists(storage_path('app/public/uploads/gift'.'/'.$giftold->image))){
                    \File::delete(storage_path('app/public/uploads/gift'.'/'.$giftold->image));
                    // \Storage::delete('/app/public/uploads/gift/'.'/'.$giftold->image);             
                }
            }
        }

        if(isset($request->audio)){
            $audio = $request->file('audio');
            $filename = 'gift-' . uniqid() . '.' . $audio->getClientOriginalExtension();
            $audio->move(storage_path('/app/public/uploads/gift'), $filename);
            $gift->audio = $filename;
            if(\File::exists(storage_path('app/public/uploads/gift'.'/'.$giftold->audio))){
                \File::delete(storage_path('app/public/uploads/gift'.'/'.$giftold->audio));    
            }
        }
        
        if($gift->save()){
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
        $data=Gift::where('id',$request->id)->first();
        if(\File::exists(storage_path('app/public/uploads/gift'.'/'.$data->image))){
            \File::delete(storage_path('app/public/uploads/gift'.'/'.$data->image));             
        }
        $gift=Gift::where('id', $request->id)->delete();
        if($gift){   
            return 1;
        }else{
            return 0;
        }
    }

    public function checkGiftName(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'name'=>'required|unique:gifts,name',
        ]);
        if($validation->fails())
        {   
            return 'false';
        }else{
            return 'true';
        }            
    }

    // public function checkGiftImage(Request $request)
    // {
    //     $validation = \Validator::make($request->all(), [
    //         'image_edit'=>'max:2048|mimes:gif',
    //     ]);
    //     if($validation->fails())
    //     {   
    //         return 'false';
    //     }else{
    //         return 'true';
    //     }            
    // }

    public function readFile(Request $request)
    {
        foreach(glob(storage_path('app/public/uploads/gift/*.gif')) as $files){
            echo $files;
            echo "<br>";
            $img = Image::make($files);
            $name=explode('gift/',$files)[1];
            // dd($img);
            $img->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(storage_path('app/public/uploads/gift/1080').'/'. $name);
        }
        die;
    }
}


// 2402:8100:39ae:b3af:3c7e:3168:5c55:ea3c
// 2402:3a80:e54:53b7:cb74:c3e1:b210:a7
// 2402:3a80:e4c:e2ea:e0c5:6ab7:8c04:f0c8
// 2402:3a80:e53:b9e1:0:46:1cfb:a01
// 2401:4900:1a79:f4ba::2a:83d9