@extends('layouts.admin')
@section('title')
User Request List
@endsection
@section('css')
@endsection
@section('content')
<div class="main-title">
    <h4>User Request</h4>
    <p id="total-count">{{count($requestList)}} Live Stream</p>
</div>
<div class="my-nav-wrap">
    <nav>
        <div class="nav nav-tabs my-nav active" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active tab-listing" id="nav-gems-tab" data-toggle="tab" href="#nav-gems" role="tab" aria-controls="nav-gems" aria-selected="false" data-count="{{count($requestList)}}">Live Stream</a>
<!--             <a class="nav-item nav-link tab-listing" id="nav-wallet-tab" data-toggle="tab" href="#nav-wallet" role="tab" aria-controls="nav-wallet" aria-selected="true" data-count="{{count($walletList)}}">Salmon Coins</a> -->
            <a class="nav-item nav-link tab-listing" id="nav-cashwithdrawal-tab" data-toggle="tab" href="#nav-cashwithdrawal" role="tab" aria-controls="nav-cashwithdrawal" aria-selected="true" data-count="{{count($cashWithdrawList)}}">Cash Withdrawal</a>
        </div>
</div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active viewerList" id="nav-gems" role="tabpanel" aria-labelledby="nav-gems-tab">
        @include('admin.userRequest.requestList')
    </div>
<!--     <div class="tab-pane fade wallet" id="nav-wallet" role="tabpanel" aria-labelledby="nav-wallet-tab">
        @include('admin.userRequest.walletRequestList')
    </div> -->
    <div class="tab-pane fade cashwithdrawal" id="nav-cashwithdrawal" role="tabpanel" aria-labelledby="nav-cashwithdrawal-tab">
        @include('admin.userRequest.withdrawalRequestList')
    </div>
</div>
@endsection
@section('js')
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

