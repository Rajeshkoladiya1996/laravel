@extends('layouts.admin')
@section('title')
User List
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js" type="text/javascript"></script>
@endsection
@section('content')
<div class="main-title">
    <h4>User Management</h4>
    <p id="total-count">{{ count($viewerList) }} Viewer</p>
</div>
<nav>
    <div class="nav nav-tabs my-nav active" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active tab-listing" id="nav-viewer-tab" data-toggle="tab" href="#nav-viewer" role="tab" aria-controls="nav-viewer" aria-selected="false" data-count="{{count($viewerList)}}">Viewer</a>
        <a class="nav-item nav-link tab-listing" id="nav-streamer-tab" data-toggle="tab" href="#nav-streamer" role="tab" aria-controls="nav-streamer" aria-selected="true" data-count="{{count($streamList)}}">Streamer</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active viewerList" id="nav-viewer" role="tabpanel" aria-labelledby="nav-viewer-tab">
        @include('admin.user.viewerList')
    </div>
    <div class="tab-pane fade streamList" id="nav-streamer" role="tabpanel" aria-labelledby="nav-streamer-tab">
        @include('admin.user.streamList')
    </div>
</div>
@endsection
@section('js')
<!-- reset password -->
<div class="modal fade" id="changepassowrd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{ URL::to('storage/app/public/Adminassets/image/close.svg') }}" alt="">
            </button>
            <div class="modal-body password-modal">
                <div class="password-moda">
                    <h5>Reset Password</h5>
                    <form name="resetpassowrd_from" id="resetpassowrd_from">
                        <div class="login-input">
                            <span>
                                <svg id="door-lock-line_6_" data-name="door-lock-line (6)" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25">
                                    <path id="Path_3" data-name="Path 3" d="M0,0H25V25H0Z" fill="none" />
                                    <path id="Path_4" data-name="Path 4" d="M12.622,23.244A10.622,10.622,0,1,1,23.244,12.622,10.622,10.622,0,0,1,12.622,23.244Zm0-2.124a8.5,8.5,0,1,0-8.5-8.5A8.5,8.5,0,0,0,12.622,21.12ZM11.56,13.463a2.656,2.656,0,1,1,2.124,0v3.408H11.56Z" transform="translate(-0.122 -0.122)" />
                                </svg>
                            </span>
                            <input type="hidden" name="user_id" id="user_id">
                            <input type="password" name="password" id="new_password" placeholder="New Password">
                            <span toggle="#password-field2" class="fa fa-fw fa-eye field_icon toggle-password" data-id="new_password"></span>
                            <span class="file-gen-icon" id="generate_password">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z" />
                                    <path fill="#0000004d" class="file-gen" d="M21 8v12.993A1 1 0 0 1 20.007 22H3.993A.993.993 0 0 1 3 21.008V2.992C3 2.455 3.449 2 4.002 2h10.995L21 8zm-2 1h-5V4H5v16h14V9zM8 7h3v2H8V7zm0 4h8v2H8v-2zm0 4h8v2H8v-2z" />
                                </svg>
                            </span>
                        </div>

                        <button type="submit" class="btn btn-black">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="userblock-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{ URL::to('storage/app/public/Adminassets/image/close.svg') }}" alt="">
            </button>
            <div class="modal-body p-0">
                <input type="hidden" name="hid_user_id" id="hid">
                <input type="hidden" name="status" id="hidstatus">
                <div class="block-modal">
                    <h5 id="title_user_block"></h5>
                    <p id="msg"></p>
                    <div class="block-btn">
                        <a href="javascript:void(0)" id="block-user" class="btn btn-black">Yes</a>
                        <a href="javascript:void(0)" class="btn btn-red" data-dismiss="modal">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gems Assign -->
