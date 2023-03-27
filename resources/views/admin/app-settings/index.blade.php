@extends('layouts.admin')
@section('title')
    Tags
@endsection
@section('css')
@endsection
@section('content')

    <div class="main-title">
        <h4 id="title">App Settings</h4>
    </div>
    <div id="appSettingList"></div>

    <div class="row">
        <div class="col-lg-6 m-0" >
            <div id="main-title" class="row">
                <div class="col-lg-6">
                    <h5>Hot Tag Setting</h5>
                </div>
            </div>
            <div id="hotTagListData">
            </div>
        </div>
        <div class="col-lg-6 m-0" >
            <div id="main-title" class="row">
                <div class="col-lg-6">
                    <h5>Social Media</h5>
                </div>
            </div>
            <div id="socialMedia">
            </div>
        </div>
    </div>
@endsection

@section('js')
<div class="modal fade" id="add-setting-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body password-modal py-5 px-2 p-md-5">
                <div class="password-moda">
                    <h5 class="text-center">App Settings Edit</h5>
                    <form name="editappssetting_from" id="editappssetting_from">
                        <div class="login-input no-icon">
                            <input type="hidden" name="id" id="app_id">
                            <select class="pr-3"  id="device_types" name="device_type">
                                <option value="Android">Android</option>
                                <option value="iOS">iOS</option>
                            </select>
                            <span id="err-device_type" class="error"></span>
                        </div>
                        <div class="login-input no-icon">
                            <input type="text" placeholder="App Version" class="pr-3" name="app_version" id="app_version">
                            <span id="err-app_version" class="error"></span>
                        </div>
                        <div class="login-input no-icon">
                            <input type="text" placeholder="Contant update day" class="pr-3" name="contant_update_day" id="contant_update_day">
                            <span id="err-contant_update_day" class="error"></span>
                        </div>
                        <div class="login-input no-icon">
                            <input type="text" placeholder="Message" class="pr-3" name="message" id="message">
                            <span id="err-message" class="error"></span>
                        </div>
                        <div class="login-input no-icon">
                            <select class="pr-3"  id="update_force" name="update_force">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            <span id="err-update_force" class="error"></span>
                        </div> 
                        <div class="login-input no-icon">
                            <select class="pr-3"  id="is_productions" name="is_production">
                                <option value="0">Off</option>
                                <option value="1">On</option>
                            </select>
                            <span id="err-is_production" class="error"></span>
                        </div>
                        
                        </div>
                        <button type="submit" class="btn btn-black" id="editappssetting_from_button">Update</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="app-update-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body p-0">
                <input type="hidden" name="hid" id="id">
                <input type="hidden" name="status" id="hidstatus">
                <div class="block-modal">
                    <h5 id="title_user_paid">Force Update </h5>
                    <p id="msg"></p>
                    <div class="block-btn">
                        <a href="javascript:void(0)" id="app_update_btn" class="btn btn-black">Yes</a>
                        <a href="javascript:void(0)" class="btn btn-red" data-dismiss="modal">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="app-production-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body p-0">
                <input type="hidden" name="hid" id="id">
                <input type="hidden" name="status" id="pidstatus">
                <div class="block-modal">
                    <h5 id="title_user_paid">Production Mode </h5>
                    <p id="msg-production"></p>
                    <div class="block-btn">
                        <a href="javascript:void(0)" id="app_production" class="btn btn-black">Yes</a>
                        <a href="javascript:void(0)" class="btn btn-red" data-dismiss="modal">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="app-festive-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body p-0">
                <input type="hidden" name="fhid" id="fid">
                <input type="hidden" name="fstatus" id="fidstatus">
                <div class="block-modal">
                    <h5 id="title_user_paid">Festive Mode </h5>
                    <p id="msg-festive"></p>
                    <div class="block-btn">
                        <a href="javascript:void(0)" id="app_festive" class="btn btn-black">Yes</a>
                        <a href="javascript:void(0)" class="btn btn-red" data-dismiss="modal">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="app-develop-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
            </button>
            <div class="modal-body p-0">
                <input type="hidden" name="dhid" id="did">
                <input type="hidden" name="dstatus" id="didstatus">
                <div class="block-modal">
                    <h5 id="title_user_paid">Develop Mode </h5>
                    <p id="msg-develop"></p>
                    <div class="block-btn">
                        <a href="javascript:void(0)" id="app_develop" class="btn btn-black">Yes</a>
                        <a href="javascript:void(0)" class="btn btn-red" data-dismiss="modal">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-hotTag-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                    <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
                </button>
                <div class="modal-body password-modal py-5 px-2 p-md-5">
                    <div class="password-moda">
                        <h5 class="text-center">Edit Hot Tag Setting </h5>
                        
                        <form id="editHotTag-form" type="post" class="gems-assign-form mt-4 mb-0">
                            <div class="assign-input login-input">
                                <input type="text" name="follower" id="follower" placeholder="Enter Followers" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9)  return false;"/>
                            </div>
                            <div class="assign-input login-input">
                                <input type="text" name="salmonCoin" id="salmonCoin" placeholder="Enter Salmon Coin" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9)  return false;"/>
                            </div>
                            <input type="hidden" name="htid" id="htid" >
                            <input type="submit" class="btn btn-black" value="Update" id="editHotTag-form_button"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

    <script type="text/javascript">
        getAppsettings();
        getHotTagSetting();
        getSocialMedia();
        function getAppsettings(){
            $.ajax({
                url: "{{route('admin.app.settings.list')}}",
                method: 'GET',
                beforeSend: function() {
                    // $("#loading-image").show();
                },
                success: function(data) {
                    // $("#loading-image").hide();
                    $('#appSettingList').html(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        function getHotTagSetting(){
            $.ajax({
                url: "{{route('admin.hottag.settings')}}",
                method: 'GET',
                beforeSend: function() {
                    // $("#loading-image").show();
                },
                success: function(data) {
                    // $("#loading-image").hide();
                    $('#hotTagListData').html(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        function getSocialMedia(){
            $.ajax({
                url: "{{route('admin.socialmedia')}}",
                method: 'GET',
                beforeSend: function() {
                    // $("#loading-image").show();
                },
                success: function(data) {
                    // $("#loading-image").hide();
                    $('#socialMedia').html(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        $('body').on('submit', '#updateSocialMedia',function(e) {
            e.preventDefault();
            var fd = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{route('admin.socialmedia.update')}}",
                data: fd,
                processData: false,
                contentType: false,
                success:function(data){
                    // $(':input','#addTag')
                    // .not(':button, :submit, :reset, :hidden')
                    // .val('');
                    if(data=='1'){
                        toastr.success('Social Media updated successfully.');
                        getSocialMedia();
                    }
                },
                error: function(errors) {
				}
            });
        });

        $('body').on('click', '.is_app', function(e) {
            $('#id').val($(this).data('id'));
            $('#hidstatus').val($(this).attr('data-status'));
            if($(this).data('status')==0){
                $('#msg').text('Are you sure to stop force update for '+ $(this).data('type') +' app?');
            }else{
                $('#msg').text('Are you sure to start force update for '+ $(this).data('type') +' app?');
            }
            $('#app-update-model').modal('show');
        });

        $('body').on('click', '.is_production', function(e) {
            $('#id').val($(this).data('id'));
            $('#pidstatus').val($(this).attr('data-status'));
            if($(this).data('status')==0){
                $('#msg-production').text('Are you sure to stop production for '+ $(this).data('type') +' app?');
            }else{
                $('#msg-production').text('Are you sure to start production for '+ $(this).data('type') +' app?');
            }
            $('#app-production-model').modal('show');
        });

        $('body').on('click', '.is_festive', function(e) {
            $('#fid').val($(this).data('id'));
            $('#fidstatus').val($(this).attr('data-status'));
            if($(this).data('status')==1){
                $('#msg-festive').text('Are you sure to stop festive for '+ $(this).data('type') +' app?');
            }else{
                $('#msg-festive').text('Are you sure to start festive for '+ $(this).data('type') +' app?');
            }
            $('#app-festive-model').modal('show');
        });

        $('body').on('click', '.is_develop', function(e) {
            $('#did').val($(this).data('id'));
            $('#didstatus').val($(this).attr('data-status'));
            if($(this).data('status')==1){
                $('#msg-develop').text('Are you sure to stop develop for '+ $(this).data('type') +' app?');
            }else{
                $('#msg-develop').text('Are you sure to start develop for '+ $(this).data('type') +' app?');
            }
            $('#app-develop-model').modal('show');
        });


        $('#editappssetting_from').on('submit', function(e) {
            e.preventDefault();
            $('#editappssetting_from_button').prop("disabled", true);
            var fd = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{route('admin.app.settings.update')}}",
                data: fd,
                processData: false,
                contentType: false,
                success:function(data){
                    if(data=='1'){
                       toastr.success('App setting changes successfully.');
                       getAppsettings();
                       $('#add-setting-modal').modal('hide');
                    }
                    else{
                       toastr.error('something went wrong.');
                       $('#add-setting-modal').modal('hide');
                    }
                }
            });
        });


        $('body').on('click', '#editAppSetting', function() {
            $('#editappssetting_from_button').prop("disabled", false);
            let id = $(this).attr('data-id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{URL::to('godmode/app-settings/edit')}}" + "/" + id,
                method: 'GET',
                beforeSend: function() {
                    // $("#loading-image").show();
                },
                success: function(data) {
                    $('#app_id').val(data.id);
                    $('#app_version').val(data.app_version);
                    $('#contant_update_day').val(data.contant_update_day);
                    $('#message').val(data.message);
                    $('#device_types option[value="'+data.device_type+'"]').attr('selected','selected');
                    $('#update_force option[value="'+data.update_force+'"]').attr('selected','selected');
                    $('#is_productions option[value="'+data.is_production+'"]').attr('selected','selected');
                    $('#add-setting-modal').modal('show');
                },
                error: function(errors) {
                    
                }
            });
        });

        $('body').on('click','#app_update_btn',function(){
            let id = $('#id').val();
            let status = $('#hidstatus').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('admin.app.settings.update-Status')}}",
                method: 'POST',
                data:{
                    id:id,
                    update_force:status
                },
                beforeSend: function() {},
                success: function(data) {
                    $('#app-update-model').modal('hide');
                   getAppsettings();
                },
                error: function(error) {}
            });
        });

        $('body').on('click','#app_production',function(){
            let id = $('#id').val();
            let status = $('#hidstatus').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('admin.app.settings.production-status')}}",
                method: 'POST',
                data:{
                    id:id,
                    is_production:status
                },
                beforeSend: function() {
                    // $("#loading-image").show();
                },
                success: function(data) {
                    $('#app-production-model').modal('hide');
                   getAppsettings();
                },
                error: function(error) {}
            });
        });

        $('body').on('click','#app_festive',function(){
            let id = $('#fid').val();
            let status = $('#fidstatus').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('admin.app.settings.festive-status')}}",
                method: 'POST',
                data:{
                    id:id,
                    is_festival:status
                },
                beforeSend: function() {
                    // $("#loading-image").show();
                },
                success: function(data) {
                    $('#app-festive-model').modal('hide');
                   getAppsettings();
                },
                error: function(error) {}
            });
        });

        $('body').on('click','#app_develop',function(){
            let id = $('#did').val();
            let status = $('#didstatus').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('admin.app.settings.develop-status')}}",
                method: 'POST',
                data:{
                    id:id,
                    is_develop:status
                },
                beforeSend: function() {
                    // $("#loading-image").show();
                },
                success: function(data) {
                    $('#app-develop-model').modal('hide');
                   getAppsettings();
                },
                error: function(error) {}
            });
        });

        $("#editHotTagSetting").validate({
            rules: {
                follower: {
                    required: true,
                },
                salmonCoin: {
                    required: true,
                }
            }
        });
        $('body').on('click', '#editHotTagSetting', function() {
            let id = $(this).attr('data-id');
            $('#editHotTag-form_button').prop("disabled", false);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{URL::to('godmode/app-settings/editHotTag/')}}" + "/" + id,
                method: 'GET',
                beforeSend: function() {},
                success: function(data) {
                    $('#follower').val(data.followers);
                    $('#salmonCoin').val(data.salmon_coin);
                    $('#htid').val(data.id);

                    $('#edit-hotTag-modal').modal('show');
                },
                error: function(error) {}
            });
        });
        $('#editHotTag-form').on('submit', function(e) {
            e.preventDefault();
            $('#editHotTag-form_button').prop("disabled", true);
            var fd = new FormData(this);
            
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{route('admin.hottag.update')}}",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data=='1'){
                            toastr.success('Hot Tag Setting updated successfully.');
                            getHotTagSetting();
                            $('#edit-hotTag-modal').modal('hide');
                        }
                        else{
                            toastr.error('something went wrong.');
                            $('#edit-hotTag-modal').modal('hide');
                            $('#editHotTag-form_button').prop("disabled", false);
                        }
                    }
                });
        });
    </script>
@endsection

