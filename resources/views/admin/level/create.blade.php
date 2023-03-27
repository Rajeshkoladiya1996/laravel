@extends('layouts.admin')
@section('title')
@if(isset($levelDetail)) Edit @else Add @endif Level Point
@endsection
@section('css')
@endsection
@section('content')
<form action="@if(isset($levelDetail)){{route('admin.level.point.update')}}@else{{route('admin.level.point.store')}}@endif" class="points-form" method="post">
@csrf
    <h4>@if(isset($levelDetail)) Edit @else Add @endif Level Point</h4>

    {{-- <h6>Level Description</h6> --}}
    {{-- <div class="level-desc mb-4">

        <div class="row">
            <div class="col-6 d-flex align-items-end">
            	@if(isset($levelDetail))<input type="hidden" name="id" id="id" value="{{$levelDetail->id}}">@endif
                <div class="login-input">
                    <input type="text" placeholder="Enter Name" name="name" id="name" @if(isset($levelDetail))value="{{$levelDetail->name}}"@endif autocomplete="false">
                </div>
            </div>
            <div class="col-6">
                <div class="login-input d-flex align-items-end">
                    <textarea name="description" placeholder="Enter Description" id="description" rows="3">@if(isset($levelDetail)){{$levelDetail->description}}@endif</textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="login-input">
                    <input type="text" placeholder="Total Points" name="total_point" id="total_point" autocomplete="false" @if(isset($levelDetail))value="{{$levelDetail->total_point}}"@endif>
                </div>
            </div>
        </div>
    </div> --}}

    <h6>
        Level Points
    </h6>
    <div class="level-info">
    	@if(isset($levelDetail))
    		{{-- @foreach($levelDetail->level_detail as $key => $data) --}}
		        <div class="level-info-item" id="del_{{$levelDetail->id}}">

					<div class="td-desc">
		                <div class="login-input">
		                    <select name="level_detail[category][]" id="category" required>
								<option value="">Select Category</option>
								@foreach ($category as $data)
									<option value="{{$data}}" {{$data === $levelDetail->category ? 'selected' :''}}>{{ Str::ucfirst($data) }}</option>
								@endforeach
							</select>
		                </div>
		            </div>
					
		            <div class="td-name">
		            	<input type="hidden" name="level_detail[id][]" id="level_detail_id" value="{{$levelDetail->id}}">
		                <div class="login-input">
		                    <input type="text" placeholder="Name" name="level_detail[name][]" id="name" autocomplete="false" value="{{$levelDetail->name}}" required>
		                </div>
		            </div>

		            <div class="td-desc">
		                <div class="login-input">
		                    <input type="text" placeholder="Description" name="level_detail[description][]" id="description" autocomplete="false" value="{{$levelDetail->description}}" required>
		                </div>
		            </div>

		            <div class="td-points">
		                <div class="login-input">
		                    <input type="text" placeholder="Points" name="level_detail[point][]" id="pointslevel_detail[point][]" autocomplete="false" value="{{$levelDetail->points}}" required>
		                </div>
		            </div>

					<div class="td-points">
		                <div class="login-input">
		                    <input type="text" placeholder="Per day limit" name="level_detail[per_day][]" id="per_day" autocomplete="false" value="{{$levelDetail->per_day}}" required>
		                </div>
		            </div>

		        </div>
	        {{-- @endforeach --}}
        @else
	        <div class="level-info-item">

				<div class="td-desc">
					<div class="login-input">
						<select name="level_detail[category][]" id="category" required>
							<option value="">Select Category</option>
							@foreach ($category as $data)
									<option value="{{$data}}">{{ Str::ucfirst($data) }}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="td-name">
						<div class="login-input">
							<input type="text" placeholder="Name" name="level_detail[name][]" id="name" autocomplete="false" required>
						</div>
					</div>

					<div class="td-desc">
						<div class="login-input">
							<input type="text" placeholder="Description" name="level_detail[description][]" id="description" autocomplete="false" required>
						</div>
					</div>

					<div class="td-points">
						<div class="login-input">
							<input type="text" placeholder="Points" name="level_detail[point][]" id="point" autocomplete="false" required>
						</div>
					</div>

					<div class="td-points">
		                <div class="login-input">
		                    <input type="text" placeholder="Per day limit" name="level_detail[per_day][]" id="per_day" autocomplete="false" required>
		                </div>
		            </div>

	            <div class="td-plus add">
	                <i class="fal fa-plus-circle duplicate-btn"></i>
	            </div>
	        </div>
	    @endif
	    <div id="view_point_fields">
	    	
	    </div>    
        <button class="btn btn-pink btn-header-pink" type="submit">
            Submit
        </button>
    </div>
