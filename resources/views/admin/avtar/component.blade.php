@extends('layouts.admin')
@section('title')
    Avatar Component
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/jquery-ui.css')}}">
@endsection
@section('content')
    <div class="main-title">
        <h4>Avatar Component </h4>
        <div id="level-point-btn">
            <a href="javascript:void(0)" class="btn btn-pink btn-header-pink" id="add_component_btn"  data-toggle="modal" data-target="#add-component">Add Component</a>
        </div>
    </div>

    <div class="row financial-row">
        <div class="col-lg-12">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="componentList" role="tabpanel" aria-labelledby="rewardList-tab">
                    @include('admin.avtar.componentList')
                </div>
            </div>
        </div>
    </div>

    <!-- Add Avtar Model -->
    <div class="modal fade" id="add-component" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
            <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
        </button>
        <div class="modal-body password-modal">
            <div class="password-moda">
            <h5>Add component</h5>
            <form name="addcomponent_form" id="addcomponent_form">
              <div class="login-input no-icon">
                    <select name="add_avtar_type" id="add_avtar_type" required class="avtar_type" data-id="add">
                        <option value="1">Boy</option>
                        <option value="3" >Girl</option>
                    </select>
                </div> 
                <div class="login-input no-icon">
                    <select name="add_avtar_category" id="add_avtar_category" required class="avtar_type" data-id="add">
                        @foreach($category as $val)
                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="login-input no-icon">
                    <input type="number" id="component_amount" name="component_amount" Placeholder="Amount"> 
                </div>
                <div class="login-input no-icon">
                    <input type="text" id="component_id" name="component_id" Placeholder="Component Id"> 
                </div>
                <div class="gift-input">
                    <label for="component_image" class="gift-label">
                        <input type="file" id="component_image" class="up-image" name="component_image">
                        <div class="upload-box upload-box2">
                            <span class="smaller-img" id="img"><img class="preview-img preview-img_cat" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                            <h6>component Image</h6>
                        </div>
                        <span id="err-component_image" class="error"></span>
                    </label>
                </div>
                <!-- <div class="login-input no-icon">
                    <input type="checkbox" id="iscolor" name="iscolor"> Is Color
                    <div class="color-input">
                        
                    </div>
                </div> -->

                </div>
                <button type="submit" class="btn btn-black" id="addcomponent_button">Save</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>
    <!-- End Avtar Model -->
     <!-- update Avtar Model -->
     <div class="modal fade" id="update-component-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
            <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
        </button>
        <div class="modal-body password-modal">
            <div class="password-moda">
            <h5>Update component</h5>
            <form name="addcomponent_form" id="updatecomponent_form">
              <input type="hidden" name="id" id="update_component_id" /> 
                <div class="login-input no-icon">
                    <select name="edit_avtar_type" id="edit_avtar_type" required class="avtar_type" data-id="add">
                        <option value="1">Boy</option>
                        <option value="3" >Girl</option>
                    </select>
                </div> 
                <div class="login-input no-icon">
                    <select name="edit_avtar_category" id="edit_avtar_category" required class="avtar_type" data-id="add">
                        @foreach($category as $val)
                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                        @endforeach
                    </select>
                </div> 
                <div class="login-input no-icon">
                    <input type="number" id="edit_component_amount" name="edit_component_amount" Placeholder="Amount"> 
                </div>
                <div class="login-input no-icon">
                    <input type="text" id="edit_component_id" name="edit_component_id" Placeholder="Component Id"> 
                </div>
                <div class="gift-input">
                    <label for="edit_component_image" class="gift-label">
                        <input type="file" id="edit_component_image" class="up-image" name="edit_component_image">
                        <div class="upload-box upload-box2">
                            <span class="smaller-img" id="img"><img class="preview-img preview-img_cat edit_preview_img" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                            <h6>component Image</h6>
                        </div>
                        <span id="err-edit_component_image" class="error"></span>
                    </label>
                </div>
                <!-- <div class="login-input no-icon">
                    <input type="checkbox" id="iscolor" name="iscolor"> Is Color
                    <div class="edit-color-input">
                    </div>
                </div> -->

                </div>
                <button type="submit" class="btn btn-black" id="updatecomponent_button">Save</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>
    <!-- End update Avtar Model -->

    <!-- start delete confirmation --> 
    <div class="modal fade" id="component-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                <h5>Delete Avtar</h5>
                <p>Are you sure you want to delete this avatar.</p>
                <input type="hidden" name="type" id="type">
                <input type="hidden" name="del_id" id="del_id">
                <div class="block-btn">
                    <a href="javascript:void(0)" class="btn btn-black delete" data-id="yes">Yes</a>
                    <a href="javascript:void(0)" class="btn btn-red delete" data-id="no">No</a>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- end delete confirmation -->
    <div class="modal fade" id="component-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-body p-0">
            <div class="block-modal">
            <h5>Change Avatar component</h5>
            <p>Are you sure you want to Change Status of this component.</p>
            <input type="hidden" name="component_id" id="component_id">
            <input type="hidden" name="status" id="status">
            <div class="block-btn">
                <a href="javascript:void(0)" class="btn btn-black change" data-id="yes">Yes</a>
                <a href="javascript:void(0)" class="btn btn-red change" data-id="no">No</a>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
        

