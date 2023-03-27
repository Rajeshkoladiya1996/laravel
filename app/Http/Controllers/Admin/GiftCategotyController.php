<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GiftCategory;
use App\Models\Gift;
use Auth;


class GiftCategotyController extends Controller
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
        $giftCreateList=GiftCategory::orderBy('updated_at','DESC')->get();
        return view('admin.giftCreate.index',compact('giftCreateList'));
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
            'category_name'=>'required|unique:gift_categories,name|min:2|regex:/^[a-zA-Z0-9 ._\/]+$/u',
        ]);
        
        $gift= new GiftCategory;
        $gift->name = $request->category_name;
        $gift->slug = strtolower(str_replace(' ','-',$request->category_name));

        if(isset($request->images)){           
            $images = explode(";base64,", $request->images);
            $image_type_aux = explode("image/", $images[0]);
            $image_type = $image_type_aux[1];
            $safeName ="gift".uniqid().'.'.$image_type;
            $destinationPath = storage_path('/app/public/uploads/gift');
            $success = file_put_contents(storage_path('/app/public/uploads/gift').'/'.$safeName, base64_decode($images[1]));
            $gift->image=$safeName;
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
        $gift=GiftCategory::where('id',$id)->first();
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
            'category_name'=>'required|min:2|regex:/^[a-zA-Z0-9 ._\/]+$/u|unique:gift_categories,name,'.$request->hid,
        ]);
        $giftold=GiftCategory::where('id',$request->hid)->first();
        $gift= new GiftCategory;
        $gift->exists = true;
        $gift->id = $request->hid;
        $gift->name = $request->category_name;
        $gift->slug = strtolower(str_replace(' ','-',$request->category_name));
        
        if(isset($request->images)){           
            $images = explode(";base64,", $request->images);
            if(isset($images[1])){
                $image_type_aux = explode("image/", $images[0]);
                $image_type = $image_type_aux[1];
                $safeName ="gift".uniqid().'.'.$image_type;
                $destinationPath = storage_path('/app/public/uploads/gift-category');
                $success = file_put_contents(storage_path('/app/public/uploads/gift-category').'/'.$safeName, base64_decode($images[1]));
                
                $gift->image=$safeName;
                if(\File::exists(storage_path('app/public/uploads/gift-category'.'/'.$giftold->image))){
                    \File::delete(storage_path('app/public/uploads/gift-category'.'/'.$giftold->image));
                    // \Storage::delete('/app/public/uploads/gift/'.'/'.$giftold->image);             
                }
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
        $giftList=Gift::where('gift_category_id',$request->id)->get(); 
        if($giftList!=""){        
            foreach($giftList as $data){   
                if($data->image!=""){            
                    if(\File::exists(storage_path('app/public/uploads/gift'.'/'.$data->image))){
                        \File::delete(storage_path('app/public/uploads/gift'.'/'.$data->image));             
                    }
                }
            }
        }
        $data=GiftCategory::where('id',$request->id)->first();
        if($data->image!=""){        
            if(\File::exists(storage_path('app/public/uploads/gift-category'.'/'.$data->image))){
                \File::delete(storage_path('app/public/uploads/gift-category'.'/'.$data->image));             
            }
        }
        $gift=GiftCategory::where('id', $request->id)->delete();
        if($gift){   
            return 1;
        }else{
            return 0;
        }
    }

    public function checkGiftCategoryName(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'name'=>'required|unique:gift_categories,name',
        ]);
        if($validation->fails())
        {   
            return 'false';
        }else{
            return 'true';
        }            
    }
}
