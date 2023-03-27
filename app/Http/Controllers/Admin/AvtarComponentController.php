<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AvtarComponent;
use App\Models\AvtarCategory;
use App\Models\AvtarType;

class AvtarComponentController extends Controller
{
    public function index(){
      $component = AvtarComponent::with('avtartype','avtarcategory')->orderby('id','desc')->get();
      $category = AvtarCategory::where('status','1')->get();
      $avtarlist=AvtarType::where('status','1')->get();
      return view('admin.avtar.component',compact('component','category','avtarlist'));
    }

    public function category(){

    }
    public function store(Request $request){

        $data = new AvtarComponent;
        $data->avtar_cat_id  = $request->add_avtar_category;
        $data->avtartype_id  = $request->add_avtar_type;
        $data->component_id = $request->component_id;
         $data->amount = $request->component_amount;
        $image = $request->file('component_image');
        if ($image != null) {
            $new_name =  rand() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('/app/public/uploads/avtar/component/'), $new_name);
            $data->image = $new_name;
        }
        if($request->iscolor == 'on'){
            $data->iscolor  = $request->colorcode;  
        }
        if ($data->save()) {
            return 1;
        }else{
            return 0;
        }
        
    }
    public function componentlist(Request $request){
        
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = (int)$request->get('length');
        $page = ($request->start / $length) + 1;
        $search = $request->search['value'];

        $component = AvtarComponent::with('avtartype','avtarcategory')->orderby('id','desc');
        if ($search != "") {
            $component = $component->where(function ($q) use ($search) {
                $q->where('component_id', 'like', '%' . $search . '%');
            });
        }

        if (!isset($request->order)) {
            $component = $component->orderby('avtar_components.id', 'DESC');
        } else {
            
            $columns = $request->order[0]['column'];
            $order = $request->order[0]['dir'];
            $name_field = $request->columns[$columns]['data'];
            if ($request->order[0]['column'] == 0){
                $component = $component->orderby('id', $order);
            }
            if($request->order[0]['column'] == 1){
                $component = $component->orderby('component_id', $order);
            }
            if($request->order[0]['column'] == 2){
                $component = $component->orderby('avtar_cat_id', $order);
            }
            if($request->order[0]['column'] == 5){
                $component = $component->orderby('amount', $order);
            }
            if ($request->order[0]['column'] != 0 && $request->order[0]['column'] != 1 && $request->order[0]['column'] != 2 && $request->order[0]['column'] != 5) {
                $component = $component->orderby($name_field, $order);
            }
        }
        $component = $component->paginate($length, ['*'], 'page', $page);
        $data_arr = array();
         $cnt = $start + 1;

         foreach ($component as $value) {
            $image = '<img src="' . url('storage/app/public/uploads/avtar/component/'.$value->image) . '" alt=""  width="50px" height="50px">'; 
            $color = ($value->status == '1') ?'green' : 'red';
            $active = ($value->status == '1')? 'Active' : 'De-active';
            $status ='<span class="'.$color.' avtar-component-status" data-status="'.$value->status.'" data-id="'.$value->id.'">'.$active.'</span>';
            $action='<ul class="action-wrap">
            <li>
                <a href="javascript:void(0)" id="editcomponent" data-id="'.$value->id.'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16.473" height="16.473" viewBox="0 0 16.473 16.473">
                    <path id="Path_376" data-name="Path 376"
                        d="M14.667,9.131l-1.3-1.3L4.833,16.373v1.3h1.3l8.538-8.538Zm1.3-1.3,1.3-1.3-1.3-1.3-1.3,1.3ZM6.889,19.5H3V15.613L15.315,3.3a.917.917,0,0,1,1.3,0L19.2,5.891a.917.917,0,0,1,0,1.3L6.889,19.5Z"
                        transform="translate(-3 -3.029)" fill="#00b247" />
                    </svg>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" id="deletecomponent" data-id="'.$value->id.'" data-type="avtarlist">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                        d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm-8 5v6h2v-6H9zm4 0v6h2v-6h-2zM9 4v2h6V4H9z"
                        fill="rgba(255,0,0,1)" />
                    </svg>
                </a>
            </li>
        </ul>';
            
            
            $data_arr[] = array(
                "id" => $cnt,
                "Avtartype" => $value->avtartype->name,
                "Componentid" => $value->component_id,
                "category" => $value->avtarcategory->name,
                "image"=> $image,
                "amount" =>$value->amount,
                "status" => $status,
                "action" =>  $action,
                );
                
            $cnt++;
         }

        $component = (array)json_decode(json_encode($component));
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $component['total'],
            "iTotalDisplayRecords" => $component['total'],
            "aaData" => $data_arr
        );
          
       
        return $response;

    }

    public function componentstatus(Request $request){

        $data = new AvtarComponent;
        $data->exists = true;
        $data->id = $request->id;
        if($request->status == "0"){
            $data->status =1;
        }else{
            $data->status = 0;
        }
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
        
    }

    public function componentdelete(Request $request){
        $data=AvtarComponent::where('id',$request->id)->first();
        if(\File::exists(storage_path('app/public/uploads/component'.'/'.$data->image))){
            \File::delete(storage_path('app/public/uploads/component'.'/'.$data->image));             
        }   
        $avtar=AvtarComponent::where('id', $request->id)->delete();

        if($avtar){   
            return 1;
        }else{
            return 0;
        }
        
    }
    public function editcomponent($id){
        $component=AvtarComponent::where('id',$id)->first();
        return response()->json(['component'=>$component], 200); 
    }

    public function update(Request $request){

        $data['avtar_cat_id']  = $request->edit_avtar_category;
        $data['avtartype_id']  = $request->edit_avtar_type;
        $data['component_id'] = $request->edit_component_id;
        $data['amount'] = $request->edit_component_amount;
        $image = $request->file('edit_component_image');
        if ($image != null) {
            $new_name =  rand() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('/app/public/uploads/avtar/component/'), $new_name);
            $data['image'] = $new_name;
        }
        if($request->iscolor == 'on'){
            $data['iscolor']  = $request->colorcode;  
        }

        $avtar=AvtarComponent::where('id', $request->id)->update($data);
        if($avtar){   
            return 1;
        }else{
            return 0;
        }

    }
}