<div class="modal fade" id="assignDiamond-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body password-modal py-5 px-2 p-md-5">
                <div class="password-moda">
                    <h5 class="text-center">Salmon Coins Assign </h5>
                    <form id="assignGems" type="post" class="gems-assign-form mt-4 mb-0">
                        <input type="hidden" name="salmon_rate" id="salmon_rate">
                        <input type="hidden" name="hid_user_id" id="hid_user_id">
                        <input type="hidden" name="user_type" id="user_type">
                        <div class="assign-input login-input">
                            <input type="text" name="amount" id="amount" placeholder="Amount" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                            <img src="{{URL::to('storage/app/public/Adminassets/image/money.svg')}}" class="assign-input-logo" alt="">
                        </div>
                        <div class="assign-input login-input">
                            <input type="text" placeholder="Salmon Coins" name="diamond" id="diamond" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                            <img src="{{URL::to('storage/app/public/Adminassets/image/diamond-2.svg')}}" class="assign-input-logo diamond-icon" alt="" readonly>
                        </div>
                        <input type="submit" class="btn btn-black" value="Submit" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Spend salmon coin report -->
<div class="modal fade" id="spendSalmon-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1245px;">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body password-modal py-5 px-2 p-md-5">
                <h5 class="text-center">Spend Salmon Coins Report</h5>
                <div class="block-modal">
                    <div id="spend-salmon-coin-user-list-data"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Follower -->
<div class="modal fade" id="followers-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1245px;">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body password-modal py-5 px-2 p-md-5">
                <h5 class="text-center">Followers Report</h5>
                <div class="block-modal">
                    <div id="followers-list-data"></div>
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- Live stream details report -->
<div class="modal fade" id="liveStream-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document"  >
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body password-modal py-5 px-2 p-md-5">
                <h5 class="text-center">Live Stream Details</h5>
                <div class="block-modal">
                    <div id="liveStream-list-data"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gold coin details report -->
<div class="modal fade" id="gold-coin-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body password-modal py-5 px-2 p-md-5">
                <h5 class="text-center">Gold Coin Details</h5>
                <div class="block-modal">
                    <div id="goldcoin-list-data"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Blocked User list  model -->
<div class="modal fade blocked-user-list-modal" id="blocked-user-list" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                    <img src="{{ URL::to('storage/app/public/Adminassets/image/close.svg') }}" alt="">
                </button>
                <h5 id="title_user_block">User Block List</h5>
            </div>
            <div class="modal-body p-0">
                <div class="block-modal">
                    <div id="block-user-list-data"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                    <img src="" alt="" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="recommended-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body p-0">
        <div class="block-modal">
            <h5>Change User Recommended status</h5>
            <p>Are you sure you want to Change Status of this User.</p>
            <input type="hidden" name="recommended_id" id="recommended_id">
            <input type="hidden" name="recommended" id="recommended">
            <div class="col-lg-12">
                <div class="row reward-type-radio">
                    <div class="col-lg-6">
                        <div class="login-input no-icon rad-flagger justify-content-start justify-content-lg-center ">
                            <div class="rad-flage-wrapper">
                                <input type="radio" id="recommand" name="user_type" value="0" class="user_type">
                                <span class="rad-flage"></span>
                            </div>
                            <label for="recommand" class="cursor-pointer mb-0">Recommended</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-input no-icon rad-flagger justify-content-start justify-content-lg-center ">
                            <div class="rad-flage-wrapper">
                                <input type="radio" id="popular" name="user_type" class="user_type" value="1">
                                <span class="rad-flage"></span>
                            </div>
                            <label for="popular" class="cursor-pointer mb-0">Popular</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-input no-icon rad-flagger justify-content-start justify-content-lg-center ">
                            <div class="rad-flage-wrapper">
                                <input type="radio" id="hot" name="user_type" class="user_type" value="2">
                                <span class="rad-flage"></span>
                            </div>
                            <label for="hot" class="cursor-pointer mb-0">Hot</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-input no-icon rad-flagger justify-content-start justify-content-lg-center ">
                            <div class="rad-flage-wrapper">
                                <input type="radio" id="none" name="user_type" class="user_type" value="3">
                                <span class="rad-flage"></span>
                            </div>
                            <label for="none" class="cursor-pointer mb-0">None</label>
                        </div>
                    </div>
                </div>
            </div>
          <div class="block-btn">
            <a href="javascript:void(0)" class="btn btn-black change-recommended" data-id="yes">Yes</a>
            <a href="javascript:void(0)" class="btn btn-red change-recommended" data-id="no">No</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Transfer Gold coin -->
