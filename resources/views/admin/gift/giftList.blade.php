
@foreach($giftList as $data)
<div>
    <div class="d-flex">
        <div class="gift-category-title">{{$data->name}}</div> 
        <a href="javascript:void(0)" class="gift-category-edit ml-4" id="edit-gift-category" data-id="{{$data->id}}" title="Edit">
            <i class="fas fa-pen-square"></i>
        </a>
        <a href="javascript:void(0)" class="gift-category-delete ml-2" id="delete-gift-category" data-id="{{$data->id}}" title="Delete">
            <i class="fas fa-trash-alt"></i>
        </a>
    </div>  
    <div class="gift-upload-wrap">
        <div class="gift-upload-item">
            <a href="javascript:void(0)" class="upload-box upload-gift" title="Upload Gift" data-id="{{$data->id}}">
                <span><img src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                <h6>Upload Gift</h6>
            </a>
        </div>
        @foreach($data->gift as $gdata)
        <div class="gift-upload-item" id="del_{{$gdata->id}}">
            <div class="upload-preview">
                <span class="edits" data-id="{{$gdata->id}}">
                    @if($gdata->type == 'image')
                        <img src="{{URL::to('storage/app/public/uploads/gift/'.$gdata->image)}}" alt="">
                    @elseif($gdata->type == 'json')
                        <div id="json_preview_{{$gdata->id}}"></div>
                        <script type="text/javascript">
                            var amination = bodymovin.loadAnimation({
                                container:document.getElementById('json_preview_{{$gdata->id}}'),
                                renderer:'svg',
                                loop: true,
                                autoplay: true,
                                path:"{{URL::to('storage/app/public/uploads/gift/'.$gdata->image)}}"      
                            });
                    </script>
                    @else
                        <video src="{{URL::to('storage/app/public/uploads/gift/'.$gdata->image)}}" controls preload="none"></video>
                    @endif
                </span>
                <h6>{{$gdata->name}}</h6>
                <p>
                    <span>
                        <img src="{{URL::to('storage/app/public/Adminassets/image/diamond.svg')}}" alt="">
                    </span> {{$gdata->gems}}
                </p>
                <a href="javascript:void(0)" class="edit" id="edit" data-id="{{$gdata->id}}" title="Edit">
                    <i class="fas fa-pen-square"></i>
                </a>
                <a href="javascript:void(0)" class="delete" id="delete" data-id="{{$gdata->id}}" title="Delete">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endforeach