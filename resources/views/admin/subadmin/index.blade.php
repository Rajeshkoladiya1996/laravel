@extends('layouts.admin')
@section('title')
Sub Admin List
@endsection
@section('css')
@endsection
@section('content')
<div class="main-title">
  <h4>Sub Admin</h4>
  <p>{{count($userList)}} Sub Admin</p>
</div>
<div id="subadminList">
  @include('admin.subadmin.subadminList')
</div>
@endsection
@section('js')
<div class="modal fade" id="changepassowrd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
      </button>
      <div class="modal-body password-modal">
        <div class="password-moda">
          <h5>Reset Password</h5>
          <form name="resetpassowrd_from" id="resetpassowrd_from">
            <div class="login-input">
              <span>
                <svg id="door-lock-line_6_" data-name="door-lock-line (6)" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25">
                  <path id="Path_3" data-name="Path 3" d="M0,0H25V25H0Z" fill="none" />
                  <path id="Path_4" data-name="Path 4" d="M12.622,23.244A10.622,10.622,0,1,1,23.244,12.622,10.622,10.622,0,0,1,12.622,23.244Zm0-2.124a8.5,8.5,0,1,0-8.5-8.5A8.5,8.5,0,0,0,12.622,21.12ZM11.56,13.463a2.656,2.656,0,1,1,2.124,0v3.408H11.56Z" transform="translate(-0.122 -0.122)" />
                </svg>
              </span>
              <input type="hidden" name="user_id" id="user_id">
              <input type="password" name="password" id="new_password" placeholder="New Password">
              <span toggle="#password-field2" class="fa fa-fw fa-eye field_icon toggle-password" data-id="new_password"></span>
              <span class="file-gen-icon" id="generate_password">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                  <path fill="none" d="M0 0h24v24H0z" />
                  <path fill="#0000004d" class="file-gen" d="M21 8v12.993A1 1 0 0 1 20.007 22H3.993A.993.993 0 0 1 3 21.008V2.992C3 2.455 3.449 2 4.002 2h10.995L21 8zm-2 1h-5V4H5v16h14V9zM8 7h3v2H8V7zm0 4h8v2H8v-2zm0 4h8v2H8v-2z" />
                </svg>
              </span>
            </div>

            <button type="submit" class="btn btn-black">Update Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="subadmin-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
      </button>
      <div class="modal-body password-modal p-5">
        <div class="password-moda">
          <h5 class="text-center mb-4">Edit Sub-Admin</h5>
          <form id="edit_subadmin_form" name="edit_subadmin_form" method="post" enctype="multipart/form-data">
            <div class="avatar-upload mx-auto">
              <div class="avatar-edit">
                <input type='file' name="image" id="eimageUpload" accept=".png, .jpg, .jpeg" />
                <label for="eimageUpload"></label>
               
              </div>
              <div class="avatar-preview">
                <div>
                  <img id="eimagePreview" src="{{URL::to('storage/app/public/uploads/users/default.png')}}">
                </div>
              </div>
               
            </div>
            <span id="error-image" class="error"></span>
            <div class="login-input">
              <span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                  <path fill="none" d="M0 0h24v24H0z" />
                  <path d="M20 22H4v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2zm-8-9a6 6 0 1 1 0-12 6 6 0 0 1 0 12z" />
                </svg>
              </span>
              <input type="text" placeholder="Name" class="pr-3" name="name" id="ename" onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.which != 32) return false;">
              <input type="hidden" name="id" id="id">
            </div>
            <span id="error-name" class="error"></span>
            <div class="login-input">
              <span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                  <path fill="none" d="M0 0h24v24H0z" />
                  <path d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm9.06 8.683L5.648 6.238 4.353 7.762l7.72 6.555 7.581-6.56-1.308-1.513-6.285 5.439z" />
                </svg>
              </span>
              <input type="email" placeholder="Email" class="pr-3" name="email" id="eemail">
            </div>
            <span id="error-email" class="error"></span>
            <div class="login-input">
              <span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                  <path fill="none" d="M0 0h24v24H0z" />
                  <path d="M21 16.42v3.536a1 1 0 0 1-.93.998c-.437.03-.794.046-1.07.046-8.837 0-16-7.163-16-16 0-.276.015-.633.046-1.07A1 1 0 0 1 4.044 3H7.58a.5.5 0 0 1 .498.45c.023.23.044.413.064.552A13.901 13.901 0 0 0 9.35 8.003c.095.2.033.439-.147.567l-2.158 1.542a13.047 13.047 0 0 0 6.844 6.844l1.54-2.154a.462.462 0 0 1 .573-.149 13.901 13.901 0 0 0 4 1.205c.139.02.322.042.55.064a.5.5 0 0 1 .449.498z" />
                </svg>
              </span>
              <input type="text" placeholder="Phone Number" name="phone" id="ephone" class="pr-3" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
            </div>
            <span id="error-phone" class="error"></span>
            <button type="submit" class="btn btn-black" id="update">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="subadmin-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body p-0">
        <div class="block-modal">
          <h5>Delete Sub-Admin</h5>
          <p>Are you sure you want to delete this sub-admin.</p>
          <input type="hidden" name="del_id" id="del_id">
          <div class="block-btn">
            <a href="javascript:void(0)" class="btn btn-black delete" data-id="yes">Yes</a>
            <a href="javascript:void(0)" class="btn btn-red  delete" data-id="no">No</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var streamtable = null;
  $.fn.dataTable.ext.errMode = 'none';
  streamtable = $("#streamTable").DataTable({
    processing: true,
    pageLength: 10,
    aaSorting: [],
    responsive: true,
    serverSide: true,
    ordering: true,
    searching: true,

    "ajax": '{{route("admin.subadmin.list")}}',
    "columns": [{
        "data": "profile_pic"
      },
      {
        "data": "email"
      },
      {
        "data": "phone"
      },
      {
        "data": "actions",
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
  $("#streamTable").DataTable();

  $("#eimageUpload").change(function() {
    ereadURL(this);
  });

  function ereadURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      const type = input.files[0].type.split('/');
        $('#error-image').text("");
        if (type[0] == 'image') {
			    reader.onload = function(e) {
            $('#eimagePreview').attr('src', e.target.result);
          }
					if(type[1]=='jpeg' || type[1]=="png" || type[1]=="jpg"){
					
				}else{
					toastr.error('Invalid File input.');
					$('#error-image').text("The image must be a file of type: jpeg, png, jpg.");
				}
			}else {
				$('#error-image').text("The image must be a file of type: jpeg, png, jpg.");
				toastr.error('Invalid File input.')
				return false;
			}


      reader.readAsDataURL(input.files[0]);
    }
  };
  $('body').on('click', '#editSubadmin', function(e) {
    $('#ename-error').text("");
    $('#eemail-error').text("");
    $('#ephone-error').text("");
    let id = $(this).attr('data-id');
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{URL::to('godmode/subadmin/edit/')}}" + "/" + id,
      method: 'GET',
      beforeSend: function() {},
      success: function(data) {
        $('#subadmin-edit').modal('show');
        $('#ename').val(data.username);
        $('#eemail').val(data.email);
        $('#ephone').val(data.phone);
        $('#id').val(data.id);
        $('#eimagePreview').attr('src', "{{URL::to('storage/app/public/uploads/users')}}" + "/" + data.profile_pic);
      },
      error: function(error) {}
    });
  });

  $('body').on('click', '#deleteSubadmin', function(e) {
    let id = $(this).attr('data-id');
    $('#subadmin-delete').modal('show');
    $('#del_id').val(id);
  });

  $('.delete').on('click', function(e) {
    let confim = $(this).attr('data-id');
    let id = $('#del_id').val();
    if (confim == "yes") {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('admin.subadmin.delete')}}",
        method: 'POST',
        data: {
          id: id
        },
        beforeSend: function() {
          // $("#loading-image").show();
        },
        success: function(data) {
          streamtable.ajax.reload();
          $('#subadmin-delete').modal('hide');
        },
        error: function(error) {
          console.log(error);
        }
      });
    } else {
      $('#subadmin-delete').modal('hide');
    }
  })

  jQuery.validator.addMethod("noSpace", function(value, element) {
    return value.indexOf(" ") < 0 && value != "";
  }, "No space please and don't leave it empty");

  $("#edit_subadmin_form").validate({
    rules: {
      name: {
        required: true,
        minlength: 2,
      },
      email: {
        required: true,
        email: true
      },
      phone: {
        required: true,
        minlength: 10,
        maxlength: 15
      }
    },
    messages: {
      name: {
        remote: "The name has already been taken."
      }
    },
  });
  // 
  $('body').on('submit', '#edit_subadmin_form', function(e) {
    e.preventDefault();
    if ($("#edit_subadmin_form").valid()) {
      var fd = new FormData(this);
      if ($('#eimagePreview').attr('src') != "{{URL::to('storage/app/public/uploads/users/default.png')}}") {
        fd.append('images', $('#eimagePreview').attr('src'));
      }
      // console.log($('.preview-img').attr('src'));
      $('#update').prop('disabled', true);
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('admin.subadmin.update')}}",
        method: 'POST',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
          // $("#loading-image").show();
        },
        success: function(data) {
          // $("#loading-image").hide();
          $('#eimagePreview').attr('src', "{{URL::to('storage/app/public/uploads/users/default.png')}}");
          $('#update').prop('disabled', false);
          $('#edit_subadmin_form')[0].reset();
          $('.modal').modal('hide');
          toastr.success('Sub-Admin updated successfully.');
          streamtable.ajax.reload();

        },
        error: function(errors) {
          $('#update').prop('disabled', false);
          $('.error').text('');
          for (err in errors.responseJSON.errors) {
            $('#error-' + err).text(errors.responseJSON.errors[err]);
          }
        }
      });
      return false;
    }
  });


  $('body').on('click', '.reset_password', function(e) {
    $('#user_id').val($(this).data('id'));
    $('#changepassowrd').modal('show');
  });

  $(document).on('click', '.toggle-password', function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    const id = $(this).data('id');
    var input = $('#' + id);
    input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
  });

  $('#generate_password').on('click', function(e) {
    var length = 8,
      charset = "$&#@!^*()abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
      retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
      retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    $('#new_password').val(retVal);
  });

  $("#resetpassowrd_from").validate({
    rules: {
      password: {
        required: true,
        noSpace: true,
        minlength: 6,
        maxlength: 12,
      },

    },

  });

  $('#resetpassowrd_from').on('submit', function(e) {
    e.preventDefault();
    if ($("#resetpassowrd_from").valid()) {
      var fd = new FormData(this);
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('admin.subadmin.changePassword')}}",
        method: 'POST',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
          // $("#loading-image").show();
        },
        success: function(data) {
          if (data == 1) {
            toastr.success('User change passowrd successfully.');
            $('#changepassowrd').modal('hide');
          } else {
            $('#changepassowrd').modal('hide');
            toastr.error('Something went wrong.');
          }

        },
        error: function(error) {
          console.log(error);

        }
      });
    }
  })
</script>

@endsection