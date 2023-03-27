@if ($streamlist != '')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        
        var localTracks = {
            videoTrack: null,
            audioTrack: null
        };
        var remoteUsers = {};
        
    </script>
    @forelse($streamlist as $key => $value)
        <div class="live-stream-imgBox col-">
            <a href="javascript:void(0)" class="live-stream-item" data-id="{{ @$value['stream_id'] }}" data-type="solo"
                data-name="{{ $value['username'] }}" data-time="{{ $value['startTime'] }}">
                <div class="live-stream-item">
                   <!--  @if (@$value['profile_pic'] != '')
                        <img src="{{ @$value['profile_pic'] }}" alt="" id="{{ @$value['stream_id'] }}_profile">
                    @else
                        <img src="{{ URL::to('storage/app/public/uploads/users/default.png') }}" alt=""
                            id="{{ @$value['stream_id'] }}_profile">
                    @endif -->
                    <div id="live-video-player-{{$key}}" class="live-video-player">
                            
                    </div>
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
            var client{{$key}} = AgoraRTC.createClient({ mode: "live", codec: "vp8" });
            var stream_id{{$key}} ="{{ @$value['stream_id'] }}"; 
            var id{{$key}} ="{{$key}}"; 

            var stream_token ="{{ @$value['stream_token'] }}"; 
            // Agora client options
            var options = {
                appid: 'e5574359857246129815648c6b279095',
                channel:stream_id{{$key}},
                uid: null,
                token: stream_token,
                role: "audience" // host or audience
            };
            join1(id{{$key}});
            // view video admin site 
            async function join1(temp_id) {
                // create Agora client
                await client{{$key}}.setClientRole(options.role);
                if (options.role === "audience") {

                    // add event listener to play remote tracks when remote user publishs.
                    await  client{{$key}}.on("user-published", handleUserPublished{{$key}});
                    await client{{$key}}.on("user-unpublished", handleUserUnpublished{{$key}});
                }

                // join the channel
                options.uid = await  client{{$key}}.join(options.appid, options.channel, options.token || null);

                if (options.role === "host") {
                    // create local audio and video tracks
                    localTracks.audioTrack = await  AgoraRTC.createMicrophoneAudioTrack();
                    localTracks.videoTrack = await   AgoraRTC.createCameraVideoTrack();
                    // play local video track
                    localTracks.videoTrack.play("local-player");
                    $("#local-player-name-"+temp_id).text(`localTrack(${options.uid})`);
                    // publish local tracks to channel
                    await  client{{$key}}.publish(Object.values(localTracks));
                    // console.log("publish success");
                }
            }


            // async function subscribe(user, mediaType) {
                // console.log({user,mediaType});
                // const uid = user.uid;
                // subscribe to a remote user
                // await client{{$key}}.subscribe(user, mediaType);
                // if (mediaType === 'video') {
                //     const player = $(`<div id="player-wrapper-${uid}">
                //             <div id="player-${uid}" class="player"></div>
                //         </div> `);
                //     $("#live-video-player-"+stream_id{{$key}}).append(player);
                //     user.videoTrack.play(`player-${uid}`);

                // }
                // if (mediaType === 'audio') {
                //     user.audioTrack.play();
                // }
            // }
            const handleUserPublished{{$key}} = async (user, mediaType) =>{
                const id = user.uid;
                const uid = user.uid;
                remoteUsers[id] = user;
               
                await client{{$key}}.subscribe(user, mediaType);
                const player = $(`<div id="player-wrapper-${uid}">
                            <div id="cctv-${uid}" class="cctv-view"></div>
                        </div> `);
               
                $("#live-video-player-"+id{{$key}}).append(player);
                setTimeout(async() => { 
                     await user.videoTrack.play(`cctv-${uid}`);
                }, 2000);
        }

        const  handleUserUnpublished{{$key}} = async (user)=> {
            const id = user.uid;
            delete remoteUsers[id];
            $(`#player-wrapper-${id}`).remove();
        }
            
        const leave{{$value['id']}}= async()=> {
            for (trackName in localTracks) {
                var track = localTracks[trackName];
                if (track) {
                    track.stop();
                    track.close();
                    localTracks[trackName] = undefined;
                }
            }

            // remove remote users and player views
            remoteUsers = {};
            $("#live-video-player-"+id{{$key}}).html("");
            await client{{$key}}.leave();
            
        }

        </script>
        <script type="text/javascript">

                var stream_start_time = "{{ $value['startTime'] }}";
                var timestamp = parseInt(stream_start_time) * 1000;
                console.log("Nikunj=====>"+new Date(timestamp).toTimeString());
                console.log("Nikunj=====>"+new Date(timestamp).toLocaleTimeString());

                var timestamp1 =  new Date(timestamp).toLocaleTimeString();
                console.log("Nikunj timestamp1 =====>"+timestamp1);
                var current_time = new Date().toLocaleTimeString();
                console.log("Nikunj 1 =====>"+current_time);
                var difftime = moment.utc(moment(current_time,"HH:mm:ss").diff(moment(timestamp1,"HH:mm:ss"))).format("HH:mm:ss");
                console.log("Nikunj difftime =====>"+difftime);
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
    @php @endphp
    @empty
    @endforelse
    
    
@endif