<div class="modal fade" id="confirmation-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon reset-model" data-dismiss="modal" aria-label="Close">
                <img src="{{ URL::to('storage/app/public/Adminassets/image/close.svg') }}" alt="">
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                    <input type="hidden" name="request_id" id="request_id">
                    <input type="hidden" name="status" id="status">
                    <input type="hidden" name="user_id" id="user_id">
                    <h5 id="title_confirmation_model">User Request</h5>
                    <p id="msg"></p>
                    <div class="block-btn">
                        <a href="javascript:void(0)" id="confirmation-user" class="btn btn-black">Yes</a>
                        <a href="javascript:void(0)" class="btn btn-red reset-model" data-dismiss="modal">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="salmon-coin-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon reset-model" data-dismiss="modal" aria-label="Close">
                <img src="{{ URL::to('storage/app/public/Adminassets/image/close.svg') }}" alt="">
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                    <input type="hidden" name="salmon_request_id" id="salmon_request_id">
                    <input type="hidden" name="salmon_status" id="salmon_status">
                    <input type="hidden" name="salmon_user_id" id="salmon_user_id">
                    <input type="hidden" name="salmon_type" id="salmon_type">
                    <h5 id="title_salmon_coin_model">User Request</h5>
                    <p id="salmon_coin_msg"></p>
                    <div class="block-btn">
                        <a href="javascript:void(0)" id="salmon-coin-user" class="btn btn-black">Yes</a>
                        <a href="javascript:void(0)" class="btn btn-red reset-model" data-dismiss="modal">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('body').on('click', '.tabel-profile-img', function() {

        $("#preview").find('img').attr('src', $(this).find('img').attr("src"));
        $("#preview").modal('show');
    })

    $('body').on('click','.reset-model',function(e){
        $('#salmon_request_id').val('');
        $('#salmon_status').val('');
        $('#salmon_user_id').val('');
        $('#salmon_type').val('');
        $('#request_id').val('');
        $('#status').val('');
        $('#user_id').val('');
    })
    //live stream Request table 
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

        "ajax": '{{route("admin.userRequest.streamRequestList")}}',
        "columns": [{
                "data": "username"
            },
            {
                "data": "email"
            },
            {
                "data": "phone"
            },
            {
                "data": "county"
            },
            {
                "data": "date"
            },
            {
                "data": "status"
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
    $("#streamTable").DataTable();

    //wallet Request table
    var wallettable = null;
    $.fn.dataTable.ext.errMode = 'none';
    wallettable = $("#walletTable").DataTable({
        processing: true,
        pageLength: 10,
        aaSorting: [],
        responsive: true,
        serverSide: true,
        ordering: true,
        searching: true,

        "ajax": '{{route("admin.userRequest.walletRequestList")}}',
        "columns": [{
                "data": "username"
            },
            {
                "data": "email"
            },
            {
                "data": "phone"
            },
            {
                "data": "date"
            },
            {
                "data": "gems_amount"
            },
            {
                "data": "diamond_amount"
            },
            {
                "data": "amount"
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
    $("#walletTable").DataTable();

    // cash withdrawal Request table
    var cashwithdrawal = null;
    $.fn.dataTable.ext.errMode = 'none';
    cashwithdrawal = $("#walletWithdrawalTable").DataTable({
        processing: true,
        pageLength: 10,
        aaSorting: [],
        responsive: true,
        serverSide: true,
        ordering: true,
        searching: true,

        "ajax": '{{route("admin.userRequest.cashWithdrawalRequestList")}}',
        "columns": [{
                "data": "username"
            },
            {
                "data": "email"
            },
            {
                "data": "phone"
            },
            {
                "data": "date"
            },
            {
                "data": "amount"
            },
            {
                "data": "diamond"
            },
            {
                "data": "gems_amount"
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
    $("#walletWithdrawalTable").DataTable();

    // salmon withdrawal Request table
    var salmonwithdrawal = null;
    $.fn.dataTable.ext.errMode = 'none';
    salmonwithdrawal = $("#salmonWithdrawalTable").DataTable({
        processing: true,
        pageLength: 10,
        aaSorting: [],
        responsive: true,
        serverSide: true,
        ordering: true,
        searching: true,

        "ajax": '{{route("admin.userRequest.salmonCoinsWithdrawalRequestList")}}',
        "columns": [{
                "data": "username"
            },
            {
                "data": "email"
            },
            {
                "data": "phone"
            },
            {
                "data": "date"
            },
            {
                "data": "gems_amount"
            },
            {
                "data": "diamond"
            },
            {
                "data": "amount"
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
    $("#salmonWithdrawalTable").DataTable();

    $('body').on('click', '.live-stream-item', function(e) {
        let stream_id = $(this).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "{{route('admin.liveStream.view')}}",
            data: {
                stream_id: stream_id
            },
            success: function(response) {
                // console.log(response);
                $('#live-modal').modal('show');
                streamtable.ajax.reload();
            },
            error: function(error) {
                console.log(error);
            }
        });
    })

    // tab-listing click event count show 
    $('.tab-listing').on('click', function(e) {
        if ($(this).text() == "Live Stream") {
            $('#total-count').text('{{count($requestList)}} ' + $(this).text());
        } else if ($(this).text() == "Gems Wallet") {
            $('#total-count').text('{{count($walletList)}} ' + $(this).text());
        } else if ($(this).text() == "Salmon Coins") {
            $('#total-count').text('{{count($salmonWithdrawList)}} ' + $(this).text());
        } else if ($(this).text() == "Cash Withdrawal") {
            $('#total-count').text('{{count($cashWithdrawList)}} ' + $(this).text());
        }
    })

    // Start Accept Status
    $('body').on('click', '.changeStatus', function(e) {
        let id = $(this).data('id');
        let status = $(this).data('status');
        let user_id = $(this).data('user');
        $('#request_id').val(id);
        $('#status').val(status);
        $('#user_id').val(user_id);
        let confirmation_msg='';
        if(status == 0){
            confirmation_msg = 'Are you sure? You want to reject live stream request ?';
        }else if (status == 2) {
            confirmation_msg = 'Are you sure? You want to accept live stream request ?';
        }
        $('#msg').text(confirmation_msg);
        $('#confirmation-model').modal('show');        
    });

    $('body').on('click','#confirmation-user',function(e){
        let id =  $('#request_id').val();
        let status = $('#status').val();
        let user_id = $('#user_id').val();
        let msg = "";
        if(status == 0){
            msg = "You successfully reject request.";
        }else if (status == 2) {
             msg = "You successfully accepted request.";
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "{{route('admin.userRequest.status')}}",
            data: {
                id: id,
                status: status,
                user_id: user_id
            },
            success: function(response) {
                $('#confirmation-model').modal('hide'); 
                $('#request_id').val('');
                $('#status').val('');
                $('#user_id').val('');
                toastr.success(msg);
                streamtable.ajax.reload();
            },
            error: function(error) {
                $('#confirmation-model').modal('hide'); 
                $('#request_id').val('');
                $('#status').val('');
                $('#user_id').val('');
                console.log(error);
            }
        });
    });
    // End AcceptStatus


    // accept_request
    $('body').on('click', '.accept_request', function(e) {
        let id = $(this).data('id');
        let user_id = $(this).data('user');
        let status = $(this).data('status');
        let type = $(this).data('type');
        let confirmation_msg='';
        if(status == 1 && type == 1){
            confirmation_msg = 'Are you sure? You want to accept salmon coins request ?';
        }else if (status == 2 && type == 1) {
            confirmation_msg = 'Are you sure? You want to reject salmon coins request ?';
        }else if(status == 1 && type == 2){
            confirmation_msg = 'Are you sure? You want to accept cash withdrawal request ?';
        }else if(status == 2 && type == 2){
            confirmation_msg = 'Are you sure? You want to reject cash withdrawal request ?';
        }
        $('#salmon_coin_msg').text(confirmation_msg);

        $('#salmon_request_id').val(id);
        $('#salmon_status').val(status);
        $('#salmon_user_id').val(user_id);
        $('#salmon_type').val(type);
        $('#salmon-coin-model').modal('show'); 
    });

    $('body').on('click', '#salmon-coin-user', function(e) {
        let id = $('#salmon_request_id').val();
        let user_id = $('#salmon_user_id').val();
        let status = $('#salmon_status').val();
        let type = $('#salmon_type').val();
        let msg = "";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "{{route('admin.userRequest.walletStatus')}}",
            data: {
                id: id,
                user_id: user_id,
                status: status,
                type: type
            },
            success: function(response) {

                if (response == 2) {
                    toastr.warning('This user account has been insufficient salmon coins!.');
                } else if (response == 3) {
                    if(status == 2 && type == 1){
                        msg = 'Reject salmon coins request successfully.';
                    }else if(status == 2 && type == 2){
                        msg = 'Reject cash withdrawal withdrawal successfully.';
                    }   
                } else {
                    if(status == 1 && type == 1){
                        msg = 'Accepted salmon coins request successfully.';
                    }else if(status == 1 && type == 2){
                        msg = 'Accepted cash withdrawal successfully.';
                    }
                }
                toastr.success(msg);
                if (type == 2) {
                    cashwithdrawal.ajax.reload();
                }
                if (type == 3) {
                    salmonwithdrawal.ajax.reload();
                } else {
                    wallettable.ajax.reload();
                }
                $('#salmon_request_id').val('');
                $('#salmon_status').val('');
                $('#salmon_user_id').val('');
                $('#salmon_type').val('');
                $('#salmon-coin-model').modal('hide'); 
                
            },
            error: function(error) {
                toastr.error('Something went wrong.');
                console.log(error);
            }
        });
    })
</script>
<script type="text/javascript" src="{{URL::to('storage/app/public/Adminassets/js/videosocket.js')}}"></script>
@endsection