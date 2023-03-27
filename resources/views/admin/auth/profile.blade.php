@extends('layouts.admin')
@section('title')
Live User Stream List
@endsection
@section('css')
@endsection
@section('content')
<div class="main-title">
    <h4>Edit Profile</h4>
</div>
<div class="profile-white-box">

    <form action="{{route('admin.profile')}}" method="post" id="edit-profile" enctype="multipart/form-data">
        <div class="avatar-upload">
            <div class="avatar-edit">
                <input type='file' name="image" id="eimageUpload" accept=".png, .jpg, .jpeg, .gif" />
                <label for="imageUpload"></label>
            </div>
            <div class="avatar-preview">
                <div>
                    <img id="imagePreview"
                        src="{{URL::to('storage/app/public/uploads/users/'.$authdetail->profile_pic)}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="profile-input">
                    <label>Name</label>
                    <input type="text" placeholder="John Doe" name="name" value="{{$authdetail->username}}">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="profile-input">
                    <label>Email</label>
                    <input type="email" placeholder="John Doe" readonly name="email" value="{{$authdetail->email}}">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="profile-input">
                    <label>Mobile Number</label>
                    <input type="text" placeholder="John Doe" name="phone" value="{{$authdetail->phone}}">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="profile-input">
                    <label>Birthdate</label>
                    <input type="date" placeholder="John Doe" id="bod" name="bod" value="{{$authdetail->bod}}">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-black mt-4">Update</button>
    </form>
    <a href="javascript:void(0)" class="btn btn-modal-black" data-toggle="modal" data-target="#changepassowrd">Reset
        Password</a>
</div>
@endsection
@section('js')
<div class="modal fade" id="changepassowrd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body password-modal">
                <div class="password-moda">
                    <h5>Reset Password</h5>
                    <p id="comman_errors" class="comman_errors"></p>
                    <form method="post" name="changepassowrd_from" id="changepassowrd_from" class="mb-0">
                        <div class="login-input">
                            <span>
                                <svg id="door-lock-line_5_" data-name="door-lock-line (5)"
                                    xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25">
                                    <path id="Path_3" data-name="Path 3" d="M0,0H25V25H0Z" fill="none" />
                                    <path id="Path_4" data-name="Path 4"
                                        d="M12.622,23.244A10.622,10.622,0,1,1,23.244,12.622,10.622,10.622,0,0,1,12.622,23.244Zm0-2.124a8.5,8.5,0,1,0-8.5-8.5A8.5,8.5,0,0,0,12.622,21.12ZM11.56,13.463a2.656,2.656,0,1,1,2.124,0v3.408H11.56Z"
                                        transform="translate(-0.122 -0.122)" />
                                </svg>
                            </span>
                            <input id="old_password" type="password" name="old_password" placeholder="Old Password">
                            <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"
                                data-id="old_password"></span>
                            <p class="error" id="error-old_password"></p>

                        </div>
                        <div class="login-input">
                            <span>
                                <svg id="door-lock-line_6_" data-name="door-lock-line (6)"
                                    xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25">
                                    <path id="Path_3" data-name="Path 3" d="M0,0H25V25H0Z" fill="none" />
                                    <path id="Path_4" data-name="Path 4"
                                        d="M12.622,23.244A10.622,10.622,0,1,1,23.244,12.622,10.622,10.622,0,0,1,12.622,23.244Zm0-2.124a8.5,8.5,0,1,0-8.5-8.5A8.5,8.5,0,0,0,12.622,21.12ZM11.56,13.463a2.656,2.656,0,1,1,2.124,0v3.408H11.56Z"
                                        transform="translate(-0.122 -0.122)" />
                                </svg>
                            </span>
                            <input id="new_password" type="password" name="new_password" placeholder="New Password">
                            <span toggle="#password-field2" class="fa fa-fw fa-eye field_icon toggle-password"
                                data-id="new_password"></span>
                            <p class="error" id="error-new_password"></p>
                        </div>
                        <div class="login-input">
                            <span>
                                <svg id="door-lock-line_6_" data-name="door-lock-line (6)"
                                    xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25">
                                    <path id="Path_3" data-name="Path 3" d="M0,0H25V25H0Z" fill="none" />
                                    <path id="Path_4" data-name="Path 4"
                                        d="M12.622,23.244A10.622,10.622,0,1,1,23.244,12.622,10.622,10.622,0,0,1,12.622,23.244Zm0-2.124a8.5,8.5,0,1,0-8.5-8.5A8.5,8.5,0,0,0,12.622,21.12ZM11.56,13.463a2.656,2.656,0,1,1,2.124,0v3.408H11.56Z"
                                        transform="translate(-0.122 -0.122)" />
                                </svg>
                            </span>
                            <input id="confirm_password" type="password" name="confirm_password"
                                placeholder="Confirm Password">
                            <span toggle="#password-field2" class="fa fa-fw fa-eye field_icon toggle-password"
                                data-id="confirm_password"></span>
                            <p class="error" id="error-confirm_password"></p>
                        </div>
                        <button type="submit" class="btn btn-black mt-5">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery.validator.addMethod("noSpace", function(value, element) {
    return value.indexOf(" ") < 0 && value != "";
}, "No space please and don't leave it empty");

$(document).on('click', '.toggle-password', function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    const id = $(this).data('id');
    var input = $('#' + id);
    input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
});

$("#edit-profile").validate({
    rules: {
        name: {
            required: true,
        },
        phone: {
            required: true,
        },
        bod: {
            required: true,
        },
    },
    messages: {
        bod: "please fill Birthdate Field."
    },
});

$("#changepassowrd_from").validate({
    rules: {
        old_password: {
            required: true,
            noSpace: true,
            minlength: 6,
            maxlength: 20,
        },
        new_password: {
            required: true,
            noSpace: true,
            minlength: 6,
            maxlength: 20,
        },
        confirm_password: {
            required: true,
            equalTo: "#new_password",
            noSpace: true,
            minlength: 6,
            maxlength: 20,

        },
    },
    messages: {
        bod: "please fill Birthdate Field."
    },
});


// Update Profile
$('#edit-profile').on('submit', function(e) {
    e.preventDefault();
    if ($("#edit-profile").valid()) {
        var fd = new FormData(this);
        fd.append('images', $('#imagePreview').attr('src'));
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('admin.profile.update')}}",
            method: 'POST',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success: function(data) {
                if(data == 1){
                    toastr.success('Profile update successfully.')
                }else{
                    toastr.error('Something Went Wrong')
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
});

$('#changepassowrd_from').on('submit', function(e) {
    e.preventDefault();
    if ($("#changepassowrd_from").valid()) {
        var fd = new FormData(this);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('admin.profile.changepassowrd')}}",
            method: 'POST',
            data: fd,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success: function(data) {
                if (data == 1) {
                    toastr.success('Password Changed successfully.')
                    $('#changepassowrd').modal('hide');
                }else{
                    $('#comman_errors').text(data);    
                }
            },
            error: function(errors) {
                for (error in errors.responseJSON.errors) {
                    $('#error-' + error).text(errors.responseJSON.errors[error]);
                }
            }
        });
    }
})
</script>




@endsection