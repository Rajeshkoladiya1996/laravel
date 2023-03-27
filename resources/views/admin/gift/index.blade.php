@extends('layouts.admin')
@section('title')
Gift List
@endsection
@section('css')
@endsection
@section('content')
<div class="main-title">
	<h4>Gift Management</h4>
	<a href="javascript:void(0)" class="btn btn-pink btn-header-pink" data-toggle="modal" data-target="#upload-category-modal" id="upload-category-modal_id"> + Add Category</a>
</div>
<div id="giftList">
	{{-- @include('admin.gift.giftList')	--}}
</div>

@endsection
@section('js')
{{-- Start Add gift Model --}}
<div class="modal fade" id="upload-box-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered upload-gift-modal" role="document">
		<div class="modal-content">
			<button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
				<img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
			</button>
			<div class="modal-body modal-body2">
				<h5 class="text-center modal-heading">Add gift</h5>
				<form name="gift_form" id="gift_form" method="post" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="gift_catgeory_id" id="gift_catgeory_id">
					<input type="hidden" name="gift_type" id="gift_type">
					<div class="gift-input">
						<label for="gift-upload_data" class="gift-label">
							<input type="file" id="gift-upload_data" class="up-image" name="image" data-id="add" accept="image/gif, application/json">
							<div class="upload-box upload-box2">
								<span>
									<div id="json_preview"></div>
									<img class="preview-img preview-img_gif" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt="">
									<video class="preview-video" id="preview-video" src="" controls></video>
								</span>
								<h6>Upload Gift</h6>
							</div>
						</label>
						<span class="error" id="err-image"></span>
					</div>
					<div class="gift-input bk-file-wrap">
						<input type="file" placeholder="choose mp3" name="audio" id="bkAudio" accept=".wav" class="bk-file-input">
						<label for="bkAudio" class="bk-file-label">Browse Audio Files</label>
						<span class="error" id="err-audio"></span>
						<audio controls src="" id="audio_file">
							Your browser does not support the
							<code>audio</code> element.
						</audio>
					</div>
					<div class="gift-input">
						<input type="text" placeholder="Enter Sticker name" name="name" id="name" onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.which != 32)  return false;">
						<span class="error" id="err-name"></span>
					</div>
					<div class="gift-input">
						<input type="text" placeholder="00" name="gems" id="gems" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9)  return false;">
						<img src="{{URL::to('storage/app/public/Adminassets/image/diamond.svg')}}" class="assign-input-logo diamond-icon" alt="">
						<span class="error" id="err-name"></span>
					</div>
					<button type="submit" class="btn btn-pink" id="upload">Save</button>
				</form>
			</div>
		</div>
	</div>
</div>
{{--End add gift Model --}}

{{-- Start Edit gift Model --}}
<div class="modal fade" id="upload-box-modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
				<img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
			</button>
			<div class="modal-body modal-body2">
				<h5 class="text-center modal-heading">Edit gift</h5>
				<form name="gift_form_edit" id="gift_form_edit" method="post" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="gift_catgeory_id" id="egift_catgeory_id">
					<input type="hidden" name="gift_type" id="egift_type">
					<input type="hidden" name="id" id="id">
					<div class="gift-input">
						<label for="gift-upload-edit" class="gift-label edit">
							<input type="file" id="gift-upload-edit" class="up-image" name="image_edit"  accept="image/gif, application/json">
							{{-- accept="image/gif, image/json" --}}
							<div class="upload-box upload-box2">
								<span>
									<div id="json_preview_edit"></div>
									<img class="preview-img-edit" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt="">
									<video class="preview-video-edit" id="preview-video-edit" src="" controls></video>
								</span>

								<h6>Upload Gift</h6>
							</div>
						</label>
						<span class="error" id="error-image_edit"></span>
					</div>
					<div class="gift-input bk-file-wrap">
						<input type="file" placeholder="choose mp3" name="audio" id="eaudio" accept=".wav" class="bk-file-input">
						<label for="eaudio" class="bk-file-label">Browse Audio Files</label>
						<span class="error" id="error-audio"></span>
						<audio controls src="" id="eaudio_file">
							Your browser does not support the
							<code>audio</code> element.
						</audio>
					</div>
					<div class="gift-input">
						<input type="text" placeholder="Enter Sticker name" name="name" id="names" onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.which != 32)  return false;">
						<span class="error" id="error-name"></span>
					</div>
					<div class="gift-input">
						<input type="text" placeholder="00" name="gems" id="gemss" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;" class="mb-0">
						<img src="{{URL::to('storage/app/public/Adminassets/image/diamond.svg')}}" class="assign-input-logo diamond-icon" alt="">
						<span class="error" id="error-gems"></span>
					</div>
					<button type="submit" class="btn btn-pink" id="update">Update</button>
				</form>
			</div>
		</div>
	</div>
