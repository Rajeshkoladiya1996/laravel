@extends('layouts.admin')
@section('title')
    Package
@endsection
@section('css')
@endsection
@section('content')

    <div class="main-title">
        <h4 id="title">Package Management</h4>
        <div id="level-point-btn">
            <a href="javascript:void(0)" class="btn btn-pink btn-header-pink add-package-model"> + Add Package</a>
        </div>
    </div>
    <div id="packageList"></div>

@endsection
@section('js')

    <div class="modal fade" id="add-package-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                    <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
                </button>
                <div class="modal-body password-modal py-5 px-2 p-md-5">
                    <div class="password-moda">
                        <h5 class="text-center">Add Package </h5>
                        <form id="addPackage" type="post" class="gems-assign-form mt-4 mb-0">
                            <div class="assign-input login-input">
                                <input type="text" name="package_name" id="package_name" placeholder="Enter package name" onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode != 32) return false;"/>
                            </div>
                            <span class="error" id="err-package_name"></span>
                            <div class="assign-input login-input">
                                <input type="text" name="salmon_coin" id="salmon_coin" placeholder="Enter salmon coin" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;"/>
                            </div>
                            <span class="error" id="err-salmon_coin"></span>
                            <div class="assign-input login-input">
                                <input type="text" name="price" id="price" placeholder="Enter price($)" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode!=46) return false;"/>
                            </div>
                            <span class="error" id="err-price"></span>
                            <div class="assign-input login-input">
                                <input type="text" name="sgd_price" id="sgd_price" placeholder="Enter SGD price(S$)" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode!=46) return false;"/>
                            </div>
                            <span class="error" id="err-sgd_price"></span>
                            <div class="assign-input login-input">
                                <input type="text" name="thai_price" id="thai_price" placeholder="Enter thai price(฿)" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode!=46) return false;"/>
                            </div>
                            <span class="error" id="err-thai_price"></span>
                            <div class="assign-input login-input">
                                <input type="text" name="ios_product_id" id="ios_product_id" placeholder="Enter ios product id"  onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode != 95) if(event.keyCode!=46) return false;"/>
                            </div>
                            <span class="error" id="err-ios_product_id"></span>
                            <div class="assign-input login-input">
                                <input type="text" name="android_product_id" id="android_product_id" placeholder="Enter android product id"  onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode != 95) if(event.keyCode!=46) return false;"/>
                            </div>
                            <span class="error" id="err-android_product_id"></span>
                            <div class="gift-input">
                                <label for="package_image" class="gift-label">
                                    <input type="file" id="package_image" class="up-image" name="package_image">
                                    <div class="upload-box upload-box2">
                                        <span class="smaller-img"><img class="preview-img preview-img_gif" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                                        <h6>Upload Image</h6>
                                    </div>
                                    <span id="err-package_image" class="error"></span>
                                </label>
                            </div>
                            
                            <input type="submit" class="btn btn-black" value="Save" id="addpackage_button" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-package-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                    <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
                </button>
                <div class="modal-body password-modal py-5 px-2 p-md-5">
                    <div class="password-moda">
                        <h5 class="text-center">Update Package </h5>
                        <form id="editPackage" type="post" class="gems-assign-form mt-4 mb-0">
                            <input type="hidden" name="id" id="update_id" /> 
                            <div class="assign-input login-input">
                                <input type="text" name="edit_package_name" id="edit_package_name" placeholder="Enter package name" onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode != 32) return false;"/>
                            </div>
                            <span class="error" id="err-edit-edit_package_name"></span>
                            <div class="assign-input login-input">
                                <input type="text" name="edit_salmon_coin" id="edit_salmon_coin" placeholder="Enter salmon coin" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;"/>
                            </div>
                            <span class="error" id="err-edit-edit_salmon_coin"></span>
                            <div class="assign-input login-input">
                                <input type="text" name="edit_price" id="edit_price" placeholder="Enter price($)" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode!=46) return false;"/>
                            </div>
                            <span class="error" id="err-edit-edit_price"></span>
                            <div class="assign-input login-input">
                                <input type="text" name="edit_sgd_price" id="edit_sgd_price" placeholder="Enter SGD price(S$)" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode!=46) return false;"/>
                            </div>
                            <span class="error" id="err-edit-edit_sgd_price"></span>
                            <div class="assign-input login-input">
                                <input type="text" name="edit_thai_price" id="edit_thai_price" placeholder="Enter thai price(฿)" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode!=46) return false;"/>
                            </div>
                            <span class="error" id="err-edit-edit_thai_price"></span>
                            <div class="assign-input login-input">
                                <input type="text" name="edit_ios_product_id" id="edit_ios_product_id" placeholder="Enter ios product id" onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode != 95) if(event.keyCode!=46) return false;" />
                            </div>
                            <span class="error" id="err-edit-edit_ios_product_id"></span>
                            <div class="assign-input login-input">
                                <input type="text" name="edit_android_product_id" id="edit_android_product_id" placeholder="Enter android product id"onkeypress="if(event.which < 65 || event.which > 90 ) if(event.which <97 || event.which > 122) if(event.which < 48 || event.which >57 ) if(event.which != 8) if(event.keyCode != 9) if(event.keyCode != 95) if(event.keyCode!=46) return false;" />
                            </div>
                            <span class="error" id="err-edit-edit_android_product_id"></span>
                            
                            <div class="gift-input">
                                <label for="edit_package_image" class="gift-label">
                                    <input type="file" id="edit_package_image" class="up-image" name="edit_package_image">
                                    <div class="upload-box upload-box2">
                                        <span class="smaller-img"><img class="preview-img preview-package_img_edit" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                                        <h6>Upload Image</h6>
                                    </div>
                                    <span id="err-edit-edit_package_image" class="error"></span>
                                </label>
                            </div>
                            <input type="submit" class="btn btn-black" value="Update" id="editpackage_button" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="package-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                <h5>Delete Package</h5>
                <p>Are you sure you want to delete this Package.</p>
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

    <div class="modal fade" id="ios-status-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                <h5>Change IOS Status</h5>
                <p>Are you sure you want to Change Status of this IOS package.</p>
                <input type="hidden" name="ios_id" id="ios_id">
                <input type="hidden" name="ios_status" id="ios_status">
                <div class="block-btn">
                    <a href="javascript:void(0)" class="btn btn-black ioschange" data-id="yes">Yes</a>
                    <a href="javascript:void(0)" class="btn btn-red ioschange" data-id="no">No</a>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="android-status-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal">
                <h5>Change Android Status</h5>
                <p>Are you sure you want to Change Status of this android package.</p>
                <input type="hidden" name="android_id" id="android_id">
                <input type="hidden" name="android_status" id="android_status">
                <div class="block-btn">
                    <a href="javascript:void(0)" class="btn btn-black androidchange" data-id="yes">Yes</a>
                    <a href="javascript:void(0)" class="btn btn-red androidchange" data-id="no">No</a>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        getPackagesList();
        function getPackagesList(){
            $.ajax({
                url: "{{route('admin.package.list')}}",
                method: 'GET',
                beforeSend: function() {
                    // $("#loading-image").show();
                },
                success: function(data) {
                    // $("#loading-image").hide();
                    $('#packageList').html(data);
                    $("#PackageListTable").DataTable();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        

        $("#package_image").change(function() {
            readURLimage(this);       
        });

        function readURLimage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                const type = input.files[0].type.split('/');
                $('#err-package_image').text("");
                $('#package_image-error').text("");
                if (type[0] == 'image') {
                    reader.onload = function(e) {
                        $('.preview-img_gif').attr('src', e.target.result);
                    }
                    if(type[1]=='jpeg' || type[1]=="png" || type[1]=="jpg"){
                        
                    }else{
                        toastr.error('Invalid File input.');
                        $('#err-package_image').text("The package image must be a file of type: jpeg, png, jpg.");
                    }
                }else {
                    $('#err-package_image').text("The package image must be a file of type: jpeg, png, jpg.");
                    toastr.error('Invalid File input.')
                    return false;
                }


                reader.readAsDataURL(input.files[0]);
            }
        };

        $("#edit_package_image").change(function() {
            readURLEditimage(this);       
        });

        function readURLEditimage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                const type = input.files[0].type.split('/');
                $('#err-edit-edit_package_image').text("");
                if (type[0] == 'image') {
                    reader.onload = function(e) {
                        $('.preview-package_img_edit').attr('src', e.target.result);
                    }
                    if(type[1]=='jpeg' || type[1]=="png" || type[1]=="jpg"){
                        
                    }else{
                        toastr.error('Invalid File input.');
                        $('#err-edit-edit_package_image').text("The package image must be a file of type: jpeg, png, jpg.");
                    }
                }else {
                    $('#err-edit-edit_package_image').text("The package image must be a file of type: jpeg, png, jpg.");
                    toastr.error('Invalid File input.')
                    return false;
                }


                reader.readAsDataURL(input.files[0]);
            }
        };
        
        $('body').on('click', '.add-package-model', function() {
            $('.error').text("");

            $('#package_name').val("");
            $('#salmon_coin').val("");
            $('#package_image').val("");
            $('#ios_product_id').val("");
            $('#android_product_id').val("");
            $('#price').val("");
            $('#sgd_price').val("");
            $('#thai_price').val("");
            $('.preview-img_gif').attr('src',"{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");

            $('#add-package-modal').modal('show');
            $('#addpackage_button').prop("disabled", false);
        });

        $("#addPackage").validate({
            rules: {
                package_name: {
                    required: true,
                },
                salmon_coin: {
                    required: true,
                },
                package_image: {
                    required: true,
                },
                price: {
                    required: true,
                },
                sgd_price:{
                    required: true,
                },
                thai_price:{
                    required: true,
                },
            },
        });

        $('#addPackage').on('submit', function(e) {
            e.preventDefault();
            $('.error').text("");
            $('#addpackage_button').prop("disabled", true);
            if($("#addPackage").valid()){  
                var fd = new FormData(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{route('admin.package.store')}}",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        // $(':input','#addTag')
                        // .not(':button, :submit, :reset, :hidden')
                        // .val('');
                        if(data=='1'){
                            toastr.success('Package added successfully.');
                            getPackagesList();
                            $('#add-package-modal').modal('hide');
                        }
                        else{
                            $('#addpackage_button').prop("disabled", false);
                            toastr.error('something went wrong.');
                            $('#add-package-modal').modal('hide');
                        }
                        
                    },
                    error: function(errors) {
                        $('#addpackage_button').prop("disabled", false);
                        for(error in errors.responseJSON.errors){
                            console.log('#err-'+error+':'+errors.responseJSON.errors[error]);
                            $('#err-'+error).text(errors.responseJSON.errors[error]);
                            
                        }
                        // console.log(error);
                    }
                });
            }else{
                $('#addpackage_button').prop("disabled", false);
            }
            
        });

        

        $('#editPackage').on('submit', function(e) {
            e.preventDefault();
            $('.error').text("");
            $('#editpackage_button').prop("disabled", true);
                var fd = new FormData(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{route('admin.package.update')}}",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data=='1'){
                            toastr.success('Package updated successfully.');
                            getPackagesList();
                            
                            $(':input','#editTag-from')
                            .not(':button, :submit, :reset, :hidden')
                            .val('');

                            $('#edit_package_name-error').text("");
                            $('#edit_salmon_coin-error').text("");
                            $('#edit_price-error').text("");
                            $('#err-edit-edit_package_image').text("");
                            $('#edit-package-modal').modal('hide');
                        }else{
                            $('#editpackage_button').prop("disabled", false);
                            toastr.error('something went wrong.');
                            $('#edit-package-modal').modal('hide');
                        }
                    },
                    error: function(errors) {
                        console.log(errors);
                        $('#editpackage_button').prop("disabled", false);
                        for(error in errors.responseJSON.errors){
                            console.log('#err-edit-'+error);
                            $('#err-edit-'+error).text(errors.responseJSON.errors[error]);
                        }
                        // console.log(error);
                    }
                });
        });


        $('body').on('click', '.editPackage', function() {
            $('#editpackage_button').prop("disabled", false);
            $('.error').text("");
            let id = $(this).attr('data-id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{URL::to('godmode/package/edit/')}}" + "/" + id,
                method: 'GET',
                beforeSend: function() {},
                success: function(data) {
                    console.log(data);
                    $('#update_id').val(data.packageDetail.id);
                    $('#edit_package_name').val(data.packageDetail.name);
                    $('#edit_salmon_coin').val(data.packageDetail.salmon_coin);
                    $('.preview-package_img_edit').attr('src',"{{URL::to('storage/app/public/uploads/package')}}"+"/"+data.packageDetail.image);
                    $('#edit_ios_product_id').val(data.packageDetail.ios_product_id);
                    $('#edit_android_product_id').val(data.packageDetail.android_product_id);
                    $('#edit_price').val(data.packageDetail.price);
                    $('#edit_sgd_price').val(data.packageDetail.SGD_price   );
                    $('#edit_thai_price').val(data.packageDetail.thai_price);

                   $('#edit-package-modal').modal('show');
                },
                error: function(error) {}
            });
        });

        $('body').on('click','#deletePackage',function(){
            $('#del_id').val($(this).attr('data-id'));
            $('#type').val($(this).attr('data-type'));
            $('#package-delete').modal('show');
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
                    url:"{{route('admin.package.delete')}}",
                    method:'POST',
                    data:{id:id},
                    beforeSend: function() {
                    // $("#loading-image").show();
                    },
                    success:function(data){
                        if(data == 1){
                            $('#package-delete').modal('hide');
                            getPackagesList();
                        }
                    },error:function(error){
                        console.log(error);             
                    }
                });
            }else{
                $('#package-delete').modal('hide');
            }
        });

        // ios Status
    $('body').on('click','.ios-status',function(){
        $('#ios_id').val($(this).attr('data-id'));
        $('#ios_status').val($(this).attr('data-status'));
        $('#ios-status-model').modal('show');
    })
    $('body').on('click','.ioschange',function(){
        let status = $('#ios_status').val();
        let confim=$(this).attr('data-id');
        let id=$('#ios_id').val();
            if(confim=="yes"){
                console.log("yes");  
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('admin.package.ios.status') }}",
                    method:'POST',
                    data:{id:id,status:status},
                    beforeSend: function() {
                        // $("#loading-image").show();
                    },
                    success:function(data){
                        if(data == 1){
                            $('#ios-status-model').modal('hide');
                            getPackagesList();
                        }else{
                            
                        }
                    },error:function(error){
                    }
                });
            }else{
                $('#ios-status-model').modal('hide');
            }
    });

        // android Status
    $('body').on('click','.android-status',function(){
        $('#android_id').val($(this).attr('data-id'));
        $('#android_status').val($(this).attr('data-status'));
        $('#android-status-model').modal('show');
    })
    $('body').on('click','.androidchange',function(){
        let status = $('#android_status').val();
        let confim=$(this).attr('data-id');
        let id=$('#android_id').val();
            if(confim=="yes"){
                console.log("yes");  
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('admin.package.android.status') }}",
                    method:'POST',
                    data:{id:id,status:status},
                    beforeSend: function() {
                        // $("#loading-image").show();
                    },
                    success:function(data){
                        if(data == 1){
                            $('#android-status-model').modal('hide');
                            getPackagesList();
                        }else{
                            
                        }
                    },error:function(error){
                    }
                });
            }else{
                $('#android-status-model').modal('hide');
            }
    });
    </script>
@endsection


