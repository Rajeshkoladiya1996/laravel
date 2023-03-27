@extends('layouts.admin')
@section('title')
    Reward List
@endsection
@section('css')
@endsection
@section('content')
    <div class="main-title">
        <h4>Reward Management </h4>
        <div id="level-point-btn">
            <a href="javascript:void(0)" class="btn btn-pink btn-header-pink" id="add_reward_btn"  data-toggle="modal" data-target="#add-reward">Add Reward</a>
        </div>
    </div>
    <nav>
        <div class="nav nav-tabs my-nav active" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active tab-listing toggle-btn" id="rewardList-tab" data-toggle="tab" href="#rewardList" role="tab" aria-controls="rewardList" aria-selected="false">Rewards</a>
          <a class="nav-item nav-link tab-listing toggle-btn" id="points-tab" data-toggle="tab" href="#pointsList" role="tab" aria-controls="points" aria-selected="true">Reward Points</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">    
        <div class="tab-pane fade show active reward-list-page" id="rewardList" role="tabpanel" aria-labelledby="rewardList-tab">
            @include('admin.reward.rewardList')
        </div>
        <div class="tab-pane fade rewardPointList" id="pointsList" role="tabpanel" aria-labelledby="points-tab">
            @include('admin.reward.rewardPointList')
        </div>
    </div>
    
@endsection
@section('js')

{{-- Start Store Reward  --}}
<div class="modal fade" id="add-reward" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
      </button>
      <div class="modal-body password-modal">
        <div class="password-moda">
          <h5>Add Reward</h5>
          <form name="addreward_from" id="addreward_from">
            <div class="login-input no-icon">
                <input type="text" placeholder="Name" class="pr-3" name="reward_name" id="reward_name">
                <span id="err-reward_name" class="error"></span>
            </div>
            <div class="login-input no-icon">
                <input type="text" placeholder="Description" class="pr-3" name="description" id="description">
                <span id="err-description" class="error"></span>
            </div>
            <div class="gift-input">
                <label for="reward_image" class="gift-label">
                    <input type="file" id="reward_image" class="up-image" name="reward_image">
                    <div class="upload-box upload-box2">
                        <span class="smaller-img" id="img"><img class="preview-img preview-img_gif" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                        <h6>Upload Gift</h6>
                    </div>
                    <span id="err-reward_image" class="error"></span>
                </label>
            </div>
            <div class="login-input no-icon">
                <select name="reward_type" id="reward_type" required class="reward_type" data-id="add">
                    <option value="">Select Reward Type</option>
                    @foreach ($rewardType as $data)
                        <option value="{{$data}}" >{{ Str::ucfirst($data) }}</option>
                    @endforeach
                </select>
            </div>
            <div id="reward_value" class="login-input no-icon">

            </div>
            <button type="submit" class="btn btn-black" id="addreward_button">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- End Store Reward  --}}