</div>
{{--End edit gift Model --}}

{{-- Start Add gift Category Model --}}
<div class="modal fade gift-category-modal" id="upload-category-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered upload-gift-modal" role="document">
		<div class="modal-content">
			<button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
				<img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
			</button>
			<div class="modal-body modal-body2">
				<h5 class="text-center modal-heading">Add Category</h5>
				<form name="category_form" id="category_form" method="post">
					@csrf
					<div class="gift-input">
						<input type="text" placeholder="Enter Category name" name="category_name" id="category_name" onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.which != 32)  return false;">
						<span class="error" id="err-category_name"></span>
					</div>
					<button type="submit" class="btn btn-pink" id="category_button">Save</button>
				</form>
			</div>
		</div>
	</div>
</div>
{{--End Add gift Category Model --}}

{{-- Start Update gift Category Model --}}
<div class="modal fade gift-category-modal" id="edit-category-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered upload-gift-modal" role="document">
		<div class="modal-content">
			<button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
				<img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
			</button>
			<div class="modal-body modal-body2">
				<h5 class="text-center modal-heading">Edit Category</h5>
				<form name="edit_category_form" id="edit_category_form" method="post">
					<input type="hidden" name="hid" value="" id="hid" />
					@csrf
					<div class="gift-input">
						<input type="text" placeholder="Enter Category name" name="category_name" id="edit_category_name" onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.which != 32) return false;">
						<span class="error" id="error-category_name"></span>
					</div>
					<button type="submit" class="btn btn-pink" id="category_edit_button">Update</button>
				</form>
			</div>
		</div>
	</div>
</div>
{{--End Update gift Category Model --}}


