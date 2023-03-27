@extends('layouts.admin')
@section('title')
    Avtar List
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/jquery-ui.css')}}">
@endsection
@section('content')
    <div class="main-title">
        <h4>Avtar </h4>
        <div id="level-point-btn">
            <a href="javascript:void(0)" class="btn btn-pink btn-header-pink" id="add_avtar_btn"  data-toggle="modal" data-target="#add-avtar">Add Avatar</a>
        </div>
    </div>

    <nav>
        <div class="nav nav-tabs my-nav active" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active tab-listing toggle-btn" id="avtar-tab" data-toggle="tab" href="#avtarList" role="tab" aria-controls="avtarList" aria-selected="false">Avatar</a>
          <a class="nav-item nav-link tab-listing toggle-btn" id="category-tab" data-toggle="tab" href="#avtarcategoryList" role="tab" aria-controls="points" aria-selected="true">Avatar Category</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">    
        <div class="tab-pane fade show active avtarList" id="avtarList" role="tabpanel" aria-labelledby="avtarList-tab">
            @include('admin.avtar.avtarList')
        </div>
        <div class="tab-pane fade levelPointList" id="avtarcategoryList" role="tabpanel" aria-labelledby="points-tab">
          @include('admin.avtar.categoryList')
        </div>
    </div>

   <!-- ========================= Avtar =====  -->

   
    <div class="modal fade" id="add-avtar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
            <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
        </button>
        <div class="modal-body password-modal">
            <div class="password-moda">
            <h5>Add Avatar</h5>
            <form name="addavtar_form" id="addavtar_form">
               <div class="login-input no-icon">
                    <input type="text" placeholder="Name" class="pr-3" name="avtar_name" id="avtar_name">
                    <span id="err-avtar_name" class="error"></span>
                </div>
                <div class="login-input no-icon">
                    <input type="text" placeholder="Slug" class="pr-3" name="avtar_slug" id="avtar_slug">
                    <span id="err-avtar_slug" class="error"></span>
                </div>
                
                <div class="gift-input">
                    <label for="avtar_image" class="gift-label">
                        <input type="file" id="avtar_image" class="up-image" name="avtar_image">
                        <div class="upload-box upload-box2">
                            <span class="smaller-img" id="img"><img class="preview-img preview-img_gif" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                            <h6>Avatar Image</h6>
                        </div>
                        <span id="err-avtar_image" class="error"></span>
                    </label>
                </div>
                <div class="login-input no-icon">
                    <select name="avtar_type" id="avtar_type" required class="avtar_type" data-id="add">
                        <option value="1">Male</option>
                        <option value="2" >Female</option>
                    </select>
                </div>
                

                </div>
                <button type="submit" class="btn btn-black" id="addreward_button">Save</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>
    <!-- End Avtar Model -->
     <!-- update Avtar Model -->
     <div class="modal fade" id="update-avtar-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
            <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
        </button>
        <div class="modal-body password-modal">
            <div class="password-moda">
            <h5>update Avtar</h5>
            <form name="addavtar_form" id="updateavtar_form">
              <input type="hidden" name="id" id="update_avtar_id" /> 
               <div class="login-input no-icon">
                    <input type="text" placeholder="Name" class="pr-3" name="edit_avtar_name" id="edit_avtar_name">
                    <span id="err-edit_avtar_name" class="error"></span>
                </div>
                <div class="login-input no-icon">
                    <input type="text" placeholder="Slug" class="pr-3" name="edit_avtar_slug" id="edit_avtar_slug">
                    <span id="err-edit_avtar_slug" class="error"></span>
                </div>
                
                <div class="gift-input">
                    <label for="edit_avtar_image" class="gift-label">
                        <input type="file" id="edit_avtar_image" class="up-image" name="edit_avtar_image">
                        <div class="upload-box upload-box2">
                            <span class="smaller-img" id="img"><img class="preview-img preview-img_gif" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                            <h6>Avatar Image</h6>
                        </div>
                        <span id="err-edit_avtar_image" class="error"></span>
                    </label>
                </div>
                <div class="login-input no-icon">
                    <select name="edit_avtar_type" id="edit_avtar_type" required class="avtar_type" data-id="add">
                        <option value="1">Male</option>
                        <option value="2" >Female</option>
                    </select>
                </div>
                

                </div>
                <button type="submit" class="btn btn-black" id="updateavtar_button">Save</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>
    <!-- End update Avtar Model -->

    <!-- start delete confirmation --> 
    <div class="modal fade" id="avtar-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                <h5>Delete Avatar</h5>
                <p>Are you sure you want to delete this avtar.</p>
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
    <div class="modal fade" id="avtar-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body p-0">
        <div class="block-modal">
          <h5>Change Avatar Status</h5>
          <p>Are you sure you want to Change Status of this Avatar.</p>
          <input type="hidden" name="avtar_id" id="avtar_id">
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
<!-- Avtar End -->

