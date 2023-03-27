@extends('layouts.admin')
@section('title')
    Tags
@endsection
@section('css')
@endsection
@section('content')

    <div class="main-title">
        <h4 id="title">Tags</h4>
        <div id="level-point-btn">
            <a href="javascript:void(0)" class="btn btn-pink btn-header-pink add-tag-model"> + Add Tag</a>
        </div>
    </div>
    <div id="tagList"></div>


@endsection
@section('js')

    <div class="modal fade" id="add-tag-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                    <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
                </button>
                <div class="modal-body password-modal py-5 px-2 p-md-5">
                    <div class="password-moda">
                        <h5 class="text-center">Add Tag </h5>
                        <form id="addTag" type="post" class="gems-assign-form mt-4 mb-0">
                            <div class="assign-input login-input">
                                <input type="text" name="tagname" id="tagname" placeholder="Enter tag name" onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode != 32) return false;"/>
                            </div>
                            <span class="error" id="err-tagname"></span>
                            <div class="assign-input login-input">
                                <input type="color" name="color" id="color" placeholder="Enter Color"  onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode !=35) return false;"/>
                            </div>
                            <span class="error" id="err-color"></span>
                            <input type="submit" class="btn btn-black" value="Save" id="addTag_button" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-tag-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                    <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
                </button>
                <div class="modal-body password-modal py-5 px-2 p-md-5">
                    <div class="password-moda">
                        <h5 class="text-center">Update Tag </h5>
                        <form id="editTag-from" type="post" class="gems-assign-form mt-4 mb-0">
                            <input type="hidden" name="id" id="hid">
                            <div class="assign-input login-input">
                                <input type="text" name="name" id="ename" placeholder="Enter tag name" onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode != 32) return false;"/>
                            </div>
                            <span class="error" id="error-name"></span>
                            <div class="assign-input login-input">
                                <input type="color" name="color" id="ecolor" placeholder="Enter Color" onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode !=35) return false;"/>
                            </div>
                            <span class="error" id="error-color"></span>
                            <input type="submit" class="btn btn-black" value="Update" id="editTag_button" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="app-production-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                    <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
                </button>
                <div class="modal-body p-0">
                    <input type="hidden" name="hid" id="id">
                    <input type="hidden" name="status" id="pidstatus">
                    <div class="block-modal">
                        <h5 id="title_user_paid">Production Mode </h5>
                        <p id="msg"></p>
                        <div class="block-btn">
                            <a href="javascript:void(0)" id="app_production" class="btn btn-black">Yes</a>
                            <a href="javascript:void(0)" class="btn btn-red" data-dismiss="modal">No</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tag-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                <h5>Delete Event</h5>
                <p>Are you sure you want to delete this Tag.</p>
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
    <div class="modal fade" id="tag-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                <h5>Change Status</h5>
                <p>Are you sure you want to change status of this Livestream.</p>
                <input type="hidden" name="tag_id" id="tag_id">
                <div class="block-btn">
                    <a href="javascript:void(0)" class="btn btn-black change" data-id="yes">Yes</a>
                    <a href="javascript:void(0)" class="btn btn-red change" data-id="no">No</a>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        getTagsList();
        function getTagsList(){
            $.ajax({
                url: "{{route('admin.tags.list')}}",
                method: 'GET',
                beforeSend: function() {
                    // $("#loading-image").show();
                },
                success: function(data) {
                    // $("#loading-image").hide();
                    $('#tagList').html(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        $('body').on('click', '.add-tag-model', function() {
            $('#name-error').text("");
            $('#err-color').text("");
            $('#add-tag-modal').modal('show');
            $('#addTag_button').prop("disabled", false);
        });

        $("#addTag").validate({
            rules: {
                tagname: {
                    required: true,
                },
            },
        });

        $('#addTag').on('submit', function(e) {
            e.preventDefault();
            $('#addTag_button').prop("disabled", true);
            var fd = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{route('admin.tags.store')}}",
                data: fd,
                processData: false,
                contentType: false,
                success:function(data){
                    // $(':input','#addTag')
                    // .not(':button, :submit, :reset, :hidden')
                    // .val('');
                    if(data=='1'){
                        toastr.success('Tag added successfully.');
                        getTagsList();
                        
                        $('#add-tag-modal').modal('hide');
                    }
                    else{
                        $('#addTag_button').prop("disabled", false);
                       toastr.error('something went wrong.');
                       $('#add-tag-modal').modal('hide');
                    }
                },
                error: function(errors) {
                    $('#addTag_button').prop("disabled", false);
					for(error in errors.responseJSON.errors){
                        console.log('#err-'+error+':'+errors.responseJSON.errors[error]);
                    	$('#err-'+error).text(errors.responseJSON.errors[error]);
                        
                	}
					// console.log(error);
				}
            });
            
        });

        $("#editTag-from").validate({
            rules: {
                ename: {
                    required: true,
                },
                ecolor:{
                    required: true,
                },
            },
        });

        $('#editTag-from').on('submit', function(e) {
            e.preventDefault();
            $('#editTag_button').prop("disabled", true);
            var fd = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{route('admin.tags.update')}}",
                data: fd,
                processData: false,
                contentType: false,
                success:function(data){
                    if(data=='1'){
                       toastr.success('Tag updated successfully.');
                       getTagsList();
                        
                        $(':input','#editTag-from')
                        .not(':button, :submit, :reset, :hidden')
                        .val('');

                        $('#error-name').text("");
                        $('#error-color').text("");
                       $('#edit-tag-modal').modal('hide');
                    }
                    else{
                        $('#editTag_button').prop("disabled", false);
                       toastr.error('something went wrong.');
                       $('#edit-tag-modal').modal('hide');
                    }
                },
                error: function(errors) {
                    $('#editTag_button').prop("disabled", false);
					for(error in errors.responseJSON.errors){
                        console.log('#error-'+error);
                    	$('#error-'+error).text(errors.responseJSON.errors[error]);
                	}
					// console.log(error);
				}
            });
        });


        $('body').on('click', '.editTag', function() {
            $('#editTag_button').prop("disabled", false);
            let id = $(this).attr('data-id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{URL::to('godmode/tags/edit/')}}" + "/" + id,
                method: 'GET',
                beforeSend: function() {},
                success: function(data) {
                    $('#hid').val(data.id);
                    $('#ename').val(data.name);
                    $('#ecolor').val(data.color);
                    $('#error-name').text("");
                    $('#error-color').text("");
                   $('#edit-tag-modal').modal('show');
                },
                error: function(error) {}
            });
        });

        $('body').on('click','.check_status',function(){
            $('#tag_id').val($(this).attr('data-id'));
            $('#tag-status').modal('show');
        });
        $('.change').on('click',function (e) {
            let confim=$(this).attr('data-id');
            let id=$('#tag_id').val();
            if(confim=="yes"){
                console.log("yes");        
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{route('admin.tags.changeStatus')}}",
                    method:'POST',
                    data:{id:id},
                    beforeSend: function() {
                    // $("#loading-image").show();
                    },
                    success:function(data){
                        if(data == 1){
                            $('#tag-status').modal('hide');
                            getTagsList();
                        }
                    },error:function(error){
                        console.log(error);             
                    }
                });
            }else{
                $('#tag-status').modal('hide');
            }
        });

        $('body').on('click','#deleteTag',function(){
            $('#del_id').val($(this).attr('data-id'));
            $('#type').val($(this).attr('data-type'));
            $('#tag-delete').modal('show');
        });

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
                    url:"{{route('admin.tags.delete')}}",
                    method:'POST',
                    data:{id:id},
                    beforeSend: function() {
                    // $("#loading-image").show();
                    },
                    success:function(data){
                        if(data == 1){
                            $('#tag-delete').modal('hide');
                            getTagsList();
                        }
                    },error:function(error){
                        console.log(error);             
                    }
                });
            }else{
                $('#tag-delete').modal('hide');
            }
        });
    </script>
@endsection