<!-- Gift category delete confirmation model -->
<div class="modal fade" id="delete-gift-category-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
				<img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
			</button>
			<div class="modal-body p-0">
				<input type="hidden" name="hid" id="del_id">
				<div class="block-modal">
					<h5 id="gift-categort-id">Gift Category Delete</h5>
					<p id="msg">Are you sure you want to delete this gift category.</p>
					<div class="block-btn">
						<a href="javascript:void(0)" id="is-delete-gift-category" class="btn btn-black">Yes</a>
						<a href="javascript:void(0)" class="btn btn-red" data-dismiss="modal">No</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="gift-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body p-0">
        <div class="block-modal">
          <h5>Delete Gift</h5>
          <p>Are you sure you want to delete this Gift.</p>
          <input type="hidden" name="gift_id" id="gift_id">
          <div class="block-btn">
            <a href="javascript:void(0)" class="btn btn-black delete" id="is-delete-gift" data-id="yes">Yes</a>
            <a href="javascript:void(0)" class="btn btn-red " data-id="no" data-dismiss="modal">No</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	giftList();
	$('.preview-video').hide();
	$('#audio_file').css('display', 'none');
	$("#gift-upload_data").change(function() {
		readURLgif(this);
	});
	$("#bkAudio").change(function() {
		readURLAudio(this);
	});
	$("#eaudio").change(function() {
		readURLAudioEdit(this);
	});
	$("#gift-upload-edit").change(function() {
		readURLEdit(this);
	});

	$("#upload-category-modal_id").click(function(){
		$("#err-category_name").text("");
		$("#category_name-error").text("");
		$('#category_button').prop("disabled", false);
	});

	function readURLAudio(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			// console.log(input.files[0]);
			const type = input.files[0].type.split('/');
			// console.log(type);
			$('#err-audio').text("");
			$('#eaudio_file').html("");
			
			if (type[0] == 'audio') {
				reader.onload = function(e) {
					console.log(e.target.result);
					$('#eaudio_file').attr('src', e.target.result);
				}
				$('#eaudio_file').css('display', 'block');
				if(type[1]!='wav'){
					$('#err-audio').text("The audio must be a file of type: .wav.");	
				}
			} 
			else {
				$('#err-audio').text("The audio must be a file of type: .wav.");
				toastr.error('Invalid File input.')
				return false;
			}
			reader.readAsDataURL(input.files[0]);

		}
	};
	function readURLAudioEdit(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			// console.log(input.files[0]);
			const type = input.files[0].type.split('/');
			// console.log(type);
			$('#error-audio').text("");
			$('#audio_file').html("");
			
			if (type[0] == 'audio') {
				reader.onload = function(e) {
					console.log(type[1]);
					$('#audio_file').attr('src', e.target.result);
				}
				$('#audio_file').css('display', 'block');
				if(type[1]!='wav'){
					$('#error-audio').text("The audio must be a file of type: .wav.");	
				}
			} 
			else {
				
				$('#error-audio').text("The audio must be a file of type: .wav.");
				toastr.error('Invalid File input.')
				return false;
			}
			reader.readAsDataURL(input.files[0]);

		}
	};
	function readURLgif(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			// console.log(input.files[0]);
			const type = input.files[0].type.split('/');
			// console.log(type);
			$('#err-image').text("");
			$('#json_preview').html("");
			if (type[0] == 'image') {
				reader.onload = function(e) {
						$('.preview-img_gif').attr('src', e.target.result);
					}
					$('#gift_type').val('image');
					$('.preview-img_gif').show();
					$('.preview-video').hide();
					$('#err-image').text("");
				if(type[1]=='gif' || type[1]=="json"){
					// reader.onload = function(e) {
					// 	$('.preview-img_gif').attr('src', e.target.result);
					// }
					// $('#gift_type').val('image');
					// $('.preview-img_gif').show();
					// $('.preview-video').hide();
				}else{
					// toastr.error('Invalid File input.');
					$('#err-image').text("The image must be a file of type: gif, json.");
				}
			}else if (type[1] == 'json') {
				reader.onload = function(e) {
					$('.preview-img_gif').attr('src', e.target.result).css('opacity','0');
					var amination = bodymovin.loadAnimation({
				        container:document.getElementById('json_preview'),
				        renderer:'svg',
				        loop: true,
				        autoplay: true,
				        path:e.target.result
				    });
				}
				$('#gift_type').val('json');
				$('.preview-img_gif').show();
				$('.preview-video').hide();
			} 
			// else if (type[0] == 'video') {
			// 	reader.onload = function(e) {
			// 		$('.preview-video').attr('src', e.target.result);
			// 	}
			// 	$('#gift_type').val('video');
			// 	$('.preview-video').show();
			// 	$('.preview-img_gif').hide();
			// } else if (type[0] == 'audio') {
			// 	reader.onload = function(e) {
			// 		$('#audio_file').attr('src', e.target.result);
			// 	}
			// 	$('#audio_file').css('display', 'block');
			// } 
			else {
				$('#err-image').text("The image must be a file of type: gif, json.");
				toastr.error('Invalid File input.')
				return false;
			}
			reader.readAsDataURL(input.files[0]);

		}
	};

	function readURLEdit(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			
			reader.onload = function(e) {
				$('.preview-img-edit').attr('src', e.target.result);
			}
			const type = input.files[0].type.split('/');
			console.log(type);
			$('#error-image_edit').text("");
			if (type[0] == 'image') {
				if(type[1]=='gif' || type[1]=="json"){
					$('#json_preview_edit').html('');
					reader.onload = function(e) {
						$('.preview-img-edit').attr('src', e.target.result);
					}
					$('#egift_type').val('image');
					$('.preview-img-edit').show();
					$('.preview-video-edit').hide();
				}else{
					// toastr.error('Invalid File input.');
					$('#error-image_edit').text("The image edit must be a file of type: gif, json.");
				}
				
			}
			else if (type[1] == 'json') {
				$('#json_preview_edit').html('');

				reader.onload = function(e) {
					var amination = bodymovin.loadAnimation({
				        container:document.getElementById('json_preview_edit'),
				        renderer:'svg',
				        loop: true,
				        autoplay: true,
				        path:e.target.result
				    });
				    $('.preview-img-edit').attr('src', e.target.result).css('opacity','0');
				}
				$('#egift_type').val('json');
				$('.preview-video-edit').hide();
			} 
			// else if (type[0] == 'video') {
			// 	$('#json_preview_edit').html('');
			// 	reader.onload = function(e) {
			// 		$('.preview-video').attr('src', e.target.result);
			// 	}
			// 	$('#egift_type').val('video');
			// 	$('.preview-video-edit').show();
			// 	$('.preview-img-edit').hide();
			// } 
			else {
				$('#error-image_edit').text("The image edit must be a file of type: gif, json.");
				toastr.error('Invalid File input.')
				return false;
			}

			reader.readAsDataURL(input.files[0]);
		}
	};

	jQuery.validator.addMethod("noSpace", function(value, element) {
		return value.indexOf(" ") < 0 && value != "";
	}, "No space please and don't leave it empty");
 
  	jQuery.validator.addMethod("alphanumeric", function(value, element) {
    	return this.optional(element) || /^[\w.]+$/i.test(value);
	}, "Letters, numbers, and underscores only please");


	$("#gift_form").validate({
		rules: {
			name: {
				required: true,
				minlength: 2,
				noSpace: false,
				alphanumeric:true,
				remote: {
					url: "{{route('admin.gift.giftCheckName')}}",
					method: "POST",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				},
			},
			gems: {
				required: true,
				alphanumeric:true,
			},
			image: {
				required: true,
			},
		},
		messages: {
			name: {
				remote: "The name has already been taken."
			}
		},
	});

	$('body').on('click', '.upload-gift', function(e) {
		$('#gift_catgeory_id').val($(this).attr('data-id'));
		$('#upload-box-modal').modal('show');
		$('#upload').prop("disabled", false);
	})

	//save 
	$('#gift_form').on('submit', function(e) {
		e.preventDefault();
		$('#upload').prop("disabled", true);
		if ($("#gift_form").valid()) {
			var fd = new FormData(this);
			const type = $('#gift_type').val();
			if (type == 'image' || type == 'json') {
				fd.append('images', $('.preview-img_gif').attr('src'));
			} else {
				fd.append('images', $('.preview-video').attr('src'));
			}

			// console.log($('.preview-img').attr('src'));
			// $('#upload').prop('disabled', true);
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "{{route('admin.gift.store')}}",
				method: 'POST',
				data: fd,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$("#loading-image").show();
				},
				success: function(data) {
					// $("#loading-image").hide();
					$('.preview-img').attr('src', "{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");
					$('#json_preview').html('');
					// $('#upload').prop('disabled', false);
					$('#gift_form')[0].reset();
					toastr.success('Gift added successfully.');
					$('.modal').modal('hide');
					giftList();

				},
				error: function(errors) {
					$('#upload').prop("disabled", false);
					for(error in errors.responseJSON.errors){
                    	$('#err-'+error).text(errors.responseJSON.errors[error]);
                	}
					// console.log(error);
				}
			});
			return false;
		}else{
			$('#upload').prop("disabled", false);
		}
	});
	
	$("#gift_form_edit").validate({
		rules: {
			name: {
				required: true,
				minlength: 2,
				noSpace: false,
				alphanumeric:true
			},
			gems: {
				required: true,
				alphanumeric:true
			},
		},
		messages: {

		},
	});
	
	//update
	$('#gift_form_edit').on('submit', function(e) {
		e.preventDefault();
		$('#update').prop("disabled", true);
		// $this->validate($request, ['image_edit' => 'image|mimes:gif',]);
		if ($("#gift_form_edit").valid()) {

			var fd = new FormData(this);
			fd.append('images', $('.preview-img-edit').attr('src'));
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "{{route('admin.gift.update')}}",
				method: 'POST',
				data: fd,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					//   $("#loading-image").show();
				},
				success: function(data) {
					// $("#loading-image").hide();
					$('.preview-img').attr('src', "{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");
					
					$('#gift_form')[0].reset();
					$('#json_preview_edit').html('');
					toastr.success('Gift updated successfully.');
					$('.modal').modal('hide');
					giftList();

				},
				error: function(errors) {
					$('#update').removeAttr('disabled');
					$('#update').prop("disabled", false);
					for(error in errors.responseJSON.errors){
                    	$('#err-'+error).text(errors.responseJSON.errors[error]);
                	}
				}
			});
			return false;
		}else{
			$('#update').prop("disabled", false);
		}
	});

	$('body').on('click', '#edit', function(e) {
		$('#update').prop("disabled", false);
		let id = $(this).attr('data-id');
		$('#eaudio_file').css('display', 'none');
		$('.error').text("");
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "{{URL::to('godmode/gift/edit/')}}" + "/" + id,
			method: 'GET',
			beforeSend: function() {},
			success: function(data) {
				$('#json_preview_edit').html('');
				if (data.audio && data.audio != null) {
					$('#eaudio_file').css('display', 'block');
					$('#eaudio_file').attr('src', "{{URL::to('storage/app/public/uploads/gift')}}" + "/" + data.audio);
				}
				$('#names').val(data.name);
				$('#gemss').val(data.gems);
				$('#egift_catgeory_id').val(data.gift_category_id);
				$('#egift_type').val(data.type);
				$('#id').val(data.id);

				if (data.type == "image") {
					$('#json_preview_edit').hide();
					$('.preview-img-edit').attr('src', "{{URL::to('storage/app/public/uploads/gift')}}" + "/" + data.image);
					$('.preview-video-edit').hide();
					$('.preview-img-edit').show();

				} 
				if (data.type == "json") {
					$('.preview-img-edit').hide();
					$('.preview-video-edit').hide();	
				    $('#json_preview_edit').show();
					var amination = bodymovin.loadAnimation({
				        container:document.getElementById('json_preview_edit'),
				        renderer:'svg',
				        loop: true,
				        autoplay: true,
				        path:"{{URL::to('storage/app/public/uploads/gift')}}" + "/" + data.image
				    });
				}
				if (data.type == "video") {
					$('#json_preview_edit').hide();
					$('.preview-video-edit').show();
					$('.preview-img-edit').hide();
					$('.preview-video-edit').attr('src', "{{URL::to('storage/app/public/uploads/gift')}}" + "/" + data.image);
				}
				$('#upload-box-modal-edit').modal('show');
			},
			error: function(error) {}
		});
	});

	function giftList() {
		$.ajax({
			url: "{{route('admin.gift.list')}}",
			method: 'GET',
			beforeSend: function() {
				// $("#loading-image").show();
			},
			success: function(data) {
				// $("#loading-image").hide();
				$('#giftList').html(data);
			},
			error: function(error) {
				console.log(error);
			}
		});
	}

	// start Add Gift Category
	$("#category_form").validate({
		rules: {
			category_name: {
				required: true,
				noSpace: false,
			},
		},
	});

	$("#edit_category_form").validate({
		rules: {
			category_name: {
				required: true,
				noSpace: false,
			},
		},
	});

	$('body').on('submit', '#category_form', function(e) {
		e.preventDefault();
		$('#category_button').prop("disabled", true);
		if ($("#category_form").valid()) {
			var fd = new FormData(this);
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "{{route('admin.gift.category.store')}}",
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
						toastr.success('Gift category added successfully.')
					} else {
						$('#category_button').prop("disabled", false);
						toastr.error('Something went wrong.')
					}
					$('#category_form')[0].reset();
					$('#upload-category-modal').modal('hide');
					giftList();
				},
				error: function(errors) {
					$('#category_button').prop("disabled", false);
					for(error in errors.responseJSON.errors){
                    	$('#err-'+error).text(errors.responseJSON.errors[error]);
                	}
				}
			});
		}else{
			$('#category_button').prop("disabled", false);
		}
	});
	// end Add Gift Category

	// Edit Gift Category
	$('body').on('click', '#edit-gift-category', function(e) {
		$('#category_edit_button').prop("disabled", false);
		$('#edit_category_name-error').text("");
		const id = $(this).attr('data-id');
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "{{URL::to('godmode/gift/category/edit')}}" + "/" + id,
			method: 'GET',
			beforeSend: function() {},
			success: function(data) {
				$('#edit-category-modal').modal('show');
				$('#edit_category_name').val(data.name);
				$("#error-category_name").text("");
				$('#hid').val(data.id);
			},
			error: function(error) {}
		});
	});


	// update Gift Category
	$('#edit_category_form').on('submit', function(e) {
		e.preventDefault();
		$('#category_edit_button').prop("disabled", true);
		if ($("#edit_category_form").valid()) {
			var fd = new FormData(this);
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "{{route('admin.gift.category.update')}}",
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
						toastr.success('Gift category update successfully.');
					} else {
						$('#category_edit_button').prop("disabled", false);
						toastr.error('Something went wrong.');
					}
					$('#edit_category_form')[0].reset();
					$('#edit-category-modal').modal('hide');
					giftList();
				},
				error: function(errors) {
					$('#category_edit_button').prop("disabled", false);
					for(error in errors.responseJSON.errors){
                    	$('#error-'+error).text(errors.responseJSON.errors[error]);
                	}
				}
			});
		}else{
			$('#category_edit_button').prop("disabled", false);
		}
	});

	// delete gift category confim pop open
	$('body').on('click', '#delete-gift-category', function(e) {
		$('#delete-gift-category-model').modal('show');
		$('#del_id').val($(this).attr('data-id'));
	});

	// delete gift category
	$('body').on('click', '#is-delete-gift-category', function(e) {
		// alert("delete");
		let id = $('#del_id').val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "{{route('admin.gift.category.delete')}}",
			method: 'POST',
			data: {
				id: id
			},
			beforeSend: function() {},
			success: function(data) {
				$('#delete-gift-category-model').modal('hide');
				toastr.success('Gift Category delete successfully.');
				giftList();
			},
			error: function(error) {
				console.log(error);
			}
		});
	});

	// delete gift confim pop open
	$('body').on('click', '#delete', function(e) {
		$('#gift-delete').modal('show');
		$('#gift_id').val($(this).attr('data-id'));
	});
	// delete gift category
	$('body').on('click', '#is-delete-gift', function(e) {
		let id = $('#gift_id').val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "{{route('admin.gift.delete')}}",
			method: 'POST',
			data: {
				id: id
			},
			beforeSend: function() {},
			success: function(data) {
				$('#del_' + id).remove();
				$('#gift-delete').modal('hide');
			},
			error: function(error) {}
		});
	});
</script>
@endsection