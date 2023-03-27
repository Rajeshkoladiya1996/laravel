@extends('layouts.admin')
@section('title')
Live User Stream List
@endsection
@section('css')
@endsection
@section('content')

    <div class="main-title">
        <h4>Level Management </h4>
        <div id="level-point-btn">
            <a href="javascript:void(0)" class="btn btn-pink btn-header-pink" id="add-level">Add Level</a>
        </div>
    </div>
    <nav>
        <div class="nav nav-tabs my-nav active" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active tab-listing toggle-btn" id="levelList-tab" data-toggle="tab" href="#levelList" role="tab" aria-controls="levelList" aria-selected="false">Level</a>
          <a class="nav-item nav-link tab-listing toggle-btn" id="points-tab" data-toggle="tab" href="#pointsList" role="tab" aria-controls="points" aria-selected="true">Level Points</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">    
        <div class="tab-pane fade show active levelList" id="levelList" role="tabpanel" aria-labelledby="levelList-tab">
            @include('admin.level.levelList')
        </div>
        <div class="tab-pane fade levelPointList" id="pointsList" role="tabpanel" aria-labelledby="points-tab">
            @include('admin.level.levelPointList')
        </div>
    </div>
@endsection
@section('js')
<!-- Modal Delete  -->
<div class="modal fade" id="level-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                    <h5>Delete Level</h5>
                    <p>Are you sure you want to delete this Level.</p>
                    <input type="hidden" name="del_id" id="del_id">
                    <input type="hidden" name="type" id="type">
                    <div class="block-btn">
                        <a href="javascript:void(0)" class="btn btn-black delete" data-id="yes" data-type="">Yes</a>
                        <a href="javascript:void(0)" class="btn btn-red  delete" data-dismiss="modal" aria-label="Close" data-id="no">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start Add level Model  -->
<div class="modal fade" id="level-add-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                    <h5>Add Level</h5>
                    <form name="form_level" id="form_level" action="POST" autocomplete="off" >
                        <div class="login-input no-icon">
                          <input type="text" placeholder="Name" class="pr-3" name="level_name" id="level_name">
                          <span id="err-level_name" class="error"></span>
                        </div>
                        <div class="login-input no-icon">
                          <input type="text" placeholder="Description" class="pr-3" name="description" id="description" autocomplete="false">
                        </div>
                        <span id="err-description" class="error"></span>
                        
                        <div class="login-input no-icon">
                          <input type="text" placeholder="Total Points" name="points" id="points" class="pr-3" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                          <span id="err-points" class="error"></span>
                        </div>
                        
                        <button type="submit" id="level-add" class="btn btn-black">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Add level Model  -->

<!-- Start Update level Model  -->
<div class="modal fade" id="level-update-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                    <h5>Update Level</h5>
                    <form name="form_edit_level" id="form_edit_level" action="POST" autocomplete="off" >
                        <input type="hidden" name="id" id="edit_id"/>
                        <div class="login-input no-icon">
                          <input type="text" placeholder="Name" class="pr-3" name="level_name" id="edit_level_name">
                          <span id="err-edit_level_name" class="error"></span>
                        </div>
                        <div class="login-input no-icon">
                          <input type="text" placeholder="Description" class="pr-3" name="description" id="edit_description" autocomplete="false">
                        </div>
                        <span id="err-edit_description" class="error"></span>
                        <div class="login-input no-icon">
                          <input type="text" placeholder="Total Points" name="points" id="edit_points" class="pr-3" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                          <span id="err-edit_points" class="error"></span>
                        </div>
                        <button type="submit" class="btn btn-black" id="edit_level_button">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Update level Model  -->

<!-- Start Change Status Model -->
<div class="modal fade" id="level-status-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body p-0">
        <div class="block-modal">
          <h5>Change Level Status</h5>
          <p>Are you sure you want to Change Status of this Level.</p>
          <input type="hidden" name="level_id" id="level_id">
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