</form>
@endsection
@section('js')
<div class="modal fade" id="level-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                    <h5>Delete Level point</h5>
                    <p>Are you sure you want to delete this Level point.</p>
                    <input type="hidden" name="del_id" id="del_id">
                    <div class="block-btn">
                        <a href="javascript:void(0)" class="btn btn-black delete" data-id="yes" data-isdelete="">Yes</a>
                        <a href="javascript:void(0)" class="btn btn-red  delete" data-id="no">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	let $i = 0;
	$('body').on('click','.add',function() {
		$i++;
		if($i<10){
			let str=`<div class="level-info-item" id="del_`+$i+`">
			
					<div class="td-desc">
		                <div class="login-input">
		                    <select name="level_detail[category][]" id="category" required>
								<option value="">Select Category</option>
								@foreach ($category as $data)
									<option value="{{$data}}">{{ Str::ucfirst($data) }}</option>
								@endforeach
							</select>
		                </div>
		            </div>
				
		           <div class="td-name">
		                <div class="login-input">
		                    <input type="text" placeholder="Name" name="level_detail[name][]" id="name" autocomplete="false" required>
		                </div>
		            </div>

		            <div class="td-desc">
		                <div class="login-input">
		                    <input type="text" placeholder="Description" name="level_detail[description][]" id="description" autocomplete="false" required>
		                </div>
		            </div>

					

		            <div class="td-points">
		                <div class="login-input">
		                    <input type="text" placeholder="Points" name="level_detail[point][]" id="pointslevel_detail[point][]" autocomplete="false" required>
		                </div>
		            </div>	

					<div class="td-points">
		                <div class="login-input">
		                    <input type="text" placeholder="Per day limit" name="level_detail[per_day][]" id="per_day" autocomplete="false" required>
		                </div>
		            </div>

		            <div class="td-plus remove" data-id="`+$i+`" data-isdelete="false">
	            	    <i class="fal fa-trash delete-btn"></i>
	            	</div>
		        </div>`;
			$('#view_point_fields').append(str);
		}
	});

	$('body').on('click','.remove',function(){
		
		let id=$(this).data('id');
		$('.delete').attr('data-isdelete',$(this).data('isdelete'));
		$('#level-delete').modal('show');
		$('#del_id').val(id);		
	});
	
	$('body').on('click','.delete', function(e) {
		
	    let confim = $(this).data('id');
	    let id = $('#del_id').val();
	    if (confim == "yes") {
	    	if($(this).data('isdelete')==true){
			        	$('#level-delete').modal('hide');
						$('#del_'+id).remove();
						toastr.success('Level point delete successfully.');
		        // $.ajax({
		        //     headers: {
		        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        //     },
		        //     url:"",
			       //  type:'POST',
			       //  data:{'id':id},
			       //  success:function(response){
			       //  },
		        //     error: function(error) {
		        //         console.log(error);
		        //     }
		        // });
		    }else{
		    	$('#level-delete').modal('hide');
				$('#del_'+id).remove();
				toastr.success('Level point delete successfully.')
			}
			$i--;
	    }else{
	    	$('#level-delete').modal('hide');
	    }
	})
</script>
@endsection