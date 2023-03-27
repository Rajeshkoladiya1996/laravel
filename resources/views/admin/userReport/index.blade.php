@extends('layouts.admin')
@section('title')
    User Reports List
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js" type="text/javascript"></script>
@endsection
@section('content')
    <div class="main-title">
        <h4>User Reports</h4>
    </div>
    <div class="tab-content" id="nav-tabContent">    
        <div class="tab-pane fade show active reward-list-page" id="eventList" role="tabpanel" aria-labelledby="rewardList-tab">
            @include('admin.userReport.userReportList')
        </div>
    </div>
@endsection

@section('js')

<div class="modal fade user-report-modal" id="user-report-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
              <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                    <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
                </button>

            <div class="modal-body">
                <div id="user-report-content">
                    
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    var start_date='';
    var end_date ='';
    
    var viewertable = null;
    viewertable = $("#viewerTable").DataTable({
        processing: true,
        pageLength: 10,
        aaSorting: [],
        responsive: true,
        serverSide: true,
        ordering: true,
        searching: true,
        "ajax": "{{ route('admin.user.reports.list') }}",
        "columns": [{
                "data": "profile_pic"
            },
            {
                "data": "weekly",
                orderable: false
            },
            {
                "data": "action",
                orderable: false
            },
            // {
            //     "data": "monthly",
            //     orderable: false
            // },
            // {
            //     "data": "threemonths",
            //     orderable: false
            // },
            // {
            //     "data": "sixmonths",
            //     orderable: false
            // },
            // {
            //     "data": "yearly",
            //     orderable: false
            // },            
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

    $("#filter_user_report").validate({
        rules:{
            daterange:{
                required: true,
            },
                             
        },
    });
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            // maxDate: new Date(),
            locale: {
              format: 'DD/MM/YYYY'
            }
        }, (start, end, label)=> {
            start_date =start.format('YYYY-MM-DD');
            end_date = end.format('YYYY-MM-DD');
            var loadUrl = "{{ URL::to('godmode/user-reports/list')}}"+"?start_date="+start_date+"&end_date="+end_date;
            viewertable.ajax.url(loadUrl).load();
        });
    });

    $('body').on('submit','#filter_user_report',function(e){
        e.preventDefault();
        if($("#filter_user_report").valid()){
            var loadUrl = "{{ URL::to('godmode/user-reports/list')}}"+"?start_date="+start_date+"&end_date="+end_date;
            viewertable.ajax.url(loadUrl).load();
        }
    });

    $('body').on('click','#view_report_retails',function(e){
        var id = $(this).data('id');
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('admin.user.reports.detail')}}",
            method: 'GET',
            data:{
              id:id,
              start_date:start_date,
              end_date:end_date                
            },
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success: function(data) {
                console.log(data);
                // $("#loading-image").hide();
                $('#user-report-content').html(data);
                $("#viewerDetailsTable").DataTable({
                    "order": [[ 0, "asc" ]]
                });
                $('#user-report-modal').modal('show');
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $('body').on('click', '.tabel-profile-img', function() {

        $("#preview").find('img').attr('src', $(this).find('img').attr("src"));
        $("#preview").modal('show');
    })
    
</script>

@endsection