<div class="modal fade" id="levelPoint-status-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body p-0">
        <div class="block-modal">
          <h5>Change Level-Point Status</h5>
          <p>Are you sure you want to Change Status of this Level-Point.</p>
          <input type="hidden" name="levelpoint_id" id="levelpoint_id">
          <input type="hidden" name="levelpoint_status" id="levelpoint_status">
          <div class="block-btn">
            <a href="javascript:void(0)" class="btn btn-black changeLevelPoint" data-id="yes">Yes</a>
            <a href="javascript:void(0)" class="btn btn-red changeLevelPoint" data-id="no">No</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Change Status Model -->

<script type="text/javascript">

//delete level
$('body').on('click', '#deleteLevel', function(e) {
    let id = $(this).attr('data-id');
    $("#type").val($(this).attr('data-type'));
    $('#level-delete').modal('show');
    $('#del_id').val(id);
});

$('body').on('click','.toggle-btn',function(e){
    const id = $(this).attr('id');
    if(id == "points-tab"){
        let link = `<a href="{{route('admin.level.point.create')}}" class="btn btn-pink btn-header-pink">Add Level Point</a>`;
        $('#level-point-btn').html(link);
    }else{
        let link = `<a href="javascript:void(0)" class="btn btn-pink btn-header-pink" id="add-level">Add Level</a>`;
        $('#level-point-btn').html(link);
    }
})

$('.delete').on('click', function(e) {
    let confim = $(this).attr('data-id');
    let type = $('#type').val();
    let id = $('#del_id').val();
    let url = "";

    if(type == "levelpoint"){
        url = "{{route('admin.level.point.delete')}}";
    }
    else if (type == "level"){
        url = "{{route('admin.level.delete')}}";
    }

    if (confim == "yes") {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'POST',
            data: {
                id: id
            },
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success: function(data) {
                $('#del_' + id).remove();
                $('#level-delete').modal('hide');
                toastr.success('Level point delete successfully.')
            },
            error: function(error) {
                console.log(error);
            }
        });
    }else{
        $('#level-delete').modal('hide');
    }
})

// Start Level Code

$("#form_level").validate({
    rules :{
        level_name:{
            required: true,
            minlength:2,  
            remote:{
                url:"{{route('admin.level.checkName')}}",
                method:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },   
        },  
        description:{
            required: true,
        },
        points:{
            required:true,
            
        },                  
    },
    messages:{
        level_name:{
            remote:"Name already taken."
        },
    },
});

$("#form_edit_level").validate({
    rules :{
        level_name:{
            required: true,
            minlength:2,     
        },  
        description:{
            required: true,
        },
        points:{
            required:true,
        },                  
    },
});



$('body').on('click','#add-level',function(e){
    $('#level_name-error').text("");
    $('#description-error').text("");
    $('#points-error').text("");
    $('#level-add-model').modal('show');
    $('#level-add').prop("disabled", false);
})

$('body').on('submit','#form_level',function(e){
    e.preventDefault();
    $('#level-add').prop("disabled", true);
    if($("#form_level").valid()){
        var fd = new FormData(this);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{route('admin.level.store')}}",
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
                    $('#level-add-model').modal('hide');
                    toastr.success('Level Added successfully.')
                    levelList();
                    $('#level_name').val("");
                    $('#description').val("");
                    $('#points').val("");   
                }else{
                    $('#level-add').prop("disabled", false);
                    console.log(data);
                }
            },error:function(error){
                $('#level-add').prop("disabled", false);
                console.log(error);
                for (err in error.responseJSON.errors){
                    $('#err-'+err).text(error.responseJSON.errors[err][0]);
                }
            }
	    });
    }else{
        $('#level-add').prop("disabled", false);
    }
})  

$('body').on('click','#editLevel',function(e){
    $('#edit_level_button').prop("disabled", false);
    const id = $(this).attr('data-id');
    $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{URL::to('godmode/level/edit/')}}"+"/"+id,
            method:'GET',
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success:function(data){
                if(data != null){
                    $('#edit_level_name').val(data.name);
                    $('#edit_description').val(data.description);
                    $('#edit_points').val(data.total_point);
                    $('#edit_id').val(data.id);
                    $('#level-update-model').modal('show');
                }
            },error:function(error){
            }
	    });
})


