<footer>
    <div class="container"></div>
</footer>
<!-- footer -->

<div class="modal fade" id="subadmin-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <img src="{{ URL::to('storage/app/public/Adminassets/image/close.svg') }}" alt="">
            </button>
            <div class="modal-body password-modal p-5">
                <div class="password-moda">
                    <h5 class="text-center mb-4">Add Sub-Admin</h5>
                    <form name="form_subadmin" id="form_subadmin" action="POST" enctype="multipart/form-data"
                        autocomplete="off">
                        <div class="avatar-upload mx-auto">
                            <div class="avatar-edit">
                                <input type='file' name="image" id="imageUpload" accept=".png, .jpg, .jpeg, .gif" />
                                <label for="imageUpload"></label>
                            </div>
                            <div class="avatar-preview">
                                <div>
                                    <img id="imagePreview"
                                        src="{{ URL::to('storage/app/public/uploads/users/default.png') }}">
                                </div>
                            </div>
                        </div>
                        <div class="login-input">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M20 22H4v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2zm-8-9a6 6 0 1 1 0-12 6 6 0 0 1 0 12z" />
                                </svg>
                            </span>
                            <input type="text" placeholder="Name" class="pr-3" name="name" id="name">
                        </div>
                        <span id="err-name" class="error"></span>
                        <div class="login-input">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm9.06 8.683L5.648 6.238 4.353 7.762l7.72 6.555 7.581-6.56-1.308-1.513-6.285 5.439z" />
                                </svg>
                            </span>
                            <input type="email" placeholder="Email" class="pr-3" name="email" id="email"
                                autocomplete="false">
                        </div>
                        <span id="err-email" class="error"></span>
                        <div class="login-input">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M21 16.42v3.536a1 1 0 0 1-.93.998c-.437.03-.794.046-1.07.046-8.837 0-16-7.163-16-16 0-.276.015-.633.046-1.07A1 1 0 0 1 4.044 3H7.58a.5.5 0 0 1 .498.45c.023.23.044.413.064.552A13.901 13.901 0 0 0 9.35 8.003c.095.2.033.439-.147.567l-2.158 1.542a13.047 13.047 0 0 0 6.844 6.844l1.54-2.154a.462.462 0 0 1 .573-.149 13.901 13.901 0 0 0 4 1.205c.139.02.322.042.55.064a.5.5 0 0 1 .449.498z" />
                                </svg>
                            </span>
                            <input type="text" placeholder="Phone Number" name="phone" id="phone" class="pr-3"
                                onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                        </div>
                        <span id="err-phone" class="error"></span>
                        <div class="login-input">
                            <span>
                                <svg id="door-lock-line_5_" data-name="door-lock-line (5)"
                                    xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25">
                                    <path id="Path_3" data-name="Path 3" d="M0,0H25V25H0Z" fill="none" />
                                    <path id="Path_4" data-name="Path 4"
                                        d="M12.622,23.244A10.622,10.622,0,1,1,23.244,12.622,10.622,10.622,0,0,1,12.622,23.244Zm0-2.124a8.5,8.5,0,1,0-8.5-8.5A8.5,8.5,0,0,0,12.622,21.12ZM11.56,13.463a2.656,2.656,0,1,1,2.124,0v3.408H11.56Z"
                                        transform="translate(-0.122 -0.122)" />
                                </svg>
                            </span>
                            <input type="password" placeholder="password" name="password" id="password"
                                class="pr-3" autocomplete="false">
                        </div>
                        <span id="err-password" class="error"></span>
                        <button type="submit" id="submit-add" class="btn btn-black">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="previewList" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body p-0">
                <div class="block-modal" id="img-list">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- bootstrap js -->
<script src="{{ URL::to('storage/app/public/Adminassets/js/jquery.min.js') }}"></script>
<script src="{{ URL::to('storage/app/public/Adminassets/js/bootstrap.bundle.min.js') }}"></script>
<!-- lazyload js -->
<script src="{{ URL::to('storage/app/public/Adminassets/js/jquery.lazyload.min.js') }}"></script>
<!-- datatables  js -->
<script src="{{ URL::to('storage/app/public/Adminassets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::to('storage/app/public/Adminassets/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- <script src="{{ URL::to('storage/app/public/Adminassets/js/dataTables.responsive.min.js') }}"></script> -->
<!-- <script src="{{ URL::to('storage/app/public/Adminassets/js/responsive.bootstrap4.min.js') }}"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js">
</script>
<!-- img-lazyload js -->
<script src="{{ URL::to('storage/app/public/Adminassets/js/lazyload.js') }}"></script>
<!-- custom js -->
<script src="{{ URL::to('storage/app/public/Adminassets/js/custom.js') }}"></script>

<!-- Toaster Js -->
<script src="{{ URL::to('storage/app/public/Adminassets/js/toastr.min.js') }}"></script>

<script type="text/javascript" src="{{ URL::to('storage/app/public/Adminassets/js/lottie.js') }}"></script>

<script type="text/javascript">
    let base_url = "{{ URL::to('/godmode') }}";
</script>
@yield('js')

<script type="text/javascript">
    $("#imageUpload").change(function() {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    };

    jQuery.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "No space please and don't leave it empty");

    $("#form_subadmin").validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                minlength: 10,
                maxlength: 15
            },
            password: {
                required: true,
                minlength: 6,
            }
        },
        messages: {
            name: {
                remote: "The name has already been taken."
            }
        },
    });
    $('body').on('submit', '#form_subadmin', function(e) {
        e.preventDefault();
        if ($("#form_subadmin").valid()) {
            var fd = new FormData(this);
            if ($('#imagePreview').attr('src') !=
                "{{ URL::to('storage/app/public/uploads/users/default.png') }}") {
                fd.append('images', $('#imagePreview').attr('src'));
            }
            // console.log($('.preview-img').attr('src'));
            $('#submit-add').prop('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.subadmin.store') }}",
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // $("#loading-image").show();
                },
                success: function(data) {
                    // $("#loading-image").hide();
                    $('#imagePreview').attr('src',
                        "{{ URL::to('storage/app/public/uploads/users/default.png') }}");
                    $('#submit-add').prop('disabled', false);
                    $('#form_subadmin')[0].reset();
                    $('.modal').modal('hide');
                    window.location.href = '{{ route('admin.subadmin') }}';

                },
                error: function(errors) {
                    $('#submit-add').prop('disabled', false);
                    $('.error').text('');
                    for (err in errors.responseJSON.errors) {
                        $('#err-' + err).text(errors.responseJSON.errors[err]);
                    }
                }
            });
            return false;
        }
    });

    $('body').on('click', '.imgsModel', function() {
        //admin.users.img.list
        form = new FormData();
        form.append('id', $(this).data('id'));
        form.append('_token', '{{ csrf_token() }}');
        $.ajax({
            url: "{{ route('admin.users.img.list') }}",
            method: 'POST',
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success: function(data) {
                // console.log(data);
                var list = ""
                $(data.data).each(function() {
                    list += "<img src={{ asset('storage/app/public/uploads/users/') }}" +
                        "/" + this + ">";
                })
                $("#img-list").html(list);
                $("#previewList").modal('show');
            },
            error: function(errors) {

            }
        });

    })
</script>

<script type="text/javascript">
    var amination = bodymovin.loadAnimation({
        container: document.getElementById('spinner'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: "{{ URL::to('storage/app/public/Adminassets/gif/data.json') }}"
    })
</script>
