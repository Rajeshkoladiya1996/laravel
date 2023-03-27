@if ($streamlist != '')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js" type="text/javascript"></script>
    @forelse($streamlist as $key => $value)
        <div class="live-stream-imgBox">
            <a href="javascript:void(0)" class="live-stream-item" data-id="{{ @$value['stream_id'] }}" data-type="solo"
                data-name="{{ $value['username'] }}">
                <div class="live-stream-item">
                    @if (@$value['profile_pic'] != '')
                        <img src="{{ @$value['profile_pic'] }}" alt="" id="{{ @$value['stream_id'] }}_profile">
                    @else
                        <img src="{{ URL::to('storage/app/public/uploads/users/default.png') }}" alt=""
                            id="{{ @$value['stream_id'] }}_profile">
                    @endif
                    <span class="live-tag">LIVE</span>
                    <span class="live-time" id="live-time-display-{{$key}}">00:00:00</span>
                    <!-- <span class="gift-tag"><img src="{{ URL::to('storage/app/public/Adminassets/image/gift.svg') }}" alt=""> 169</span> -->
                    <div class="live-stream-info d-flex">
                        <h5>{{ $value['username'] }}</h5>
                        <p class="pl-2"><i class="fas fa-eye mr-1"></i><span
                                class="{{ @$value['stream_id'] }}_view"
                                id="{{ @$value['stream_id'] }}_view">{{ @$value['webRTCViewerCount'] }}</span></p>
                    </div>
                </div>
            </a>
        </div>
            <script type="text/javascript">

                var stream_start_time = "{{ $value['startTime'] }}";
                var timestamp = parseInt(stream_start_time) * 1000;

                var timestamp1 =  new Date(timestamp).toLocaleTimeString();
                var current_time = new Date().toLocaleTimeString();

                var difftime = moment.utc(moment(current_time,"HH:mm:ss").diff(moment(timestamp1,"HH:mm:ss"))).format("HH:mm:ss");

                let hms{{$key}} = difftime;
                let [hr{{$key}}, min{{$key}}, sec{{$key}}] = hms{{$key}}.split(':');
                const increaseTime{{$key}} = ()=> {
                    sec{{$key}} = parseInt(sec{{$key}});
                    min{{$key}} = parseInt(min{{$key}});
                    hr{{$key}} = parseInt(hr{{$key}});

                    sec{{$key}} = sec{{$key}} + 1;

                    if (sec{{$key}} == 60) {
                        min{{$key}} = min{{$key}} + 1;
                        sec{{$key}} = 0;
                    }
                    if (min{{$key}} == 60) {
                        hr{{$key}} = hr{{$key}} + 1;
                        min{{$key}} = 0;
                        sec{{$key}} = 0;
                    }

                    if (sec{{$key}} < 10 || sec{{$key}} == 0) {
                        sec{{$key}} = '0' + sec{{$key}};
                    }
                    if (min{{$key}} < 10 || min{{$key}} == 0) {
                        min{{$key}} = '0' + min{{$key}};
                    }
                    if (hr{{$key}} < 10 || hr{{$key}} == 0) {
                        hr{{$key}} = '0' + hr{{$key}};
                    }
                    var timer = hr{{$key}} +':'+min{{$key}}+':'+sec{{$key}};
                    $("#live-time-display-{{$key}}").text(timer);
                }
                setInterval(increaseTime{{$key}},1000);
            </script>
    @empty
    @endforelse
@endif
