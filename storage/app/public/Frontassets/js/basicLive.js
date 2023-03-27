// create Agora client
var client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });
var localTracks = {
    videoTrack: null,
    audioTrack: null
};
var remoteUsers = {};
// Agora client options
var options = {
    appid: 'e5574359857246129815648c6b279095',
    channel: null,
    uid: null,
    token: null,
    role: "audience" // host or audience
};

// Join video call as audience (solo and battles)
$('body').on('click', '.live-stream-item', async function (e) {
    e.preventDefault();
    $("#host-join").attr("disabled", true);
    $("#audience-join").attr("disabled", true);
    $('#live-video-player').html();
    try {
        let stream_id = $(this).data('id');
        let type = $(this).data('type');
        $("#user_name").text($(this).data('name'));
        $('.total_user_count').addClass(stream_id + '_view');
        $('.total_chat_count').addClass(stream_id +'_total_chat_count');
        $('.chat_list').attr('id',stream_id +'_chat_list');


        if (type === 'solo') {
            $('#pk_battel').css('display','none');
            $('.profile_pic').attr('src',$('#'+stream_id+'_profile').attr('src'));
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: server_url,
                data: { stream_id: stream_id },
                success: async function (response) {
                    options.appid = options.appid;
                    options.token = response.stream_token;
                    options.channel = response.stream_id;
                    // call join audiance user
                    $('.user-video-show').removeClass("multi-video-show");
                    var Viewer = $('#' + options.channel + '_view').text();
                    $('#video_username').text(response.username);
                    $('#video_viewer').text(Viewer);
                    join();
                    $('#live-modal').modal('show');
                    $('#live-modal').attr('data-id', stream_id);
                    setTimeout(() => {
                        $('#live-modal').data('id', stream_id);
                    }, 100);
                },
                error: function (error) {
                    console.log(error);
                }
            });

        } else {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: battles_url,
                data: { stream_id: stream_id },
                success: async function (response) {
                    options.appid = options.appid;
                    options.token = response.from_user_token;
                    options.channel = response.stream_id;

                    console.log(response.stream_id, '_________', response.from_user_token);
                    // call join audiance user
                    var Viewer = $('#' + options.channel + '_view').text();
                    var battle_user = response.from_user.username + '   Vs  ' + response.to_user.username;
                    $('#user_name').text(response.from_user.username);
                    $('#user_name2').text(response.to_user.username);
                    $('#video_viewer').text(Viewer);
                    $('#pk_battel').css('display', 'block');

                    join();
                    $('#live-modal').modal('show');
                    $('.user-video-show').addClass("multi-video-show");
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        if (options.role === "host") {
            $("#success-alert a").attr("href", `index.html?appid=${options.appid}&channel=${options.channel}&token=${options.token}`);
            if (options.token) {
                $("#success-alert-with-token").css("display", "block");
            } else {
                $("#success-alert a").attr("href", `index.html?appid=${options.appid}&channel=${options.channel}&token=${options.token}`);
                $("#success-alert").css("display", "block");
            }
        }
    } catch (error) {
        console.error(error);
    } finally {
        $("#leave").attr("disabled", false);
    }
});

$(".close-icon").click(function (e) {
    leave();
})

// view video admin site 
function join() {
    // create Agora client
    client.setClientRole(options.role);
    if (options.role === "audience") {

        // add event listener to play remote tracks when remote user publishs.
        client.on("user-published", handleUserPublished);
        client.on("user-unpublished", handleUserUnpublished);
    }

    // join the channel
    options.uid = client.join(options.appid, options.channel, options.token || null);

    if (options.role === "host") {
        // create local audio and video tracks
        localTracks.audioTrack = AgoraRTC.createMicrophoneAudioTrack();
        localTracks.videoTrack = AgoraRTC.createCameraVideoTrack();
        // play local video track
        localTracks.videoTrack.play("local-player");
        $("#local-player-name").text(`localTrack(${options.uid})`);
        // publish local tracks to channel
        client.publish(Object.values(localTracks));
        console.log("publish success");
    }
}

async function leave() {
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
    $("#live-video-player").html("");
    $("#chat_list").html("");
    // $(".player").html(""); 

    // leave the channel
    await client.leave();
    $("#local-player-name").text("");
    $("#host-join").attr("disabled", false);
    $("#audience-join").attr("disabled", false);

    $("#leave").attr("disabled", true);
    $('#live-modal').modal('hide');
}

async function subscribe(user, mediaType) {
    const uid = user.uid;
    // subscribe to a remote user
    await client.subscribe(user, mediaType);
    if (mediaType === 'video') {
        const player = $(`<div id="player-wrapper-${uid}">
                <div id="player-${uid}" class="player"></div>
            </div> `);
        $("#live-video-player").append(player);
        user.videoTrack.play(`player-${uid}`);

    }
    if (mediaType === 'audio') {
        user.audioTrack.play();
    }
}

function handleUserPublished(user, mediaType) {
    const id = user.uid;
    remoteUsers[id] = user;

    subscribe(user, mediaType);
}

function handleUserUnpublished(user) {
    const id = user.uid;
    delete remoteUsers[id];
    $(`#player-wrapper-${id}`).remove();
}