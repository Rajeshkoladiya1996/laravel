@extends('layouts.admin')
@section('title')
Financial Management
@endsection
@section('css')
@endsection
@section('content')
<div class="main-title">
    <h4>Financial Management</h4>
    <div id="level-point-btn">
        <a href="javascript:void(0)" class="btn btn-pink btn-header-pink assign-model">Assign Salmon coins</a>
    </div>
    <!-- <p>0 User found</p> -->
</div>
<div class="row financial-row">
    <div class="col-lg-6">
        @include('admin.finanical.gemsList')
    </div>
    <div class="col-lg-6">
        @include('admin.finanical.packagePurchasesList')
    </div>
</div>
<div class="row financial-row">
    <div class="col-lg-6">
        @include('admin.finanical.agentGemsList')
    </div>
</div>
@if(Auth::user()->hasRole('super-admin'))
<div class="row financial-row">
    <div class="col-lg-6 m-0" >
        <div id="main-title" class="row">
            <div class="col-lg-6">
                <h5>Salmon coin</h5>
            </div>
            <div id="level-point-btn" class="col-lg-6" style="text-align: right;">
                <a href="javascript:void(0)" class="btn btn-pink btn-header-pink add-salmoncoin-model"> + Add Salmon coin</a>
            </div>
        </div>
        <div id="salmoncoinListData">
        </div>
             {{-- @include('admin.finanical.salmoncoinList') --}}
    </div>
    <div class="col-lg-6">
        <h5>Paid Out Streamers</h5>
        <div class="white-box white-box2">
            <div class="check-wrap">
                <label class="financial-profile-item" for="financial-profile-1">
                    Record Not Found
                </label>
                <!-- <label class="financial-profile-item" for="financial-profile-1">
                    <input type="checkbox" id="financial-profile-1">
                    <div class="financial-profile-wrap">
                        <span><img src="{{URL::to('storage/app/public/Adminassets/image/profile.jpg')}}" alt=""></span>
                        <div class="financial-profile-checkbox">
                            <h6>Jonathan Doe</h6>
                            <span></span>
                        </div>
                    </div>
                </label> -->

            </div>
        </div>
    </div>
</div>
<!-- Gems Assign -->


