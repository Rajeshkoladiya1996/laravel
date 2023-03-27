@if($streamlistbattel!='')
    @forelse($streamlistbattel as $key => $value)
        <div class="live-stream-imgBox">
            <a href="javascript:void(0)" class="live-stream-item" data-id="{{@$value['stream_id']}}" data-type="battles">
                <div class="pk-host-list-item">
                    @if(@$value['profile_pic']!="")
                        <div class="pk-multi-host-img">
                            <img src="{{@$value['profile_pic']}}" alt="">
                             <div class="live-stream-info">
                                <p><i class="fas fa-eye"></i><span id="{{@$value['stream_id']}}_view">{{@$value['webRTCViewerCount']}}</span></p>
                                <h5>{{$value['username']}}</h5>
                            </div>
                        </div>
                        <div class="pk-multi-host-img">
                            <img src="{{@$value['to_profile_pic']}}" alt="">
                             <div class="live-stream-info">
                                <h5>{{$value['to_username']}}</h5>
                            </div>
                        </div>   
                    @else
                        <img src="{{URL::to('storage/app/public/uploads/users/default.png')}}" alt="">        
                    @endif
                    <span class="live-tag">LIVE</span>
                    <i class="image-vs-image">VS</i>
                    <!-- <span class="gift-tag"><img src="{{URL::to('storage/app/public/Adminassets/image/gift.svg')}}" alt=""> 169</span> -->
                </div>
            </a>
        </div>
        @empty
    @endforelse
@endif