$('body').on('submit','#form_edit_level',function(e){
    e.preventDefault();
    $('#edit_level_button').prop("disabled", true);
    if($("#form_edit_level").valid()){
        var fd = new FormData(this);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{route('admin.level.update')}}",
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
                    $('#level-update-model').modal('hide');
                    toastr.success('Level Update successfully.')
                    levelList();
                }else{
                    $('#edit_level_button').prop("disabled", false);
                    console.log(data);
                }
            },error:function(error){
                $('#edit_level_button').prop("disabled", false);
                console.log(error);
                for (err in error.responseJSON.errors){
                    $('#err-'+err).text(error.responseJSON.errors[err][0]);
                }
            }
	    });
    }
})

$('body').on('keyup','#points',function(e){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:"{{route('admin.level.checkPoint')}}",
        method:'POST',
        data:{points:$('#points').val()},
        success:function(data){
            if(data != 0){
                $('#err-points').text('Please enter higher point greater than ' + data.total_point);
            }else{
                $('#err-points').text('');
            }
        },error:function(error){
        }
	});
})

$('body').on('keyup','#edit_points',function(e){
    const id = $('#edit_id').val();
    const points = $(this).val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:"{{route('admin.level.checkPoint')}}",
        method:'POST',
        data:{id:id,points:points},
        success:function(data){
            console.log(data);
            if(data != 0){
                $('#err-edit_points').text(data);
            }else{
                $('#err-edit_points').text('');
            }
        },error:function(error){
        }
	});
})

$('body').on('click','.level-status',function(){
    $('#level_id').val($(this).attr('data-id'));
    $('#status').val($(this).attr('data-status'));
    $('#level-status-model').modal('show');
});
$('body').on('click','.change',function(){
    let status = $('#status').val();
    let confim=$(this).attr('data-id');
    let id=$('#level_id').val();
        if(confim=="yes"){
            console.log("yes");  
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ route('admin.level.changeStatus') }}",
                method:'POST',
                data:{id:id,status:status},
                beforeSend: function() {
                    // $("#loading-image").show();
                },
                success:function(data){
                    if(data == 1){
                        $('#level-status-model').modal('hide');
                        levelList();
                    }else{
                        console.log(data);
                    }
                },error:function(error){
                }
            });
        }else{
            $('#level-status-model').modal('hide');
        }
});

// End Level Code

$('body').on('click','.level-point-status',function(){
    $('#levelpoint_id').val($(this).attr('data-id'));
    $('#levelpoint_status').val($(this).attr('data-status'));
    $('#levelPoint-status-model').modal('show');
});
$('body').on('click','.changeLevelPoint',function(){
    let status = $('#levelpoint_status').val();
    let confim=$(this).attr('data-id');
    let id=$('#levelpoint_id').val();
        if(confim=="yes"){
            console.log("yes");  
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ route('admin.level.point.changeStatus') }}",
                method:'POST',
                data:{id:id,status:status},
                beforeSend: function() {
                    // $("#loading-image").show();
                },
                success:function(data){
                    if(data == 1){
                        $('#levelPoint-status-model').modal('hide');
                        levelPointList();
                    }else{
                        console.log(data);
                    }
                },error:function(error){
                }
            });
        }else{
            $('#levelPoint-status-model').modal('hide');
        }
});

// levelList
function levelList() {
    $.ajax({
        url: "{{route('admin.level.list')}}",
        method: 'GET',
        beforeSend: function() {
            // $("#loading-image").show();
        },
        success: function(data) {
            $('#levelList').html(data);
            $('#example').DataTable();
        },
        error: function(error) {
            console.log(error);
        }
    });
}

// levepointlList
function levelPointList() {
    $.ajax({
        url: "{{route('admin.level.point.list')}}",
        method: 'GET',
        beforeSend: function() {
            // $("#loading-image").show();
        },
        success: function(data) {
            $('#pointsList').html(data);
            $('#example2').DataTable();
        },
        error: function(error) {
            console.log(error);
        }
    });
}
</script>
@endsection