@endif
@endsection
@section('js')

    
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
                        <div class="assign-input login-input">
                            <input type="text" name="amount" id="amount" placeholder="Amount" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                            <img src="{{URL::to('storage/app/public/Adminassets/image/money.svg')}}" class="assign-input-logo" alt="">
                        </div>
                        <div class="assign-input login-input">
                            <input type="text" placeholder="Salmon Coins" name="diamond" id="diamond" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                            <img src="{{URL::to('storage/app/public/Adminassets/image/diamond.svg')}}" class="assign-input-logo diamond-icon" alt="" readonly>
                        </div>
                        <div class="login-input no-icon">
                            <select name="user_id" id="user_id" required class="reward_type" data-id="add">
                                <option value="">Select User</option>
                                @foreach ($users as $data)
                                <option value="{{$data->id}}">{{ ($data->username!="")? $data->username : ($data->phone!=""? $data->phone : $data->email) }} {{$data->stream_id}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="submit" class="btn btn-black" value="Submit" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment confirmation model -->
<div class="modal fade" id="paid-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body p-0">
                <input type="hidden" name="hid_user_id" id="hid">
                <input type="hidden" name="hid" id="id">
                <input type="hidden" name="status" id="hidstatus">
                <div class="block-modal">
                    <h5 id="title_user_paid">Gems Top-up</h5>
                    <p id="msg"></p>
                    <div class="block-btn">
                        <a href="javascript:void(0)" id="pay-user" class="btn btn-black">Yes</a>
                        <a href="javascript:void(0)" class="btn btn-red" data-dismiss="modal">No</a>
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

<!-- Start Salmon Top-up  -->
<div class="modal fade" id="salmon-topups-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body password-modal py-5 px-2 p-md-5">
                <div class="password-moda">
                    <h5 class="text-center">Update Salmon Coins </h5>
                    <form id="update_topups" type="post" class="gems-assign-form mt-4 mb-0">
                        <input type="hidden" name="topup_user_id" id="topup_user_id">
                        <input type="hidden" name="topupid" id="topupid">
                        <div class="assign-input login-input">
                            <input type="text" name="amount" id="eamount" placeholder="Amount" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                            <img src="{{URL::to('storage/app/public/Adminassets/image/money.svg')}}" class="assign-input-logo" alt="">
                        </div>
                        <div class="assign-input login-input">
                            <input type="text" placeholder="Salmon Coins" name="diamond" id="ediamond" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                            <img src="{{URL::to('storage/app/public/Adminassets/image/diamond.svg')}}" class="assign-input-logo diamond-icon" alt="" readonly>
                        </div>
                        <input type="submit" class="btn btn-black" value="Submit" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Salmon Top-up -->

<div class="modal fade" id="add-salmoncoin-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body password-modal py-5 px-2 p-md-5">
                <div class="password-moda">
                    <h5 class="text-center">Add Salmon coin rate</h5>
                    <form id="addSalmoncoin" type="post" class="gems-assign-form mt-4 mb-0">
                        <div class="assign-input login-input">
                            <input type="text" name="minTHB" id="minTHB" placeholder="Enter Min THB" />
                        </div>
                        <div class="assign-input login-input">
                            <input type="text" name="maxTHB" id="maxTHB" placeholder="Enter Max THB" />
                        </div>
                        <div class="assign-input login-input">
                            <input type="text" name="rate" id="rate" placeholder="Enter Rate" />
                        </div>
                        <input type="submit" class="btn btn-black" value="Submit" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-salmoncoin-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body password-modal py-5 px-2 p-md-5">
                <div class="password-moda">
                    <h5 class="text-center">Edit Salmon coin rate </h5>
                    <form id="editSalmoncoin-from" type="post" class="gems-assign-form mt-4 mb-0">
                        <input type="hidden" name="id" id="hsid">
                        <div class="assign-input login-input">
                            <input type="text" name="minTHB" id="eminTHB" placeholder="Enter Min THB" />
                        </div>
                        <div class="assign-input login-input">
                            <input type="text" name="maxTHB" id="emaxTHB" placeholder="Enter Max THB" />
                        </div>
                        <div class="assign-input login-input">
                            <input type="text" name="rate" id="erate" placeholder="Enter Rate" />
                        </div>
                        <input type="submit" class="btn btn-black" value="Submit" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="salmoncoin-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-body p-0">
            <div class="block-modal">
            <h5>Delete Salmon Coin</h5>
            <p>Are you sure you want to delete this Salmon Coin.</p>
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

 <script src="{{ asset('/storage/app/public/Adminassets/js/jquery.searchableSelect.js')}}"></script>
 
<script type="text/javascript">
    $('#salmonCoinList').DataTable({});

    $('body').on('click', '.tabel-profile-img', function() {

        $("#preview").find('img').attr('src', $(this).find('img').attr("src"));
        $("#preview").modal('show');
    })
    $('.setGemsDiamondsCash').on('blur', function() {
        let amount = $(this).val();
        let input_name = $(this).attr('name');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.config.store') }}",
            type: 'POST',
            data: {
                'amount': amount,
                'input_name': input_name
            },
            success: function(response) {
                if (response == 1) {
                    toastr.success(input_name + ' Updated Successfully.');
                } else {
                    toastr.error('Something went wrong.');
                }
            }
        });
    });

   

    var tableGems = null;
    $.fn.dataTable.ext.errMode = 'none';
    // $.fn.dataTable.ext.pager.numbers_length = 3;
    tableGems = $("#auditGemsList").DataTable({
        processing: true,
        pageLength: 10,
        aaSorting: [],
        responsive: true,
        serverSide: true,
        ordering: true,
        searching: true,

        "ajax": '{{route("admin.finanical.listGemsPaginate")}}',
        "columns": [{
                "data": "username"
            },
            {
                "data": "gems_amount"
            },
            {
                "data": "amount"
            },
            {
                "data": "date"
            },
            {
                "data": "status"
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
    $("#auditGemsList").DataTable();
    $("#agentTopUp").DataTable();
    $("#packagePurchase").DataTable();
    $('body').on('click', '.assign-model', function() {
        $('#assignDiamond-modal').modal('show');
    });
    $("#assignGems").validate({
        rules: {
            amount: {
                required: true,
            },
            diamond: {
                required: true,
            },
            user_id: {
                required: true,
            },

        },
    });

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
    //     let cash_amount = "{{ @$cofigs->cash_amount}}";
    //     let gems_diamond_rate = "{{ @$cofigs->gems_diamond_rate}}";
    //     let diamond_gems_rate = "{{ @$cofigs->diamond_gems_rate}}";
    //     let amount = (diamond * cash_amount) / diamond_gems_rate;
    //     let total_gems = (diamond * diamond_gems_rate) / gems_diamond_rate;
    //     $('#amount').val(amount);
    //     $('#gems').val(total_gems);
    // });

    $('#assignGems').on('submit', function(e) {
        e.preventDefault();

        let amount = $('#amount').val();
        let types = $('#user_type').val();
        let diamond = $("#diamond").val();
        let rate = $("#salmon_rate").val();
        let user_id = $("#user_id").val();

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
                    tableGems.ajax.reload(null, false);
                    
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

    $('body').on('click', '.is_paid', function(e) {
        $('#hid').val($(this).data('user-id'));
        $('#id').val($(this).data('id'));
        $('#msg').text('Are you sure you want to pay gems to this user?');
        $('#paid-model').modal('show');
    });

    $('body').on('click', '#pay-user', function(e) {
        let user_id = $('#hid').val();
        let id = $('#id').val();
        let status = 1;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.userRequest.walletStatus') }}",
            type: 'POST',
            data: {
                'user_id': user_id,
                status: 1,
                'id': id,
                'type': 1
            },
            success: function(response) {
                if (response == 1) {
                    toastr.success('You paid gems topup successfully.');
                    tableGems.ajax.reload(null, false);
                    $('#paid-model').modal('hide');
                } else {
                    toastr.error('Something went wrong');
                }
            },
            error: function(errors) {
                //    console.log(errors);
            }
        });
    });

    getSalmoncoinList();
    function getSalmoncoinList(){
        $.ajax({
            url: "{{route('admin.finanical.list')}}",
            method: 'GET',
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success: function(data) {
                // $("#loading-image").hide();
                $('#salmoncoinListData').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
    $('body').on('click', '.add-salmoncoin-model', function() {
        $('#add-salmoncoin-modal').modal('show');
    });
    $('body').on('click', '.editSalmonCoin', function() {
        let id = $(this).attr('data-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{URL::to('godmode/financial/edit/')}}" + "/" + id,
            method: 'GET',
            beforeSend: function() {},
            success: function(data) {
                $('#hsid').val(data.id);
                $('#eminTHB').val(data.from_price);
                $('#emaxTHB').val(data.to_price);
                $('#erate').val(data.rate);
                $('#edit-salmoncoin-modal').modal('show');
            },
            error: function(error) {}
        });
    });
    $("#addSalmoncoin").validate({
        rules: {
            minTHB: {
                required: true,
            },
            maxTHB: {
                required: true,
            },
            rate: {
                required: true,
                number:true
            }
        },
    });
    $('#addSalmoncoin').on('submit', function(e) {
            e.preventDefault();
            var fd = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{route('admin.salmoncoin.store')}}",
                data: fd,
                processData: false,
                contentType: false,
                success:function(data){
                    if(data=='1'){
                       toastr.success('Salmon Coin added successfully.');
                       getSalmoncoinList();
                       $('#add-salmoncoin-modal').modal('hide');
                    }
                    else{
                       toastr.error('something went wrong.');
                       $('#add-salmoncoin-modal').modal('hide');
                    }
                }
            });
    });
    $("#editSalmoncoin-from").validate({
        rules: {
            minTHB: {
                required: true,
            },
            maxTHB: {
                required: true,
            },
            rate: {
                required: true,
                number:true
            }
        },
    });
    $('#editSalmoncoin-from').on('submit', function(e) {
            e.preventDefault();
            var fd = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{route('admin.salmoncoin.update')}}",
                data: fd,
                processData: false,
                contentType: false,
                success:function(data){
                    if(data=='1'){
                       toastr.success('Salmon Coin edited successfully.');
                       getSalmoncoinList();
                       $('#edit-salmoncoin-modal').modal('hide');
                    }
                    else{
                       toastr.error('something went wrong.');
                       $('#edit-salmoncoin-modal').modal('hide');
                    }
                }
            });
    });
    $('body').on('click','#deleteSalmonCoin',function(){
        $('#del_id').val($(this).attr('data-id'));
        $('#type').val($(this).attr('data-type'));
        $('#salmoncoin-delete').modal('show');
    });
    $('.delete').on('click',function (e) {
        let confim=$(this).attr('data-id');
        let id=$('#del_id').val();   
        let type = $('#type').val();
        if(confim=="yes"){   
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.salmoncoin.delete')}}",
                method:'POST',
                data:{id:id},
                beforeSend: function() {
                // $("#loading-image").show();
                },
                success:function(data){
                    if(data == 1){
                        $('#salmoncoin-delete').modal('hide');
                        getSalmoncoinList();
                    }
                },error:function(error){
                    console.log(error);             
                }
            });
        }else{
            $('#salmoncoin-delete').modal('hide');
        }
    });

    $('body').on('click','#update_salmon_coin',function(e){
        $('#topupid').val($(this).data('id'));
        $('#eamount').val($(this).data('amount'));
        $('#ediamond').val($(this).data('user-salmon'));
        $('#topup_user_id').val($(this).data('user-id'));
        $('#salmon-topups-modal').modal('show');
        
    });

    $("#update_topups").validate({
        rules: {
            amount: {
                required: true,
            },
            diamond: {
                required: true,
            },
        },
    });

    $('body').on('submit','#update_topups',function(e){
        e.preventDefault();
        let id = $('#topupid').val();
        let user_id = $('#topup_user_id').val();
        let amount = $('#eamount').val();
        let salmoncoin = $('#ediamond').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{route('admin.topups.update')}}",
            method:'POST',
            data:{id:id,user_id:user_id,amount:amount,salmoncoin:salmoncoin},
            beforeSend: function() {
            // $("#loading-image").show();
            },
            success:function(data){
                if(data == 1){
                    $('#auditGemsList').DataTable().ajax.reload();
                    $('#salmon-topups-modal').modal('hide');
                }else if(data == 2){
                    toastr.error('Salmon Coin and amount is invalid!');
                }else{
                    toastr.error('Something went wrong.!');
                }
            },error:function(error){
                console.log(error);             
            }
        });
    });
     $(function(){
        $('select').searchableSelect();
    });
</script>
@endsection