<!-- Avtar Category -->

     <!-- Add Avtar Model -->
     <div class="modal fade" id="add-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
            <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
        </button>
        <div class="modal-body password-modal">
            <div class="password-moda">
            <h5>Add Category</h5>
            <form name="addcategory_form" id="addcategory_form">
               <div class="login-input no-icon">
                    <input type="text" placeholder="Name" class="pr-3" name="category_name" id="category_name">
                    <span id="err-category_name" class="error"></span>
                </div>
                <div class="login-input no-icon">
                    <input type="text" placeholder="Class Name" class="pr-3" name="class_name" id="class_name">
                    <span id="err-classname_name" class="error"></span>
                </div>
                <div class="gift-input">
                    <label for="category_image" class="gift-label">
                        <input type="file" id="category_image" class="up-image" name="category_image">
                        <div class="upload-box upload-box2">
                            <span class="smaller-img" id="img"><img class="preview-img preview-img_cat" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                            <h6>Category Image</h6>
                        </div>
                        <span id="err-category_image" class="error"></span>
                    </label>
                </div>
                </div>
                <button type="submit" class="btn btn-black" id="addcategory_button">Save</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>
    <!-- End Avtar Model -->
     <!-- update Avtar Model -->
     <div class="modal fade" id="update-category-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
            <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
        </button>
        <div class="modal-body password-modal">
            <div class="password-moda">
            <h5>Update Category</h5>
            <form name="addcategory_form" id="updatecategory_form">
              <input type="hidden" name="id" id="update_category_id" /> 
               <div class="login-input no-icon">
                    <input type="text" placeholder="Name" class="pr-3" name="edit_category_name" id="edit_category_name">
                    <span id="err-edit_category_name" class="error"></span>
                </div>     
                <div class="login-input no-icon">
                    <input type="text" placeholder="Class Name" class="pr-3" name="edit_class_name" id="edit_class_name">
                    <span id="err-editclass_name" class="error"></span>
                </div>           
                <div class="gift-input">
                    <label for="edit_category_image" class="gift-label">
                        <input type="file" id="edit_category_image" class="up-image" name="edit_category_image">
                        <div class="upload-box upload-box2">
                            <span class="smaller-img" id="img"><img class="preview-img preview-img_cat" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                            <h6>Category Image</h6>
                        </div>
                        <span id="err-edit_category_image" class="error"></span>
                    </label>
                </div>                
                </div>
                <button type="submit" class="btn btn-black" id="updatecategory_button">Save</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>
    <!-- End update Avatar Model -->

    <!-- start delete confirmation --> 
    <div class="modal fade" id="category-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                <h5>Delete Avatar</h5>
                <p>Are you sure you want to delete this avtar.</p>
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
    <div class="modal fade" id="category-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-body p-0">
            <div class="block-modal">
            <h5>Change Avatar Category</h5>
            <p>Are you sure you want to Change Status of this Category.</p>
            <input type="hidden" name="category_id" id="category_id">
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
<!-- End Category -->
        

@endsection

@section('js')

