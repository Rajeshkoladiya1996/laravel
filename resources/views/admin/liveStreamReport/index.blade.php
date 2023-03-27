@extends('layouts.admin')
@section('title')
    Reported Users/Streamers List
@endsection
@section('css')
@endsection
@section('content')
    <div class="main-title">
        <h4> Reported Users/Streamers</h4>
    </div>
    <div class="tab-content" id="nav-tabContent">    
        <div class="tab-pane fade show active reward-list-page" id="liveStreamList" role="tabpanel" aria-labelledby="rewardList-tab">
            @include('admin.liveStreamReport.liveStreamReportList')
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

<div class="modal fade" id="livestreamReport-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-body p-0">
            <div class="block-modal">
            <h5>Delete Event</h5>
            <p>Are you sure you want to delete this Livestream.</p>
            <input type="hidden" name="type" id="type">
            <input type="hidden" name="del_id" id="del_id">
            <div class="block-btn">
                <a href="javascript:void(0)" class="btn btn-black delete" data-id="yes">Yes</a>
                <a href="javascript:void(0)" class="btn btn-red delete" data-id="no">No</a>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="livestreamReport-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-body p-0">
            <div class="block-modal">
            <h5>Change Status</h5>
            <p>Are you sure you want to change status of this Livestream.</p>
            <input type="hidden" name="liveStream_id" id="liveStream_id">
            <div class="block-btn">
                <a href="javascript:void(0)" class="btn btn-black change" data-id="yes">Yes</a>
                <a href="javascript:void(0)" class="btn btn-red change" data-id="no">No</a>
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

<script type="text/javascript">
var viewertable = null;
    viewertable = $("#liveStreamReportTable").DataTable({
        processing: true,
        pageLength: 10,
        aaSorting: [],
        responsive: true,
        serverSide: true,
        ordering: true,
        searching: true,
        "ajax": "{{ route('admin.liveStream.reports.list') }}",
        "columns": [{
                "data": "from_profile_pic"
            },
            {
                "data": "to_profile_pic",
            },
            {
                "data": "reason",
            },
            {
                "data": "status",
            },
            {
                "data": "action",
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

    $("#liveStreamReportTable").DataTable();

    $('body').on('click','.check_status',function(){
        $('#liveStream_id').val($(this).attr('data-id'));
        $('#livestreamReport-status').modal('show');
    });

    $('.change').on('click',function(e){
        let confim=$(this).attr('data-id');
        let id=$('#liveStream_id').val();
        if(confim=="yes"){
            console.log("yes");        
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.liveStream.reports.changeStatus')}}",
                method:'POST',
                data:{id:id},
                beforeSend: function() {
                // $("#loading-image").show();
                },
                success:function(data){
                    if(data == 1){
                        $('#livestreamReport-status').modal('hide');
                        viewertable.ajax.reload();
                    }
                },error:function(error){
                    console.log(error);             
                }
            });
        }else{
            $('#livestreamReport-status').modal('hide');
        }
    });

    $('body').on('click','#deleteLiveStreamReport',function(){
        $('#del_id').val($(this).attr('data-id'));
        $('#type').val($(this).attr('data-type'));
        $('#livestreamReport-delete').modal('show');
    });

    $('.delete').on('click',function (e) {
        let confim=$(this).attr('data-id');
        let id=$('#del_id').val();   
        let type = $('#type').val();
        if(confim=="yes"){
            console.log("yes");        
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.liveStream.reports.delete')}}",
                method:'POST',
                data:{id:id},
                beforeSend: function() {
                // $("#loading-image").show();
                },
                success:function(data){
                    if(data == 1){
                        $('#livestreamReport-delete').modal('hide');
                        viewertable.ajax.reload();
                    }
                },error:function(error){
                    console.log(error);             
                }
            });
        }else{

        $("#preview").find('img').attr('src', $(this).find('img').attr("src"));
        $("#preview").modal('show');
        }
    });
</script>
@endsection