<div class="modal fade" id="transferGoldCoin-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body password-modal py-5 px-2 p-md-5">
                <div class="password-moda">
                    <h5 class="text-center">Transfer Gold coin </h5>
                    <form id="transferGold" type="post" class="gems-assign-form mt-4 mb-0">
                        <div class="login-input no-icon">
                            <select name="from_userid" id="from_userid" required class="reward_type" data-id="add">
                                <option value="">Select From User</option>
                                @foreach ($users as $data)
                                <option value="{{$data->id}}">{{ ($data->username!="")? $data->username : ($data->phone!=""? $data->phone : $data->email) }} {{$data->stream_id}}</option>
                                @endforeach
                            </select>
                            <span class="error" id="error-from_userid"></span>
                        </div>
                        <div class="login-input no-icon">
                            <select name="to_userid" id="to_userid" required class="reward_type" data-id="add">
                                <option value="">Select To User</option>
                                @foreach ($users as $data)
                                <option value="{{$data->id}}">{{ ($data->username!="")? $data->username : ($data->phone!=""? $data->phone : $data->email) }} {{$data->stream_id}}</option>
                                @endforeach
                            </select>
                            <span class="error" id="error-to_userid"></span>
                        </div>
                        <input type="submit" class="btn btn-black" value="Submit" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('/storage/app/public/Adminassets/js/jquery.searchableSelect.js')}}"></script>