@endsection

@section('js')

<script>
$('body').on('click','#add_component_btn',function(e){
   $('.preview-img_cat').attr('src',"{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");
});

var componenttable = null;
    $.fn.dataTable.ext.errMode = 'none';
    componenttable = $("#avtarcomponentTable").DataTable({
        processing: true,
        pageLength: 10,
        aaSorting: [],
        responsive: true,
        serverSide: true,
        ordering: true,
        searching: true,
        stateSave:true,
        "ajax": "{{ route('admin.avtar.componentlist') }}",
        "columns": [{
                "data": "id"
            },
            {
                "data": "Avtartype"
            },
            {
                "data": "Componentid"
            },
            {
                "data": "category"
            },
            {
                "data": "image"
            },
            {
                "data": "amount"
            },
            {
                "data": "status"
            },
            {
                "data": "action",
                orderable: false
            }
        ],
        "initComplete": function(settings, json) {

        },
        columnDefs: [{
                responsivePriority: 1,
                targets: 0
            },
            {
                responsivePriority: 2,
                targets: -1
            }
        ]
    });
    //Stream Table
    $("#avtarcomponentTable").DataTable();

$("#component_image").change(function() {
    readURLgif(this);		
});
$("#edit_component_image").change(function() {
    readURLgif(this);       
});
function readURLgif(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {

                $('.preview-img_cat').attr('src', e.target.result);
            }
            const type = input.files[0].type.split('/');
            $('#err-component_image').text("");
            if (type[0] == 'image') {
					
				if(type[1]=='jpeg' || type[1]=="png" || type[1]=="jpg" || type[1]=="svg+xml"){
					
				}else{
					toastr.error('Invalid File input.');
					$('#err-component_image').text("The reward image must be a file of type: jpeg, png, jpg, svg.");
				}
			}else {
				$('#err-component_image').text("The reward image must be a file of type: jpeg, png, jpg, svg.");
				toastr.error('Invalid File input.')
				return false;
			}
            reader.readAsDataURL(input.files[0]);
        }
    };

    // $('body').on('change','#iscolor',function(){

    //     if(this.checked) {
    //         var html= '<input type="text" id="colorcode" name="colorcode" Placeholder="Enter Your Color Code">';
    //         $('.color-input').html(html);
    //     }else{
    //         $('.color-input').html('');
    //     }
     
    // });

    //  $('body').on('change','#editcolorcode',function(){

    //     if(this.checked) {
    //         var html= '<input type="text" id="editcolorcode" name="editcolorcode" Placeholder="Enter Your Color Code">';
    //         $('.edit-color-input').html(html);
    //     }else{
    //         $('.edit-color-input').html('');
    //     }
     
    // });

    

    $( "#addcomponent_form" ).validate({
        rules :{  
            component_name:{
                required: true,
                minlength:2,
            },
            component_amount:{
                required: true,
            },
            component_id:{
                required: true,
            }        
        },
        
    });

    $( "#updatecomponent_form" ).validate({
        rules :{  
            edit_component_name:{
                required: true,
                minlength:2,
            },
            edit_component_amount:{
                required: true,
            },
            edit_component_id:{
                required: true,
            }         
        },
    });
    

    $('#addcomponent_form').on('submit',function (e) {
        e.preventDefault();
        // $('#addreward_button').prop("disabled", true);
        $('#err-component_name').text("");
        $('#err-component_image').text("");
        if($("#addcomponent_form").valid()){  
            var fd = new FormData(this);
            $.ajax({ 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.component.store')}}",
                method:'POST',
                data:fd,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                  // $("#loading-image").show();
                },
                success:function(data){ 
                    if(data == 1){
                        $('#add-component').modal('hide');
                        $('#addcomponent_form')[0].reset();
                        componenttable.ajax.reload(function(json) {}, false);
                        $("#avtarcomponentTable").DataTable();
                        toastr.success('component added successfully.');
                        $('.preview-img_cat').attr('src',"{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");
                    }else{
                        $('#add_component_btn').prop("disabled", false);
                    }
                },
                error:function(errors){
                    $('#addcomponent_button').prop("disabled", false);
                    console.log(errors);
                    for(error in errors.responseJSON.errors){
                            $('#err-'+error).text(errors.responseJSON.errors[error]);
                    }
                }
            });
        }else{
            $('#addcomponent_button').prop("disabled", false);
        }
    })

    // update Avtar
    $('body').on('click','#editcomponent',function(e){
        $('#err-edit_component_name').text("");
        $('#err-edit_component_image').text("");
        $('#updatecomponent_button').prop("disabled", false);
        const id = $(this).attr('data-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{URL::to('godmode/avtar/component/edit')}}"+"/"+id,
            method:'GET',
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success:function(data){
                $('select[name^="edit_avtar_type"] option[value="'+data.component.avtartype_id+'"]').attr("selected","selected");
                $('select[name^="edit_avtar_category"] option[value="'+data.component.avtar_cat_id +'"]').attr("selected","selected");
                $('#edit_component_id').attr('value',data.component.component_id);
                $('#edit_component_amount').attr('value',data.component.amount);
                $('#update-component-model').modal('show');
               
                $('#update_component_id').val(data.component.id);
                if(data.component.image){
                    $('.edit_preview_img').attr('src',"{{URL::to('storage/app/public/uploads/avtar/component')}}"+"/"+data.component.image);
                }else{
                    $('#editcolorcode').attr("selected","selected");
                    var html= '<input type="text" id="editcolorcode" name="editcolorcode" Placeholder="Enter Your Color Code" value='+data.component.iscolor+'>';
                    $('.edit-color-input').html(html);
                }
                
                
            },error:function(error){
            }
        });
    })

    $('#updatecomponent_form').on('submit',function (e) {
        e.preventDefault();
        $('#updatereward_button').prop("disabled", true);
        $('#err-edit-component_name').text("");
        $('#err-edit-component_image').text("");
        if($("#updatecomponent_form").valid()){  
            var fd = new FormData(this);
            $.ajax({ 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.avtar.updatecomponent')}}",
                method:'POST',
                data:fd,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                  // $("#loading-image").show();
                },
                success:function(data){ 
                    if(data == 1){
                        $('#update-component-model').modal('hide');
                        $('#updatecomponent_form')[0].reset();
                        toastr.success('component updated successfully.');
                        componenttable.ajax.reload(function(json) {}, false);
                        $("#avtarcomponentTable").DataTable();
                        $('.preview-img_cat').attr('src',"{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");
                    }else{
                        $('#updatecomponent_button').prop("disabled", false);
                        console.log(data);
                    }
                },
                error:function(errors){
                    $('#updatecomponent_button').prop("disabled", false);
                    for(error in errors.responseJSON.errors){
                        $('#err-edit-'+error).text(errors.responseJSON.errors[error]);
                    }
                }
            });
        }else{
            $('#updatecomponent_button').prop("disabled", false);
        }
    }) 

    // delete component
    $('body').on('click','#deletecomponent',function(){
        $('#del_id').val($(this).attr('data-id'));
        $('#type').val($(this).attr('data-type'));
        $('#component-delete').modal('show');
    })

    $('.delete').on('click',function (e) {
        let confim=$(this).attr('data-id');
        let id=$('#del_id').val();   
        let type = $('#type').val();
        if(confim=="yes"){
            console.log("yes");        
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.avtar.componentdelete')}}",
                method:'POST',
                data:{id:id},
                beforeSend: function() {
                  // $("#loading-image").show();
                },
                success:function(data){
                    if(data == 1){
                        $('.preview-img').attr('src', "{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");
                        $('#json_preview').html('');
                        $('#addcomponent_form')[0].reset();
                        $('#component-delete').modal('hide');
                        componenttable.ajax.reload(function(json) {}, false);
                    }
                },error:function(error){
                    //console.log(error);             
                }
            });
        }else{
            $('#component-delete').modal('hide');
        }
    });

    $('body').on('click','.avtar-component-status',function(){
        $('#component_id').val($(this).attr('data-id'));
        $('#status').val($(this).attr('data-status'));
        $('#component-status').modal('show');
    })

    $('body').on('click','.change',function(){
        let status = $('#status').val();
        let confim=$(this).attr('data-id');
        let id=$('#component_id').val();
            if(confim=="yes"){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('admin.avtar.componentstatus') }}",
                    method:'POST',
                    data:{id:id,status:status},
                    beforeSend: function() {
                        // $("#loading-image").show();
                    },
                    success:function(data){
                        if(data == 1){
                            $('#component-status').modal('hide');
                            componenttable.ajax.reload(function(json) {}, false)
                        }else{
                            console.log(data);
                        }
                    },error:function(error){
                    }
                });
            }else{
                $('#component-status').modal('hide');
            }
    });


</script>

<script src="{{URL::to('storage/app/public/Adminassets/js/jquery-ui.js')}}"></script>
@endsection
