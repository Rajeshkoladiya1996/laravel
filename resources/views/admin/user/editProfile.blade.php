@extends('layouts.admin')
@section('title')
    Edit User Details
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
	<div class="main-title">
	  	<h4>Edit Profile</h4>
	</div>
	<div class="profile-white-box">

		<form action="{{route('admin.user.update')}}" method="post" id="edit-profile" enctype="multipart/form-data">
	        <div class="row">
				<div class="col-lg-2">
				<div class="avatar-upload">
					<div class="avatar-edit ">
						<input type='file' name="image" id="eimageUpload" accept=".png, .jpg, .jpeg, .gif" />
						<label for="imageUpload"></label>
					</div>
					<div class="avatar-preview ">
						<div>
							@if(!filter_var($userDetail->profile_pic, FILTER_VALIDATE_URL))
								<img id="imagePreview" src="{{URL::to('storage/app/public/uploads/users/'.$userDetail->profile_pic)}}">
							@else
								<img id="imagePreview" src="{{$userDetail->profile_pic}}">
							@endif
						</div>
					</div>
				</div>
				</div>
				<div class="col-lg-8 row avatar-upload">
					@if($userProfile!=NUll)
						@foreach($userProfile as $value)
								<div class="avatar-preview col-lg-4">
									<div>
									@if(!filter_var($value->image, FILTER_VALIDATE_URL))
										<img id="imagePreview" src="{{URL::to('storage/app/public/uploads/users/'.$value->image)}}">
									@else
										<img id="imagePreview" src="{{$value->image}}">
									@endif
									</div>
								</div>
						@endforeach
					@endif
				</div>
			</div>
	        <div class="row">
			    <div class="col-lg-3">
			      <div class="profile-input">
			        <label>Name</label>
			        <input type="text" placeholder="User Name" name="username" id="username" value="{{$userDetail->username}}">
			        <input type="hidden" name="id" id="id" value="{{$userDetail->id}}">
			      </div>
			    </div>
			    <div class="col-lg-3">
			      <div class="profile-input">
			        <label>Email</label>
			        <input type="email" placeholder="John Doe" id="email" name="email" value="{{$userDetail->email}}" readonly>
			      </div>
			    </div>
			    <div class="col-lg-3">
			      <div class="profile-input">
			        <label>Mobile Number</label>
			        <input type="text" placeholder="23456789" id="phone" name="phone" value="{{$userDetail->phone}}">
			      </div>
			    </div>
				<div class="col-lg-3">
					<div class="profile-input">
						<label>Gender</label>
						  <input type="radio" id="male" name="gender" style="width: 8%;margin-right: 4%;" value="0" @if($userDetail->gender==0) checked @endif>Male
						  <input type="radio" id="female" name="gender" style="width: 8%;margin-right: 4%;" value="1" @if($userDetail->gender==1) checked @endif>Female
						  <input type="radio" id="others" name="gender" style="width: 8%;margin-right: 4%;" value="2" @if($userDetail->gender==2) checked @endif>Others
					</div>
				</div>
				<div class="col-lg-3">
					<div class="profile-input">
						<label>City</label>
						<input type="text" placeholder="Enter City" name="city" value="{{$userDetail->city}}">
					</div>
				</div>
				<div class="col-lg-3">
					<div class="profile-input multi-select-wrapper">
						<label>Tags</label>
						<select class="js-example-basic-multiple" multiple="multiple" name="tags[]">
						@if($userTag->isEmpty())
							@foreach($tags as $key => $value)
								<option value="{{$value->id}}">{{$value->name}}</option>
							@endforeach
						@else
							@php ($tag = [])
							@foreach($userTag as $key => $value)
								@php ($tag[] = $value->tag_id)
							@endforeach
							@foreach($tags as $key => $value)
								<option value="{{$value->id}}" @if(in_array($value->id, $tag)) selected @endif>{{$value->name}}</option>
							@endforeach
						@endif
						</select>

					</div>
				</div>		  		
	  		</div>
			  <button class="btn btn-black mt-4" type="submit">Update</button>
	  	</form>
	</div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
	 $('.js-example-basic-multiple').select2();
	$("#edit-profile").validate({
	    rules: {
	        username: {
	            
	        },
	        email: {
	            
	        },
	        phone: {
	            
	        },
	       
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
	            url: "{{route('admin.user.update')}}",
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

</script>
@endsection