<script type="text/javascript">
    var streamtable = null;
    $.fn.dataTable.ext.errMode = 'none';
    streamtable = $("#streamTable").DataTable({
        processing: true,
        pageLength: 10,
        aaSorting: [],
        responsive: true,
        serverSide: true,
        ordering: true,
        searching: true,

        "ajax": "{{ route('admin.user.streamList') }}",
        "columns": [{
                "data": "profile_pic"
            },
            {
                "data": "email"
            },
            {
                "data": "phone"
            },
            {
                "data": "login_types"
            },
            {
                "data": "total_gems"
            },
            {
                "data": "earned_gems"
            },
            {
                "data": "follower_count"
            },
            {
                "data": "live_stream_count"
            },
            {
                "data": "date"
            },
            {
                "data": "is_active"
            },
            {
                "data":"recommended"
            },
            {
                "data": "actions",
                orderable: false
            }
        ],
        "initComplete": function(settings, json) {

        },
        columnDefs: [{
                responsivePriority: 1,
                targets: 0
            },
            {
                responsivePriority: 2,
                targets: -1
            }
        ]
    });
    //Stream Table
    $("#streamTable").DataTable();

    var viewertable = null;
    viewertable = $("#viewerTable").DataTable({
        processing: true,
        pageLength: 10,
        aaSorting: [],
        responsive: true,
        serverSide: true,
        ordering: true,
        searching: true,
        stateSave:true,

        "ajax": "{{ route('admin.user.viewerList') }}",
        "columns": [{
                "data": "profile_pic"
            },
            {
                "data": "email"
            },
            {
                "data": "phone"
            },
            {
                "data": "login_types"
            },
            {
                "data": "total_gems"
            },
            {
                "data": "earned_gems"
            },
            {
                "data": "follower_count"
            },
            {
                "data": "date"
            },
            {
                "data": "is_active"
            },
            {
                "data": "actions",
                orderable: false
            }
        ],
        "initComplete": function(settings, json) {

        },
        columnDefs: [{
                responsivePriority: 1,
                targets: 0
            },
            {
                responsivePriority: 2,
                targets: -1
            }
        ]
    });

    $("#viewerTable").DataTable();

    $('body').on('click','.recommended-status',function(){
        $('#recommended_id').val($(this).attr('data-id'));
        // $('#recommended').val($(this).attr('data-status'));
        var type=$(this).attr('data-status');
        $("input[name='user_type']").attr("checked", false);
        $("input[name='user_type'][value='"+type+"']").attr("checked", true);
        $('#recommended-model').modal('show');
    });

    // recommended click event
    $('body').on('click','.change-recommended',function(){
        let status = $('#recommended').val();
        let confim=$(this).attr('data-id');
        let id=$('#recommended_id').val();
        let user=$('input[name="user_type"]:checked').val();

        if(confim=="yes"){
            console.log("yes");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ route('admin.user.recommended') }}",
                method:'POST',
                data:{id:id,status:status,user:user},
                beforeSend: function() {
                    // $("#loading-image").show();
                },
                success:function(data){
                    if(data == 1){
                        $('#recommended-model').modal('hide');
                        streamtable.ajax.reload(false);
                    }else{
                        console.log(data);
                    }
                },error:function(error){
                }
            });
        }else{
            $('#recommended-model').modal('hide');
        }
    });

    $(document).on('click', '.toggle-password', function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        const id = $(this).data('id');
        var input = $('#' + id);
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    // tab list
    $('.tab-listing').on('click', function(e) {
        if ($(this).text() == "Streamer") {
            $('#total-count').text('{{ count($streamList) }} ' + $(this).text());
        } else {
            $('#total-count').text('{{ count($viewerList) }} ' + $(this).text());
        }
    })

    var langArray = [];
    $(".vodiapicker option").each(function() {
        var img = $(this).attr("data-thumbnail");
        var gems = $(this).attr("data-gems");
        var text = this.innerText;
        var value = $(this).val();
        var item = '<li data-value="' + value + '" data-gems="' + gems + '"><img src="' + img +
            '" alt="" value="' + value + '"/><span>' + text + "</span></li>";
        langArray.push(item);
    });

    $("#a").html(langArray);

    //Set the button value to the first el of the array
    $(".btn-select").html(langArray[0]);
    $(".btn-select").attr("value", "en");

    //change button stuff on click
    $("#a li").click(function() {
        var img = $(this).find("img").attr("src");
        var value = $(this).find("img").attr("value");
        var text = this.innerText;
        var item = '<li><img src="' + img + '" alt="" /><span>' + text + "</span></li>";
        $(".btn-select").html(item);
        $(".btn-select").attr("value", value);
        $(".b").toggle();
        // console.log($(this).data('gems'));
    });

    $(".btn-select").click(function() {
        $(".b").toggle();
    });

    $('body').on('click', '.reset_password', function(e) {
        $('#user_id').val($(this).data('id'));
        $('#changepassowrd').modal('show');
    });

    $('#generate_password').on('click', function(e) {
        var length = 8,
            charset = "$&#@!^*()abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        $('#new_password').val(retVal);
    });

    $("#resetpassowrd_from").validate({
        rules: {
            password: {
                required: true,
                noSpace: true,
                minlength: 6,
                maxlength: 12,
            },

        },

    });

    $('#resetpassowrd_from').on('submit', function(e) {
        e.preventDefault();
        if ($("#resetpassowrd_from").valid()) {
            var fd = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.user.changePassword') }}",
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
                        toastr.success('User change passowrd successfully.');
                        $('#changepassowrd').modal('hide');
                    } else {
                        $('#changepassowrd').modal('hide');
                        toastr.error('Something went wrong.');
                    }

                },
                error: function(error) {
                    console.log(error);

                }
            });
        }
    })

    // assign-model
    $('body').on('click', '.assign-model', function() {
        $('#hid_user_id').val($(this).data('id'));
        $('#user_type').val($(this).data('type'));
        $('#amount').val("");
        $('#diamond').val("");
        $('#assignDiamond-modal').modal('show');
    });

    // salmon gif details
    
   $('body').on('click', '.salmon-details-model', function() {
        let id = $(this).data('id')
        $('#spendSalmon-modal').modal('show');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.user.spendCoinUser') }}",
            type: 'POST',
            data: {
                'user_id': id
            },
            success: function(response) {
                $('#spend-salmon-coin-user-list-data').html(response);

                // $('#spendCoinTable').DataTable();
                $.fn.dataTable.ext.errMode = 'none';
                spendCoinTable = $("#spendCoinTable").DataTable({
                    processing: true,
                    pageLength: 10,
                    aaSorting: [],
                    responsive: true,
                    serverSide: true,
                    ordering: true,
                    searching: true,
                    "ajax": {
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "url":'{{route("admin.user.spendCoinUserList")}}',
                        "type": "POST",
                        "data": {
                            'user_id': id
                        },
                    },
                    "columns": [{
                            "data": "username"
                        },
                        {
                            "data": "giftname"
                        },
                        {
                            "data": "giftCategoryName"
                        },
                        {
                            "data": "gems"
                        },
                        {
                            "data": "date"
                        }
                    ],
                    "initComplete": function(settings, json) {

                    },
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 0
                        },
                        {
                            responsivePriority: 2,
                            targets: -1
                        }
                    ]
                });
                $("#spendCoinTable").DataTable();
                url='spendCoinUserList';
                dateTwoRange(url);
            },
            error: function(errors) {
                //    console.log(errors);
            }
        });
    });

    $('body').on('click', '.followers-details-model', function() {
        let id = $(this).data('id')
        $('#followers-modal').modal('show');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.user.followersUserReport') }}",
            type: 'POST',
            data: {
                'user_id': id
            },
            success: function(response) {
                $('#followers-list-data').html(response);
                // $('#followerTable').DataTable();

                $.fn.dataTable.ext.errMode = 'none';
                followerTable = $("#followerTable").DataTable({
                    processing: true,
                    pageLength: 10,
                    aaSorting: [],
                    responsive: true,
                    serverSide: true,
                    ordering: true,
                    searching: true,
                    "ajax": {
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "url":'{{URL::to("godmode/user/followersUserList")}}',
                        "type": "POST",
                        "data": {
                            'user_id': id
                        },
                    },
                    "columns": [{
                            "data": "username"
                        },
                        {
                            "data": "email"
                        },
                        {
                            "data": "stream_id"
                        },
                        {
                            "data": "phone"
                        }
                    ],
                    "initComplete": function(settings, json) {

                    },
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 0
                        },
                        {
                            responsivePriority: 2,
                            targets: -1
                        }
                    ]
                });
                $("#followerTable").DataTable();
                url='followersUserList';
                dateTwoRange(url);
            },
            error: function(errors) {
                   console.log(errors);
            }
        });
    });

    // live-stream details
    
     $('body').on('click', '.live-stream-model', function() {
        let id = $(this).data('id');
        $('#liveStream-modal').modal('show');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.user.liveStreamReport') }}",
            type: 'POST',
            data: {
                'user_id': id
            },
            success: function(response) {
                $('#liveStream-list-data').html(response);
                // $('#liveStreamTable').DataTable();

                $.fn.dataTable.ext.errMode = 'none';
                liveStreamTable = $("#liveStreamTable").DataTable({
                    processing: true,
                    pageLength: 10,
                    aaSorting: [],
                    responsive: true,
                    serverSide: true,
                    ordering: true,
                    searching: true,
                    "ajax": {
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "url":'{{route("admin.user.liveStreamReportList")}}',
                        "type": "POST",
                        "data": {
                            'user_id': id
                        },
                    },
                    "columns": [{
                            "data": "date"
                        },
                        {
                            "data": "startTime",
                            orderable: false
                        },
                        {
                            "data": "endTime",
                            orderable: false
                        },
                        {
                            "data": "duration",
                            orderable: false
                        }
                    ],
                    "initComplete": function(settings, json) {

                    },
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 0
                        },
                        {
                            responsivePriority: 2,
                            targets: -1
                        }
                    ]
                });
                $("#liveStreamTable").DataTable();
                url='liveStreamReportList';
                dateTwoRange(url);
            },
            error: function(errors) {
                   console.log(errors);
            }
        });
    });
    
    // earned_gems
    $('body').on('click', '.earned_gems-details-model', function() {
        let id = $(this).data('id')
        $('#gold-coin-modal').modal('show');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.user.goldCoinUserList') }}",
            type: 'POST',
            data: {
                'user_id': id
            },
            success: function(response) {
                $('#goldcoin-list-data').html(response);
                // $('#goldCoinTable').DataTable();

                $.fn.dataTable.ext.errMode = 'none';
                goldCoinTable = $("#goldCoinTable").DataTable({
                    processing: true,
                    pageLength: 10,
                    aaSorting: [],
                    responsive: true,
                    serverSide: true,
                    ordering: true,
                    searching: true,
                    "ajax": {
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "url":'{{route("admin.user.goldCoinUser")}}',
                        "type": "POST",
                        "data": {
                            'user_id': id
                        },
                    },
                    "columns": [{
                            "data": "username"
                        },
                        {
                            "data": "giftname"
                        },
                        {
                            "data": "giftCategoryName"
                        },
                        {
                            "data": "gems"
                        },
                        {
                            "data": "date"
                        }
                    ],
                    "initComplete": function(settings, json) {

                    },
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 0
                        },
                        {
                            responsivePriority: 2,
                            targets: -1
                        }
                    ]
                });
                $("#goldCoinTable").DataTable();
                url='goldCoinUser';
                dateTwoRange(url);
            },
            error: function(errors) {
                   console.log(errors);
            }
        });
    });


    // amount
    $('#amount').on('keyup', function() {
        let amount = $(this).val();
         $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.user.checkRate') }}",
            type: 'POST',
            data: {
                'amount': amount,
            },
            success: function(response) {
                $('#diamond').val(response['coin']);
                $('#salmon_rate').val(response['rate']);
            },
            error: function(errors) {
                for (error in errors.responseJSON.errors) {
                    $('#error-' + error).text(errors.responseJSON.errors[error]);
                }
            }
        });
    });

    // $('#diamond').on('keyup', function() {
    //     let diamond = $(this).val();
    //     let cash_amount = "{{ @$cofigs->cash_amount }}";
    //     let gems_diamond_rate = "{{ @$cofigs->gems_diamond_rate }}";
    //     let diamond_gems_rate = "{{ @$cofigs->diamond_gems_rate }}";
    //     let amount = (diamond * cash_amount) / diamond_gems_rate;
    //     let total_gems = (diamond * diamond_gems_rate) / gems_diamond_rate;
    //     $('#amount').val(amount);
    //     $('#gems').val(total_gems);
    // });

    // assignGems
    $("#assignGems").validate({
		rules: {
			amount: {
				required: true,
			},
			diamond: {
				required: true,
			}
		},
		messages: {
			
		},
	});

    // assignGems
    $('#assignGems').on('submit', function(e) {
        e.preventDefault();
        let amount = $('#amount').val();
        let types = $('#user_type').val();
        let diamond = $("#diamond").val();
        let rate = $("#salmon_rate").val();
        let user_id = $('#hid_user_id').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.user.assignDiamond') }}",
            type: 'POST',
            data: {
                'amount': amount,
                'diamond': diamond,
                'rate': rate,
                'user_id': user_id
            },
            success: function(response) {
                if (response == '1') {
                    toastr.success('Diamond assign successfully.');
                    $('#assignGems')[0].reset();
                    $('#assignDiamond-modal').modal('hide');
                    if (types == "streamer") {
                        streamtable.ajax.reload(false);
                    } else {
                        viewertable.ajax.reload(false);
                    }
                }else if(response=='2'){
                    toastr.error('Salmon Coin and diamond is invalid!');
                } else {
                    $('#assignDiamond-modal').modal('hide');
                    toastr.error('Something went wrong.');
                }
            },
            error: function(errors) {
                for (error in errors.responseJSON.errors) {
                    $('#error-' + error).text(errors.responseJSON.errors[error]);
                }
            }
        });
    });

    // userBlockUnblock
    $('body').on('click', '#userBlockUnblock', function() {
        $('#hid').val($(this).data('id'));
        if ($(this).data('status') == 1) {
            $('#title_user_block').text('Block User');
            $('#msg').text('Are you sure you want to block this user.');
        } else {
            $('#title_user_block').text('Unblock User');
            $('#msg').text('Are you sure you want to Unblock this user.');
        }
        $('#hidstatus').val($(this).data('status'));
        $('#userblock-model').modal('show');
    });

    // block user
    $('body').on('click', '#block-user', function(e) {
        let id = $('#hid').val();
        let status = $('#hidstatus').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.user.blockUserByAdmin') }}",
            type: 'POST',
            data: {
                'user_id': id,
                'status': status
            },
            success: function(response) {
                if (response == 1) {
                    let msg = (status == 1) ? 'Block' : 'Unblock';
                    toastr.success('User ' + msg + ' Successfully');
                    streamtable.ajax.reload();
                    viewertable.ajax.reload();
                    $('#userblock-model').modal('hide');
                } else {
                    toastr.error('Something went wrong');
                }
            },
            error: function(errors) {
                //    console.log(errors);
            }
        });

    });

    // blocked user list
    $('body').on('click', '#blocked-user-list-model', function(e) {
        let id = $(this).attr('data-id');
        $('#blocked-user-list').modal('show');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.user.blockUserList') }}",
            type: 'POST',
            data: {
                'user_id': id
            },
            success: function(response) {
                console.log({
                    response
                });
                let blockUserList = `<div class="user-blocklist-content">`;

                if (response != '') {
                    for (item of response) {
                        blockUserList += `<div class="user-blocklist-img"><img src='${item.user.profile_pic}' alt='image not found' width="50px" heigh="50px"/></div>
								<div class="pl-3"><h2>${item.user.username!='' ? item.user.username : '-' }
								</h2><p>${item.user.phone}</p></div>`;
                    }
                } else {
                    blockUserList += `<div>No such record found</div>`;
                }
                blockUserList += `</div>`;
                $('#block-user-list-data').html(blockUserList);

            },
            error: function(errors) {
                //    console.log(errors);
            }
        });

    });

        
    // profile image list
    $('body').on('click', '.tabel-profile-img', function() {

        $("#preview").find('img').attr('src', $(this).find('img').attr("src"));
        $("#preview").modal('show');
    });
    $(function(){
        $('select').searchableSelect();
    });

    $("#filter_user_report").validate({
        rules:{
            daterange:{
                required: true,
            },
        },
    });
    function dateTwoRange(url){
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            maxDate: new Date(),
            locale: {
            format: 'DD/MM/YYYY'
            }
        }, (start, end, label)=> {
            start_date =start.format('YYYY-MM-DD');
            end_date = end.format('YYYY-MM-DD');
            var loadUrl ="";
            if(url=="spendCoinUserList"){
                loadUrl = "{{ URL::to('godmode/user/spendCoinUserList')}}"+"?start_date="+start_date+"&end_date="+end_date;
                spendCoinTable.ajax.url(loadUrl).load();
            }else if(url=="goldCoinUser"){
                loadUrl = "{{ URL::to('godmode/user/goldCoinUser')}}"+"?start_date="+start_date+"&end_date="+end_date;
                goldCoinTable.ajax.url(loadUrl).load();
            }else if(url =="followersUserList"){
                loadUrl = "{{ URL::to('godmode/user/followersUserList')}}"+"?start_date="+start_date+"&end_date="+end_date;
                followerTable.ajax.url(loadUrl).load();
            }else if(url=="liveStreamReportList"){
                loadUrl = "{{ URL::to('godmode/user/liveStreamReportList')}}"+"?start_date="+start_date+"&end_date="+end_date;
                liveStreamTable.ajax.url(loadUrl).load();
            }

        });
    }
</script>
@endsection