let socket = io("https://bklive.stream:7800/");

socket.on("connect", () => {
	// new_live_stream
	socket.on("new_live_stream", (data) => {
		console.log("new_live_stream");
		streamlist("solo");
	});

	// total_viewer
	socket.on("total_viewer", (data) => {
		console.log("total_viewer");
		console.log(data);
		if (data.totalWebRTCWatchersCount != -1) {
			$("." + data.room_name + "_view").text(data.totalWebRTCWatchersCount);
			$("." + data.room_name + "_total_chat_count").text(data.total_chat);
			$("#total_games_count1").text(data.total_gems);
		}
	});
	// pk_total_viewer
	socket.on("pk_total_viewer", (data) => {
		console.log("pk_total_viewer");
		console.log(data);
		if (data.totalWebRTCWatchersCount != -1) {
			$("#" + data.room_name + "_view").text(data.totalWebRTCWatchersCount);
		}
	});
	// pk_join
	socket.on("pk_join", (data) => {
		console.log("pk_join");
		console.log(data);
	});
	// pk_battle_ready
	socket.on("pk_battle_ready", (data) => {
		streamlist("battle");
	});

	socket.on("pk_list", (data) => {
		console.log("pk_list", data);
		streamlist("battle");
	});

	socket.on("new_live_stream_web", (data) => {
		console.log("new_live_stream_web", data);
		let id = $("#live-modal").attr("data-id");

		if (id != undefined && data.room_name == id) {
			leave();
			$("#live-modal").modal("hide");
		}
		setTimeout(() => {
			streamlist("battle");
		}, 100);
	});

	socket.on("user_stream_request", (data) => {
		console.log("user_stream_request", data);
		if (streamtable !== undefined) {
			streamtable.ajax.reload();
		}
	});

	socket.on("top_supporters", (data) => {
		console.log("top_supporters");
		console.log(data);
		$("#total_games_count1").text(data.total_gems);
	});

	socket.on("chat", (data) => {
		console.log("chat");
		console.log(data);
		// $('#total_chat_count').text(data.total_message_count);
		$("." + data.room_name + "_total_chat_count").text(
			data.total_message_count
		);
		if (data.type != "send_like") {
			let chat_list = `
                    <div class="live-single-comment-box">
                                <div class="commentor-profile-image">
                                    <img src="${data.profile}" alt="user-profile">
                                </div>
                                <div class="comment-content-wrapper">
                                    <div class="comment-top-content">
                                        <div class="user-level-badge">Lv.${data.level_id}</div>
                                        <div class="user-commentor-name">${data.userName}</div>
                                        `;
			if (data.type != "send_message") {
				chat_list += `<div class="user-sticker">
                        <img src="${data.gift_image}" alt="user-sticker">
                    </div>`;
				$(".bk-live-emoji-img").attr("src", data.gift_image);
			}
			chat_list += `</div>
            <div class="comment-bottom-content">
            <p>${
							data.type == "send_message" ? data.message : "Sent a gift to Nack"
						}</p>
            </div>
            </div>
            </div>`;
			// $('.'+ data.room_name +'_live-comments-block').append(chat_list);
			$(".bk-live-emoji-img").addClass("bk-live-emoji-img-show");
			if (data.type != "send_message") {
				$("#" + data.room_name + "_chat_list").append(chat_list);
				setTimeout(function () {
					$(".bk-live-emoji-img").removeClass("bk-live-emoji-img-show");
				}, 5000);
			}
			// $('#chat_list').append(chat_list);
		}
		var myDiv = document.getElementsByClassName("chat_list")[0];
		console.log(myDiv.scrollHeight);
		myDiv.scrollTop = myDiv.scrollHeight;
	});

	socket.on("live_stream_remove", (data) => {
		console.log("live_stream_remove");
		console.log(data);
		let id = $("#live-modal").attr("data-id");

		if (id != undefined && data.room_name == id) {
			leave();
			$("#live-modal").modal("hide");
		}
		streamlist("solo");
	});
});

function streamlist(type) {
	$.ajax({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
		},
		type: "GET",
		data: { type: type },
		url: base_url + "/live-stream/list",
		success: function (response) {
			if (type == "solo") {
				$("#stream_list").html(response);
			} else {
				$("#pkbattels_list").html(response);
			}
		},
		error: function (error) {
			console.log(error);
		},
	});
}