<script>
$('body').on('click','#add_avtar_btn',function(){
  $('.preview-img_gif').attr('src', "{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");
});
$('body').on('click','#add_category_btn',function(){
  $('.preview-img_cat').attr('src', "{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");
});
$("#avtar_image").change(function() {
    readURLgif(this);		
});
$("#edit_avtar_image").change(function(){
    readURLgif(this);	
});
function readURLgif(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                console.log(e.target.result);
                $('.preview-img_gif').attr('src', e.target.result);
            }
            const type = input.files[0].type.split('/');
            console.log(type);
            $('#err-avtar_image').text("");
            if (type[0] == 'image') {
					
				if(type[1]=='jpeg' || type[1]=="png" || type[1]=="jpg" || type[1]=="svg" ||  type[1]=="svg+xml"){
					
				}else{
					toastr.error('Invalid File input.');
					$('#err-avtar_image').text("The reward image must be a file of type: jpeg, png, jpg, svg.");
				}
			}else {
				$('#err-avtar_image').text("The reward image must be a file of type: jpeg, png, jpg, svg.");
				toastr.error('Invalid File input.')
				return false;
			}
            reader.readAsDataURL(input.files[0]);
        }
    };

    $( "#addavtar_form" ).validate({
        rules :{  
            avtar_name:{
                required: true,
                minlength:2,
            },
            avtar_slug:{
                required: true,
            },  
            avtar_image:{
                required:true,
            },              
        },
        
    });

    $( "#updateavtar_form" ).validate({
        rules :{  
            edit_avtar_name:{
                required: true,
                minlength:2,
            },
            edit_avtar_slug:{
                required: true,
            },             
        },
    });
    

    $('#addavtar_form').on('submit',function (e) {
        e.preventDefault();
        // $('#addreward_button').prop("disabled", true);
        $('#err-avtar_name').text("");
        $('#err-avtar_slug').text("");
        $('#err-avtar_image').text("");
        if($("#addavtar_form").valid()){  
            var fd = new FormData(this);
            $.ajax({ 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.avtar.store')}}",
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
                        $('#add-avtar').modal('hide');
                        $('#addavtar_form')[0].reset();
                        $('.preview-img_gif').attr('src', "{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");
                        getavtarlist();
                        toastr.success('Avtar added successfully.');
                    }else{
                        $('#addreward_button').prop("disabled", false);
                        console.log(data);
                    }
                },
                error:function(errors){
                    // $('#addreward_button').prop("disabled", false);
                    // console.log(errors);
                    for(error in errors.responseJSON.errors){
                            $('#err-'+error).text(errors.responseJSON.errors[error]);
                    }
                }
            });
        }else{
           // $('#addreward_button').prop("disabled", false);
        }
    })

    // update Avtar
    $('body').on('click','#editavtar',function(e){
        $('#err-edit_avtar_name').text("");
        $('#err-edit_slug_name').text("");
        $('#err-edit_avtar_image').text("");
        $('#updateavtar_button').prop("disabled", false);
        const id = $(this).attr('data-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{URL::to('godmode/avtar/edit/')}}"+"/"+id,
            method:'GET',
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success:function(data){
                $('#update-avtar-model').modal('show');
                $('#update_avtar_id').val(data.avtar.id);
                $('#edit_avtar_name').val(data.avtar.name);
                $('#edit_avtar_slug').val(data.avtar.slug);
                $('.preview-img_gif').attr('src',"{{URL::to('storage/app/public/uploads/avtar')}}"+"/"+data.avtar.image);
                $('select[name^="edit_avtar_type"] option[value="'+data.avtar.avtar_type+'"]').attr("selected","selected");
            },error:function(error){
            }
        });
    })

    $('#updateavtar_form').on('submit',function (e) {
        e.preventDefault();
        $('#updatereward_button').prop("disabled", true);
        $('#err-edit-reward_name').text("");
        $('#err-edit-description').text("");
        $('#err-edit-reward_image').text("");
        if($("#updateavtar_form").valid()){  
            var fd = new FormData(this);
            $.ajax({ 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.avtar.update')}}",
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
                        $('#update-avtar-model').modal('hide');
                        $('#updateavtar_form')[0].reset();
                        $('.preview-img_gif').attr('src', "{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");
                        toastr.success('Avtar updated successfully.');
                        getavtarlist();
                    }else{
                        $('#updateavtar_button').prop("disabled", false);
                        console.log(data);
                    }
                },
                error:function(errors){
                    $('#updateavtar_button').prop("disabled", false);
                    for(error in errors.responseJSON.errors){
                        $('#err-edit-'+error).text(errors.responseJSON.errors[error]);
                    }
                }
            });
        }else{
            $('#updateavtar_button').prop("disabled", false);
        }
    }) 

    // delete Reward
    $('body').on('click','#deleteavtar',function(){
        $('#del_id').val($(this).attr('data-id'));
        $('#type').val($(this).attr('data-type'));
        $('#avtar-delete').modal('show');
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
                url:"{{route('admin.avtar.delete')}}",
                method:'POST',
                data:{id:id},
                beforeSend: function() {
                  // $("#loading-image").show();
                },
                success:function(data){
                    if(data == 1){
                        $('#avtar-delete').modal('hide');
                        getavtarlist();
                    }
                },error:function(error){
                    //console.log(error);             
                }
            });
        }else{
            $('#avtar-delete').modal('hide');
        }
    });

    $('body').on('click','.avtar-status',function(){
        $('#avtar_id').val($(this).attr('data-id'));
        $('#status').val($(this).attr('data-status'));
        $('#avtar-status').modal('show');
    })

    $('body').on('click','.change',function(){
        let status = $('#status').val();
        let confim=$(this).attr('data-id');
        let id=$('#avtar_id').val();
            if(confim=="yes"){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('admin.avtar.status') }}",
                    method:'POST',
                    data:{id:id,status:status},
                    beforeSend: function() {
                        // $("#loading-image").show();
                    },
                    success:function(data){
                        if(data == 1){
                            $('#avtar-status').modal('hide');
                            getavtarlist();
                        }else{
                            console.log(data);
                        }
                    },error:function(error){
                    }
                });
            }else{
                $('#avtar-status').modal('hide');
            }
    });


    function getavtarlist() {
        $.ajax({
            url:"{{ route('admin.avtar.list') }}",
            type:'GET',
            success:function(response){
                $('#avtarList').html(response);
                $("#avtarTable").DataTable();
            }
        });
    }


