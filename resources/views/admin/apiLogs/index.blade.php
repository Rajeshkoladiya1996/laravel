@extends('layouts.admin')
@section('title')
    API Logs
@endsection
@section('css')
@endsection
@section('content')

    <div class="main-title">
        <h4 id="title">Api/Web Logs</h4>
        <p id="total-count">{{ $logList->total() + $WeblogList->total() }} found</p>
    </div>
    <nav>
        <div class="nav nav-tabs my-nav" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active tab-listing" id="nav-Login-tab" data-toggle="tab" href="#nav-Login" role="tab"
                aria-controls="nav-Login" aria-selected="true" data-count="{{$logList->total()}}">Api Logs</a>
            <a class="nav-item nav-link tab-listing" id="nav-gems-tab" data-toggle="tab" href="#nav-gems" role="tab"
                aria-controls="nav-gems" aria-selected="false" data-count="{{$WeblogList->total()}}">Web Logs</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active auditList" id="nav-Login" role="tabpanel" aria-labelledby="nav-Login-tab">
            <div style="float: right">
                <a href="javascript:void(0)" class="btn btn-pink btn-header-pink" id="truncate_api_logs">Delete All</a>
            </div>
            @include('admin.apiLogs.apiList')
        </div>
        <div class="tab-pane fade gemsTopup" id="nav-gems" role="tabpanel" aria-labelledby="nav-gems-tab">
            <div style="float: right">
                <a href="javascript:void(0)" class="btn btn-pink btn-header-pink" id="truncate_web_logs">Delete All</a>
            </div>
            @include('admin.apiLogs.webList')
        </div>
    </div>