{{-- Start Update Reward  --}}
<div class="modal fade" id="reward-update-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
          <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
        </button>
        <div class="modal-body password-modal">
          <div class="password-moda">
            <h5>Update Reward</h5>
            <form name="updatereward_from" id="updatereward_from">
                <input type="hidden" name="id" id="update_id" /> 
                <div class="login-input no-icon">
                    <input type="text" placeholder="Name" class="pr-3" name="reward_name" id="edit_reward_name">
                    <span id="err-edit-reward_name" class="error"></span>
                </div>
                <div class="login-input no-icon">
                    <input type="text" placeholder="Description" class="pr-3" name="description" id="edit_description">
                    <span id="err-edit-description" class="error"></span>
                </div>
                <div class="gift-input">
                        <label for="edit_reward_image" class="gift-label edit">
                        <input type="file" id="edit_reward_image" class="up-image" name="reward_image">
                        <div class="upload-box upload-box2">
                            <span class="smaller-img"><img class="preview-img-edit" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                            <h6>Upload Gift</h6>
                        </div>
                        <span id="err-edit-reward_image" class="error"></span>
                    </label>
                </div>
                <div class="login-input no-icon">
                    <select name="reward_type" id="edit_reward_type" required class="reward_type" data-id="update">
                        <option value="">Select Reward Type</option>
                        @foreach ($rewardType as $data)
                            <option value="{{$data}}" >{{ Str::ucfirst($data) }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="update_reward_value" class="login-input no-icon">

                </div>
              <button type="submit" class="btn btn-black" id="updatereward_button">Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
{{-- Start Update Reward  --}}

{{-- Start Update Reward  --}}
<div class="modal fade" id="rewardpoints-update-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
          <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
        </button>
        <div class="modal-body password-modal">
          <div class="password-moda">
            <h5>Update Reward Points</h5>
            <form name="updatereward_points_form" id="updatereward_points_form">
                <input type="hidden" name="id" id="update_points_id" /> 
                <div class="login-input no-icon">
                    <input type="text" placeholder="Name" class="pr-3" name="reward_name" id="edit_reward_points_name">
                    <span id="err-point-reward_name" class="error"></span>
                </div>
                <div class="login-input no-icon">
                    <input type="text" placeholder="Day" class="pr-3" name="day" id="edit_day">
                    <span id="err-point-day" class="error"></span>
                </div>
                <div class="gift-input">
                        <label for="edit_p_reward_image" class="gift-label edit">
                        <input type="file" id="edit_p_reward_image" class="up-image" name="reward_image">
                        <div class="upload-box upload-box2">
                            <span class="smaller-img" ><img class="points-preview-img-edit" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                            <h6>Upload Image</h6>
                        </div>
                        <span id="err-point-reward_image" class="error"></span>
                    </label>
                </div>
               
                <div id="update_rewardpoints_value" class="login-input no-icon">
                    <input type="text" placeholder="Enter reward points" class="pr-3" name="reward_points" id="reward_type_value"  required>
                    <span id="err-point-reward_points" class="error"></span>
                </div>
              <button type="submit" class="btn btn-black" id="updatereward_points_button">Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
{{-- Start Update Reward  --}}

<div class="modal fade" id="reward-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body p-0">
        <div class="block-modal">
          <h5>Delete Reward</h5>
          <p>Are you sure you want to delete this reward.</p>
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

<div class="modal fade" id="reward-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body p-0">
        <div class="block-modal">
          <h5>Change Reward Status</h5>
          <p>Are you sure you want to Change Status of this Reward.</p>
          <input type="hidden" name="reward_id" id="reward_id">
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
<script>
    $("#reward_image").change(function() {
		readURLgif(this);		
    });

    $("#edit_reward_image").change(function() {
        readURLEdit(this);	
    }); 
    $("#edit_p_reward_image").change(function() {
        readURLPointEdit(this);  
    });
    function readURLPointEdit(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            const type = input.files[0].type.split('/');
            $('#err-point-reward_image').text("");
            if (type[0] == 'image') {
				    reader.onload = function(e) {
                        $('.preview-img-edit').attr('src', e.target.result);
                        $('.points-preview-img-edit').attr('src', e.target.result);
                    }
					
				if(type[1]=='jpeg' || type[1]=="png" || type[1]=="jpg" || type[1]=="svg"){
					
				}else{
					toastr.error('Invalid File input.');
					$('#err-point-reward_image').text("The reward image must be a file of type: jpeg, png, jpg, svg.");
				}
			}else {
				$('#err-point-reward_image').text("The reward image must be a file of type: jpeg, png, jpg, svg.");
				toastr.error('Invalid File input.')
				return false;
			}
            reader.readAsDataURL(input.files[0]);
        }
    };

    function readURLgif(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.preview-img_gif').attr('src', e.target.result);
            }
            const type = input.files[0].type.split('/');
            $('#err-reward_image').text("");
            if (type[0] == 'image') {
					
				if(type[1]=='jpeg' || type[1]=="png" || type[1]=="jpg" || type[1]=="svg"){
					
				}else{
					toastr.error('Invalid File input.');
					$('#err-reward_image').text("The reward image must be a file of type: jpeg, png, jpg, svg.");
				}
			}else {
				$('#err-reward_image').text("The reward image must be a file of type: jpeg, png, jpg, svg.");
				toastr.error('Invalid File input.')
				return false;
			}
            reader.readAsDataURL(input.files[0]);
        }
    };

    function readURLEdit(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            const type = input.files[0].type.split('/');
            $('#err-edit-reward_image').text("");
            if (type[0] == 'image') {
				    reader.onload = function(e) {
                        $('.preview-img-edit').attr('src', e.target.result);
                        $('.points-preview-img-edit').attr('src', e.target.result);
                    }
					
				if(type[1]=='jpeg' || type[1]=="png" || type[1]=="jpg" || type[1]=="svg"){
					
				}else{
					toastr.error('Invalid File input.');
					$('#err-edit-reward_image').text("The reward image must be a file of type: jpeg, png, jpg, svg.");
				}
			}else {
				$('#err-edit-reward_image').text("The reward image must be a file of type: jpeg, png, jpg, svg.");
				toastr.error('Invalid File input.')
				return false;
			}
            reader.readAsDataURL(input.files[0]);
        }
    };

    function getRewardList() {
        $.ajax({
            url:"{{ route('admin.reward.getlist') }}",
            type:'GET',
            success:function(response){
                $('#rewardList').html(response);
                $("#example").DataTable();
            }
        });
    }
    
    $( "#addreward_from" ).validate({
        rules :{  
            reward_name:{
                required: true,
                minlength:2,
            },
            description:{
                required: true,
            },  
            reward_image:{
                required:true,
            },              
        },
        
    });

    $( "#updatereward_from" ).validate({
        rules :{  
            edit_reward_name:{
                required: true,
                minlength:2,
            },
            edit_description:{
                required: true,
            },                
        },
    });
    
    $('#addreward_from').on('submit',function (e) {
        e.preventDefault();
        $('#addreward_button').prop("disabled", true);
        $('#err-reward_name').text("");
        $('#err-description').text("");
        $('#err-reward_image').text("");
        if($("#addreward_from").valid()){  
            var fd = new FormData(this);
            $.ajax({ 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.reward.store')}}",
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
                        $('#add-reward').modal('hide');
                        $('#addreward_from')[0].reset();
                        getRewardList();
                        toastr.success('Reward added successfully.');
                        $('.preview-img').attr('src',"{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");
                    }else{
                        $('#addreward_button').prop("disabled", false);
                        console.log(data);
                    }
                },
                error:function(errors){
                    $('#addreward_button').prop("disabled", false);
                    console.log(errors);
                    for(error in errors.responseJSON.errors){
                            $('#err-'+error).text(errors.responseJSON.errors[error]);
                    }
                }
            });
        }else{
            $('#addreward_button').prop("disabled", false);
        }
    }) 

    $('body').on('click','#deleteReward',function(){
        $('#del_id').val($(this).attr('data-id'));
        $('#type').val($(this).attr('data-type'));
        $('#reward-delete').modal('show');
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
                url:"{{route('admin.reward.delete')}}",
                method:'POST',
                data:{id:id},
                beforeSend: function() {
                  // $("#loading-image").show();
                },
                success:function(data){
                    if(data == 1){
                        $('#reward-delete').modal('hide');
                        getRewardList();
                    }
                },error:function(error){
                    console.log(error);             
                }
            });
        }else{
            $('#reward-delete').modal('hide');
        }
    });

    $('body').on('click','#editReward',function(e){
        $('#err-edit-reward_name').text("");
        $('#err-edit-description').text("");
        $('#err-edit-reward_image').text("");
        $('#edit_reward_type-error').text("");
        $('#txt_gift-error').text("");
        $('#updatereward_button').prop("disabled", false);
        const id = $(this).attr('data-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{URL::to('godmode/reward/edit/')}}"+"/"+id,
            method:'GET',
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success:function(data){
                $('#update_id').val(data.rewardDetail.id);
                $('#edit_reward_name').val(data.rewardDetail.name);
                $('#edit_description').val(data.rewardDetail.description);
                $('#edit_reward_type').val(data.rewardDetail.type);
                if(data.rewardDetail.type == "Salmon Coins" || data.rewardDetail.type == "Gold Coins" || data.rewardDetail.type == "levelpoints"){
                    $('#update_reward_value').html(getRewardTypeValue(data.rewardDetail.type));
                    $('#reward_type_value').val(data.rewardDetail.type_value);
                }else if(data.rewardDetail.type == "gift"){
                    $('#update_reward_value').html(getRewardTypeValue(data.rewardDetail.type));
                    console.log("gift load");
                    $('#txt_gift').val(data.rewardDetail.type_value);
                }else{
                    $('#update_reward_value').html("");
                }
                $('#reward-update-model').modal('show');
                $('.preview-img-edit').attr('src',"{{URL::to('storage/app/public/uploads/reward')}}"+"/"+data.rewardDetail.image);
            },error:function(error){
            }
        });
    })

    $('#updatereward_from').on('submit',function (e) {
        e.preventDefault();
        $('#updatereward_button').prop("disabled", true);
        $('#err-edit-reward_name').text("");
        $('#err-edit-description').text("");
        $('#err-edit-reward_image').text("");
        if($("#updatereward_from").valid()){  
            var fd = new FormData(this);
            $.ajax({ 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.reward.update')}}",
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
                        $('#reward-update-model').modal('hide');
                        $('#updatereward_from')[0].reset();
                        toastr.success('Reward updated successfully.');
                        getRewardList();
                    }else{
                        $('#updatereward_button').prop("disabled", false);
                        console.log(data);
                    }
                },
                error:function(errors){
                    $('#updatereward_button').prop("disabled", false);
                    for(error in errors.responseJSON.errors){
                        $('#err-edit-'+error).text(errors.responseJSON.errors[error]);
                    }
                }
            });
        }else{
            $('#updatereward_button').prop("disabled", false);
        }
    }) 

    
    $('body').on('click','.reward-status',function(){
        $('#reward_id').val($(this).attr('data-id'));
        $('#status').val($(this).attr('data-status'));
        $('#reward-status').modal('show');
    })
    
    $('body').on('click','.change',function(){
        let status = $('#status').val();
        let confim=$(this).attr('data-id');
        let id=$('#reward_id').val();
            if(confim=="yes"){
                console.log("yes");  
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('admin.reward.status') }}",
                    method:'POST',
                    data:{id:id,status:status},
                    beforeSend: function() {
                        // $("#loading-image").show();
                    },
                    success:function(data){
                        if(data == 1){
                            $('#reward-status').modal('hide');
                            getRewardList();
                        }else{
                            console.log(data);
                        }
                    },error:function(error){
                    }
                });
            }else{
                $('#reward-status').modal('hide');
            }
    });

    function getRewardTypeValue(type) {
        let element = "";
        if(type != 'gift'){
            element = `<input type="text" placeholder="Enter `+type+`" class="pr-3" name="reward_type_value" id="reward_type_value" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;" required>
                <span id="err-reward_type_value" class="error"></span>`;
        }else{
            element = `<select name="txt_`+type+`" id="txt_`+type+`" required>
                    <option value="">Select Gift</option>
                    @foreach ($giftList as $data)
                        <option value="{{$data->id}}" >{{ Str::ucfirst($data->name) }} - {{ $data->gems }} (Gems) </option>
                    @endforeach
                </select>`;
        }
        return element;
    }

    $('body').on('change','.reward_type',function(){
        const type = $(this).val();
        const method = $(this).attr('data-id');
        let id = "";
        if(method == 'add'){
            id = '#reward_value';
        }else if(method == 'update'){
            id = '#update_reward_value';
        }
        if(type == 'Salmon Coins'){
            $(id).html(getRewardTypeValue(type));
        }else if(type == 'Gold Coins'){
            $(id).html(getRewardTypeValue(type));
        }
        else if(type == 'gift'){
            $(id).html(getRewardTypeValue(type));
        }
        else if(type == 'levelpoints'){
            $(id).html(getRewardTypeValue(type));
        }
        else{
            $(id).html("");
        }
    })
    
    $('body').on('click','.toggle-btn',function(e){
        const id = $(this).attr('id');
        if(id == "points-tab"){
            $('#level-point-btn').html('');
        }else{
            let link = `<a href="javascript:void(0)" class="btn btn-pink btn-header-pink" id="add_reward_btn"  data-toggle="modal" data-target="#add-reward">Add Reward</a>`;
            $('#level-point-btn').html(link);
        }
    })

    $("#add_reward_btn").click(function(){
        $('#addreward_button').prop("disabled", false);
        $('#err-reward_name').text("");
        $('#err-description').text("");
        $('#err-reward_image').text("");
        $('#reward_name-error').text("");
        $("#description-error").text("");
        $('#reward_type-error').text("");
        $('#reward_image-error').text("");
        $('#reward_name').val("");
        $('#description').val("");
        $('#reward_image').val("");
        
        // $('.preview-img_gif').attr('src',"");
    });

    $('body').on('click','#editRewardPoint',function(e){
        $('#updatereward_points_button').prop("disabled", false);
        $('#edit_reward_points_name-error').text("");
        $('#edit_day-error').text("");
        $('#err-point-reward_image').text("");
        $('#reward_type_value-error').text("");
        const id = $(this).attr('data-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{URL::to('godmode/reward/point/edit/')}}"+"/"+id,
            method:'GET',
            beforeSend: function() {
            },
            success:function(data){
                $('#update_points_id').val(data.id);
                $('#edit_reward_points_name').val(data.name);
                $('#edit_day').val(data.day);
                $('#reward_type_value').val(data.points);
                $('#rewardpoints-update-model').modal('show');
                $('.points-preview-img-edit').attr('src',"{{URL::to('storage/app/public/uploads/reward')}}"+"/"+data.image);
            },error:function(error){
            }
        });
    });
    $( "#updatereward_points_form" ).validate({
        rules :{  
            reward_name:{
                required: true,
                minlength:2,
            },
            day:{
                required: true,
            },
            reward_points:{
                required: true,
            },                
        },
    });

    $('#updatereward_points_form').on('submit',function (e) {
        e.preventDefault();
        $('#updatereward_points_button').prop("disabled", true);
        if($("#updatereward_points_form").valid()){  
            var fd = new FormData(this);
            $.ajax({ 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.reward.point.update')}}",
                method:'POST',
                data:fd,
                cache: false,
                contentType: false,
                processData: false,
                
                success:function(data){ 
                    if(data == 1){
                        $('#rewardpoints-update-model').modal('hide');
                        $('#updatereward_points_form')[0].reset();
                        $('#updatereward_points_button').prop("disabled", false);
                        toastr.success('Reward-Point updated successfully.');
                        getRewardPointList();
                    }else{
                        console.log(data);
                    }
                },
                error:function(errors){
                    $('#updatereward_points_button').prop("disabled", false);
                    for(error in errors.responseJSON.errors){
                        $('#err-point-'+error).text(errors.responseJSON.errors[error]);
                    }
                }
            });
        }else{
            $('#updatereward_points_button').prop("disabled", false);
        }
    });
    function getRewardPointList() {
        $.ajax({
            url:"{{ route('admin.reward.point.getlist') }}",
            type:'GET',
            success:function(response){
                $('#pointsList').html(response);
                $("#example2").DataTable();
            }
        });
    }
    
</script>

@endsection
