@extends('layouts.admin')
@section('title')
Audit Logs
@endsection
@section('css')
@endsection
@section('content')
<div class="main-title">
    <h4 id="title">Login/logout</h4>
    <p id="total-count">{{$logList->total()}} found</p>
</div>
<nav>
    <div class="nav nav-tabs my-nav" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active tab-listing" id="nav-Login-tab" data-toggle="tab" href="#nav-Login" role="tab" aria-controls="nav-Login" aria-selected="true" data-count="{{$logList->total()}}">User Audit</a>
        <a class="nav-item nav-link tab-listing" id="nav-gems-tab" data-toggle="tab" href="#nav-gems" role="tab" aria-controls="nav-gems" aria-selected="false" data-count="{{count($gemstopup)}}">Gems Topup</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active auditList" id="nav-Login" role="tabpanel" aria-labelledby="nav-Login-tab">
        @include('admin.auditLogs.auditList')
    </div>
    <div class="tab-pane fade gemsTopup" id="nav-gems" role="tabpanel" aria-labelledby="nav-gems-tab">
        @include('admin.auditLogs.gemsTopup')
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $('.tab-listing').on('click', function(e) {
        $('#title').text($(this).text());
        if ($(this).text() == "Login/logout") {
            $('#total-count').text('{{$logList->total()}} found');
        } else {
            $('#total-count').text('{{count($gemstopup)}} found');
        }
    });
    // $(document).ready(function()
    // {
    //     $(document).on('click', '.pagination a',function(event)
    //     {
    //         $('li').removeClass('active');
    //         $(this).parent('li').addClass('active');
    //         event.preventDefault();
    //         var myurl = $(this).attr('href');
    //        var page=$(this).attr('href').split('page=')[1];
    //        getData(page);
    //     });
    // });
    // function getData(page){
    //     $.ajax({
    //         url: '{{route("admin.auditLogs.listLogPaginate")}}?page=' + page,
    //         type: "get",
    //         datatype: "html",
    //     }).done(function(data){
    //         console.log(data);
    //         $(".auditList").html(data.html);
    //         $("#example").DataTable();
    //     }).fail(function(jqXHR, ajaxOptions, thrownError){
    //           alert('No response from server');
    //     });
    // }
    var table = null;
    $.fn.dataTable.ext.errMode = 'none';
    table = $("#userAuditLogList").DataTable({
        processing: true,
        pageLength: 10,
        aaSorting: [],
        responsive: true,
        serverSide: true,
        ordering: true,
        searching: true,

        "ajax": '{{route("admin.auditLogs.listLogPaginate")}}',
        "columns": [{
                "data": "profile_pic"
            },
            {
                "data": "username"
            },
            {
                "data": "email"
            },
            {
                "data": "type"
            },
            {
                "data": "role"
            },
            {
                "data": "date",
                orderable: false
            },
            {
                "data": "ip_address"
            },
            {
                "data": "device_type"
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
    
    $("#userAuditLogList").DataTable();

    var tableGems = null;
    tableGems = $("#userAuditGemsList").DataTable({
        processing: true,
        pageLength: 10,
        aaSorting: [],
        responsive: true,
        serverSide: true,
        ordering: true,
        searching: true,

        "ajax": '{{route("admin.auditLogs.listGemsPaginate")}}',
        "columns": [{
                "data": "profile_pic"
            },
            {
                "data": "username"
            },
            {
                "data": "email"
            },
            {
                "data": "gems_amount"
            },
            {
                "data": "date"
            },

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
    $("#userAuditGemsList").DataTable();
</script>
@endsection