@endsection
@section('js')

    <!-- Rquest/Response data model -->
    <div class="modal fade blocked-user-list-modal" id="view-request" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
                        <img src="{{ URL::to('storage/app/public/Adminassets/image/close.svg') }}" alt="">
                    </button>
                    <h5 id="title_user_block">Request Body</h5>
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
    <script type="text/javascript">
        var ApiTable = null;
        $.fn.dataTable.ext.errMode = 'none';
        ApiTable = $("#apiLogList").DataTable({
            processing: true,
            pageLength: 10,
            aaSorting: [],
            responsive: true,
            serverSide: true,
            ordering: true,
            searching: true,

            "ajax": "{{ route('admin.apiLogs.apiLogList') }}",
            "columns": [{
                    "data": "username"
                },
                {
                    "data": "email"
                },
                {
                    "data": "uri"
                },
                {
                    "data": "response_status"
                },
                {
                    "data": "ip_address"
                },
                {
                    "data": "device_type"
                },
                {
                    "data": "date"
                },
                {
                    "data": "action",
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

        var WebTable = null;
        $.fn.dataTable.ext.errMode = 'none';
        WebTable = $("#webLogList").DataTable({
            processing: true,
            pageLength: 10,
            aaSorting: [],
            responsive: true,
            serverSide: true,
            ordering: true,
            searching: true,

            "ajax": "{{ route('admin.webLogs.webLogList') }}",
            "columns": [{
                    "data": "username"
                },
                {
                    "data": "email"
                },
                {
                    "data": "uri",
                    render: function(data) {
                        var obj =
                            '<textarea disabled>' + data.replaceAll(',', ' ').replaceAll('\\/', '/') +
                            '</textarea>';
                        return obj;
                    }
                },
                {
                    "data": "response_status"
                },
                {
                    "data": "ip_address"
                },
                {
                    "data": "browser",
                    render: function(data) {
                        var obj =
                            '<textarea disabled>' + data +
                            '</textarea>';
                        return obj;
                    }
                },
                {
                    "data": "date"
                },
                {
                    "data": "action",
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


        $("#apiLogList").DataTable();
        $("#webLogList").DataTable();

        $('body').on('click', '#view-request-body', function(e) {
            let id = $(this).attr('data-id');
            $('#view-request').modal('show');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.apiLogs.requestBody') }}",
                type: 'POST',
                data: {
                    'id': id
                },
                success: function(response) {
                    let blockUserList = `<div class="user-blocklist-content"><ul>`;
                    const Obj = response.data;
                    let list = ``;
                    Object.keys(Obj).forEach(function(key) {
                        // console.log(key +" : "+Obj)
                        list += `<p>${key} : ${Obj[key]}</p>`;
                    })
                    if (list != ``) {
                        blockUserList += list + `</ul></div>`;
                    } else {
                        blockUserList += `<p>Not data</p></ul></div>`;
                    }
                    $('#block-user-list-data').html(blockUserList);

                },
                error: function(errors) {
                    //    console.log(errors);
                }
            });

        });

        $('body').on('click', '#view-web-request-body', function(e) {
            let id = $(this).attr('data-id');
            $('#view-request').modal('show');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.webLogs.requestBody') }}",
                type: 'POST',
                data: {
                    'id': id
                },
                success: function(response) {
                    let blockUserList = `<div class="user-blocklist-content"><ul>`;
                    const Obj = response.data;
                    let list = ``;
                    Object.keys(Obj).forEach(function(key) {
                        // console.log(key +" : "+Obj)
                        list += `<p>${key} : ${Obj[key]}</p>`;
                    })
                    console.log(list);
                    if (list != ``) {
                        blockUserList += list + `</ul></div>`;
                    } else {
                        blockUserList += `<p>Not data</p></ul></div>`;
                    }
                    $('#block-user-list-data').html(blockUserList);

                },
                error: function(errors) {
                    //    console.log(errors);
                }
            });

        });

        $('body').on('click', '#view-response', function(e) {
            let id = $(this).attr('data-id');
            $('#view-request').modal('show');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.apiLogs.response') }}",
                type: 'POST',
                data: {
                    'id': id
                },
                success: function(response) {
                    let blockUserList = `<div class="user-blocklist-content"><ul>`;
                    const Obj = response.data;
                    let list = ``;
                    Object.keys(Obj).forEach(function(key) {
                        // console.log(key +" : "+Obj)
                        list += `<p>${key} : ${JSON.stringify(Obj[key])}</p>`;
                    })
                    if (list != ``) {
                        blockUserList += list + `</ul></div>`;
                    } else {
                        blockUserList += `<p>Not data</p></ul></div>`;
                    }
                    $('#block-user-list-data').html(blockUserList);

                },
                error: function(errors) {
                    //    console.log(errors);
                }
            });

        });

        $('body').on('click', '#view-web-response', function(e) {
            let id = $(this).attr('data-id');
            $('#view-request').modal('show');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.webLogs.response') }}",
                type: 'POST',
                data: {
                    'id': id
                },
                success: function(response) {
                    let blockUserList = `<div class="user-blocklist-content"><ul>`;
                    const Obj = response.data;
                    let list = ``;
                    Object.keys(Obj).forEach(function(key) {
                        // console.log(key +" : "+Obj)
                        list += `<p>${key} : ${JSON.stringify(Obj[key])}</p>`;
                    })
                    if (list != ``) {
                        blockUserList += list + `</ul></div>`;
                    } else {
                        blockUserList += `<p>Not data</p></ul></div>`;
                    }
                    $('#block-user-list-data').html(blockUserList);

                },
                error: function(errors) {
                    //    console.log(errors);
                }
            });

        });


        $('body').on('click', '#delete-log', function(e) {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.apiLogs.delete') }}",
                    type: 'POST',
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        if (response == 1) {
                            toastr.success('api log delete successfully.');
                        } else {
                            toastr.error('Something went wrong.');
                        }
                        ApiTable.ajax.reload(false);
                    },
                    error: function(errors) {
                        //    console.log(errors);
                    }
                });
            }
        });

        $('body').on('click', '#delete-web-log', function(e) {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.webLogs.delete') }}",
                    type: 'POST',
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        if (response == 1) {
                            toastr.success('api log delete successfully.');
                        } else {
                            toastr.error('Something went wrong.');
                        }
                        WebTable.ajax.reload(false);
                    },
                    error: function(errors) {
                        //    console.log(errors);
                    }
                });
            }
        });

        $('body').on('click', '#truncate_api_logs', function(e) {
            if (confirm('Are you sure you want to delete All record?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.apiLogs.delete.all') }}",
                    type: 'POST',
                    success: function(response) {
                        if (response == 1) {
                            toastr.success('api log delete successfully.');
                        } else {
                            toastr.error('Something went wrong.');
                        }
                        ApiTable.ajax.reload(false);
                    },
                    error: function(errors) {
                        //    console.log(errors);
                    }
                });
            }
        });

        $('body').on('click', '#truncate_web_logs', function(e) {
            if (confirm('Are you sure you want to delete All record?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.webLogs.delete.all') }}",
                    type: 'POST',
                    success: function(response) {
                        if (response == 1) {
                            toastr.success('api log delete successfully.');
                        } else {
                            toastr.error('Something went wrong.');
                        }
                        WebTable.ajax.reload(false);
                    },
                    error: function(errors) {
                        //    console.log(errors);
                    }
                });
            }
        });
    </script>
@endsection