</script>

<script>
$("#category_image").change(function() {
    readURLgif1(this);		
});

$("#edit_category_image").change(function(){
    readURLgif1(this);
});

function readURLgif1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {

                $('.preview-img_cat').attr('src', e.target.result);
            }
            const type = input.files[0].type.split('/');
            $('#err-category_image').text("");
            if (type[0] == 'image') {
					
				if(type[1]=='jpeg' || type[1]=="png" || type[1]=="jpg" || type[1]=="svg" || type[1]=="svg+xml"){
					
				}else{
					toastr.error('Invalid File input.');
					$('#err-category_image').text("The reward image must be a file of type: jpeg, png, jpg, svg.");
				}
			}else {
				$('#err-category_image').text("The reward image must be a file of type: jpeg, png, jpg, svg.");
				toastr.error('Invalid File input.')
				return false;
			}
            reader.readAsDataURL(input.files[0]);
        }
    };


    $('body').on('click','.toggle-btn',function(e){
         const id = $(this).attr('id');
         console.log(id);
        if(id == "avtar-tab"){
            let link = `<a href="javascript:void(0)" class="btn btn-pink btn-header-pink" id="add_avtar_btn" data-toggle="modal" data-target="#add-avtar">Add Avtar</a>`;
            $('#level-point-btn').html(link);
        }else{
            let link = `<a href="javascript:void(0)" class="btn btn-pink btn-header-pink" id="add_category_btn" data-toggle="modal" data-target="#add-category">Add Category</a>`;
            $('#level-point-btn').html(link);
        }
    })

    $( "#addcategory_form" ).validate({
        rules :{  
            category_name:{
                required: true,
                minlength:2,
            },
            category_image:{
                required:true,
            },              
        },
        
    });

    $( "#updatecategory_form" ).validate({
        rules :{  
            edit_category_name:{
                required: true,
                minlength:2,
            }          
        },
    });
    

    $('#addcategory_form').on('submit',function (e) {
        e.preventDefault();
        // $('#addreward_button').prop("disabled", true);
        $('#err-category_name').text("");
        $('#err-category_image').text("");
        if($("#addcategory_form").valid()){  
            var fd = new FormData(this);
            $.ajax({ 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.category.store')}}",
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
                        $('#add-category').modal('hide');
                        $('#addcategory_form')[0].reset();
                        getcategorylist();
                        toastr.success('Category added successfully.');
                        $('.preview-img_cat').attr('src',"{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");
                    }else{
                        $('#add_category_btn').prop("disabled", false);
                    }
                },
                error:function(errors){
                    $('#addcategory_button').prop("disabled", false);
                    console.log(errors);
                    for(error in errors.responseJSON.errors){
                            $('#err-'+error).text(errors.responseJSON.errors[error]);
                    }
                }
            });
        }else{
            $('#addcategory_button').prop("disabled", false);
        }
    })

    // update Avtar
    $('body').on('click','#editcategory',function(e){
        $('#err-edit_category_name').text("");
        $('#err-edit_category_image').text("");
        $('#updatecategory_button').prop("disabled", false);
        const id = $(this).attr('data-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{URL::to('godmode/avtar/category/edit')}}"+"/"+id,
            method:'GET',
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success:function(data){
                $('#update-category-model').modal('show');
                $('#update_category_id').val(data.category.id);
                $('#edit_category_name').val(data.category.name);
                $('#edit_class_name').val(data.category.class_name);
                $('.preview-img_cat').attr('src',"{{URL::to('storage/app/public/uploads/avtar/category')}}"+"/"+data.category.image);
            },error:function(error){
            }
        });
    })

    $('#updatecategory_form').on('submit',function (e) {
        e.preventDefault();
        $('#updatereward_button').prop("disabled", true);
        $('#err-edit-category_name').text("");
        $('#err-edit-category_image').text("");
        if($("#updatecategory_form").valid()){  
            var fd = new FormData(this);
            $.ajax({ 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.avtar.updatecategory')}}",
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
                        $('#update-category-model').modal('hide');
                        $('#updatecategory_form')[0].reset();
                        toastr.success('Category updated successfully.');
                        getcategorylist();
                    }else{
                        $('#updatecategory_button').prop("disabled", false);
                        console.log(data);
                    }
                },
                error:function(errors){
                    $('#updatecategory_button').prop("disabled", false);
                    for(error in errors.responseJSON.errors){
                        $('#err-edit-'+error).text(errors.responseJSON.errors[error]);
                    }
                }
            });
        }else{
            $('#updatecategory_button').prop("disabled", false);
        }
    }) 

    // delete category
    $('body').on('click','#deletecategory',function(){
        $('#del_id').val($(this).attr('data-id'));
        $('#type').val($(this).attr('data-type'));
        $('#category-delete').modal('show');
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
                url:"{{route('admin.avtar.categorydelete')}}",
                method:'POST',
                data:{id:id},
                beforeSend: function() {
                  // $("#loading-image").show();
                },
                success:function(data){
                    if(data == 1){
                        $('#category-delete').modal('hide');
                        getcategorylist();
                    }
                },error:function(error){
                    //console.log(error);             
                }
            });
        }else{
            $('#category-delete').modal('hide');
        }
    });

    $('body').on('click','.avtar-category-status',function(){
        $('#category_id').val($(this).attr('data-id'));
        $('#status').val($(this).attr('data-status'));
        $('#category-status').modal('show');
    })

    $('body').on('click','.change',function(){
        let status = $('#status').val();
        let confim=$(this).attr('data-id');
        let id=$('#category_id').val();
            if(confim=="yes"){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('admin.avtar.categorystatus') }}",
                    method:'POST',
                    data:{id:id,status:status},
                    beforeSend: function() {
                        // $("#loading-image").show();
                    },
                    success:function(data){
                        if(data == 1){
                            $('#category-status').modal('hide');
                            getcategorylist();
                        }else{
                            console.log(data);
                        }
                    },error:function(error){
                    }
                });
            }else{
                $('#category-status').modal('hide');
            }
    });

    function getcategorylist() {
        $.ajax({
            url:"{{ route('admin.avtar.categorylist') }}",
            type:'GET',
            success:function(response){
                $('#avtarcategoryList').html(response);
                $("#avtarcategoryTable").DataTable();
            }
        });
    }

</script>

 <!-- <script src="{{URL::to('storage/app/public/Adminassets/js/jquery-1.9.1.js')}}"></script>  -->
<!-- <script src="{{URL::to('storage/app/public/Adminassets/js/jquery-ui.js')}}"></script> -->
@endsection
