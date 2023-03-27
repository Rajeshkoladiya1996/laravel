@extends('layouts.admin')
@section('title')
Live User Stream List
@endsection
@section('css')
@endsection
@section('content')
<div class="main-title">
  <h4>Live Stream Management</h4>
  <p><span id="live_user"> {{($streamlist!='')?count($streamlist):0}} </span> User found</p>
</div>
<nav>
  <div class="nav nav-tabs my-nav active" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active tab-listing toggle-btn" id="SoloList-tab" data-toggle="tab"
      href="#SoloList" role="tab" aria-controls="levelList" aria-selected="false">Solo host</a>
    <a class="nav-item nav-link tab-listing toggle-btn" id="Pklist-tab" data-toggle="tab"
      href="#PkList" role="tab" aria-controls="points" aria-selected="true">Pk host</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="SoloList" role="tabpanel"
    aria-labelledby="SoloList-tab">
    <div class="row" id="stream_list">

      @include('admin.liveStream.streamList')
    </div>

  </div>
  <div class="tab-pane fade" id="PkList" role="tabpanel" aria-labelledby="Pklist-tab">
    <div class="row" id="pkbattels_list">
      @include('admin.liveStream.battlesList')
    </div>

  </div>
</div>

@endsection
@section('js')
<div class="modal fade live-modal" id="live-modal" data-backdrop="static" data-keyboard="false"
  tabindex="-1" role="dialog" aria-labelledby="live-modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <button type="button" class="close-icon">
        <img src="https://bklive.stream/storage/app/public/Adminassets/image/close.svg" alt="">
      </button>
      <div class="row video-group">
        <!-- <div class="w-100"></div> -->
        <div class="col user-video-show live-video-auto">
          <div id="remote-playerlist">
            <div class="live-user-details pk-host-left-angle">
              <h6 class="live-user-txt">Live</h6>
              <div class="live-user-profile">
                <div class="live-user-profile-img">
                  <div class="user-cap">
                    <img src="{{asset('storage/app/public/Adminassets/image/ic_sworn.png')}}"
                      alt="user-sticker">
                  </div>
                  <div class="user-profile">
                    <img id="profile_pic"
                      src="https://st2.depositphotos.com/1104517/11965/v/600/depositphotos_119659092-stock-illustration-male-avatar-profile-picture-vector.jpg"
                      alt="user-profile" class="profile_pic">
                  </div>
                  <div class="user-country-flag">
                    <img
                      src="https://lh3.googleusercontent.com/kDFqpP2IdHOWzipHrsB1o0wbBgHZNR9_E3Prc0zUzAvQCHxiDhOqtupTz_oHjI36PIU=s200"
                      alt="user-sticker">
                  </div>
                </div>
                <div class="user-details">
                  <p class="user-title" id="user_name"></p>
                  <p><i class="fas fa-user mr-1"></i><span class="total_user_count"
                      id="total_user_count">0</span></p>
                  <p><i class="far fa-comment mr-1"></i><span class="total_chat_count"
                      id="total_chat_count">0</span></p>
                </div>
              </div>
              <div class="live-user-profile money-send-list">
                <img src="{{asset('storage/app/public/Adminassets/image/diamond.svg')}}"
                  alt="user-sticker" class="send-money-sticker">
                <div class="user-details">
                  <p id="total_games_count1" class="">0</p>
                </div>
              </div>
            </div>
            <div class="live-user-details pk-host-right-angle" id="pk_battel" style="display:none;">
              <h6 class="live-user-txt">Live</h6>
              <div class="live-user-profile">
                <div class="user-details">
                  <p class="user-title" id="user_name2"></p>
                </div>
                <div class="live-user-profile-img">
                  <div class="user-cap">
                    <img
                      src="https://lh3.googleusercontent.com/kDFqpP2IdHOWzipHrsB1o0wbBgHZNR9_E3Prc0zUzAvQCHxiDhOqtupTz_oHjI36PIU=s200"
                      alt="user-sticker">
                  </div>
                  <div class="user-profile">
                    <img id="profile_pic1"
                      src="https://st2.depositphotos.com/1104517/11965/v/600/depositphotos_119659092-stock-illustration-male-avatar-profile-picture-vector.jpg"
                      alt="user-profile">
                  </div>
                  <div class="user-country-flag">
                    <img
                      src="https://lh3.googleusercontent.com/kDFqpP2IdHOWzipHrsB1o0wbBgHZNR9_E3Prc0zUzAvQCHxiDhOqtupTz_oHjI36PIU=s200"
                      alt="user-sticker">
                  </div>
                </div>
              </div>
              <div class="live-user-profile money-send-list">
                <div class="user-details">
                  <p id="total_games_count2">40</p>
                </div>
                <img
                  src="https://lh3.googleusercontent.com/kDFqpP2IdHOWzipHrsB1o0wbBgHZNR9_E3Prc0zUzAvQCHxiDhOqtupTz_oHjI36PIU=s200"
                  alt="user-sticker" class="send-money-sticker">
              </div>
            </div>
            <div class="live-comments-block vertical-scroll chat_list" id="chat_list">
            </div>
            <div class="gift-pop-wrap">
              <div class="gift-pop">
                <img src="{{asset('storage/app/public/Adminassets/image/pink-diamond.png')}}"
                  class="img-fluid bk-live-emoji-img" alt="" />
              </div>
            </div>
            <div id="live-video-player" class="live-video-player">

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- form -->
<div class="container">
  <form id="join-form" name="join-form" style="display: none;">
    <div class="row join-info-group">
      <div class="col-sm">
        <p class="join-info-text">AppID</p>
        <input id="appid" type="text" placeholder="enter appid" required>
        <p class="tips">If you don`t know what is your appid, checkout <a
            href="https://docs.agora.io/en/Agora%20Platform/terms?platform=All%20Platforms#a-nameappidaapp-id">this</a>
        </p>
      </div>
      <div class="col-sm">
        <p class="join-info-text">Token(optional)</p>
        <input id="token" type="text" placeholder="enter token">
        <p class="tips">If you don`t know what is your token, checkout <a
            href="https://docs.agora.io/en/Agora%20Platform/terms?platform=All%20Platforms#a-namekeyadynamic-key">this</a>
        </p>
      </div>
      <div class="col-sm">
        <p class="join-info-text">Channel</p>
        <input id="channel" type="text" placeholder="enter channel name" required>
        <p class="tips">If you don`t know what is your channel, checkout <a
            href="https://docs.agora.io/en/Agora%20Platform/terms?platform=All%20Platforms#channel">this</a>
        </p>
      </div>
    </div>

    <div class="button-group">
      <button id="host-join" type="submit" class="btn btn-primary btn-sm">Join as host</button>
      <button id="audience-join" type="submit" class="btn btn-primary btn-sm">Join as
        audience</button>
      <button id="leave" type="button" class="btn btn-primary btn-sm" disabled>Leave</button>
    </div>
  </form>
</div>
<!-- end -->

<script type="text/javascript"
  src="{{URL::to('storage/app/public/Adminassets/js/videosocket.js')}}"></script>
<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
<script>
const server_url = "{{route('admin.liveStream.view')}}";
const battles_url = "{{route('admin.liveStream.battlesview')}}";
</script>
<script type="text/javascript" src="{{URL::to('storage/app/public/Adminassets/js/basicLive.js')}}">
</script>
@endsection