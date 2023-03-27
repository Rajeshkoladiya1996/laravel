<table id="TagList" class="table table-striped table-bordered dt-responsive nowrap mytabel"
    style="width:100%">
    <thead>
        <tr>
            <th>Device Type</th>
            <th>App Version</th>
            <th>Contant Update Day</th>
            <th>Update Force</th>
            <th>Is Production</th>
            <th>Is Festive</th>
            <th>Is Develop</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataList as $data)
            <tr>
                <td>{{$data->device_type}}</td>
                <td>{{$data->app_version}}</td>
                <td>{{$data->contant_update_day}}</td>
                <td>
                    @if($data->update_force==0)
                        <p class="pending is_app" data-id='{{$data->id}}' data-status="{{$data->update_force}}" data-type="{{$data->device_type}}">
                            No
                        </p>
                    @else
                        <p class="paid is_app" data-id='{{$data->id}}' data-status="{{$data->update_force}}" data-type="{{$data->device_type}}">
                            Yes
                        </p>
                    @endif
                </td>
                <td>
                    @if($data->is_production==0)
                        <p class="paid is_production" data-id='{{$data->id}}' data-status="{{$data->is_production}}" data-type="{{$data->device_type}}">
                            Off
                        </p>
                    @else
                        <p class="pending is_production" data-id='{{$data->id}}' data-status="{{$data->is_production}}" data-type="{{$data->device_type}}">
                            On
                        </p>
                    @endif
                </td>
                <td>
                    @if($data->is_festival==0)
                        <p class="paid is_festive" data-id='{{$data->id}}' data-status="{{$data->is_festival}}" data-type="{{$data->device_type}}">
                            Off
                        </p>
                    @else
                        <p class="pending is_festive" data-id='{{$data->id}}' data-status="{{$data->is_festival}}" data-type="{{$data->device_type}}">
                            On
                        </p>
                    @endif
                </td>
                <td>
                    @if($data->is_develop==0)
                        <p class="paid is_develop" data-id='{{$data->id}}' data-status="{{$data->is_develop}}" data-type="{{$data->device_type}}">
                            Off
                        </p>
                    @else
                        <p class="pending is_develop" data-id='{{$data->id}}' data-status="{{$data->is_develop}}" data-type="{{$data->device_type}}">
                            On
                        </p>
                    @endif
                </td>
                <td>
                    <ul class="action-wrap">
                        <li>
                            <a href="javascript:void(0)" data-id="{{$data->id}}" id="editAppSetting" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16.473" height="16.473" viewBox="0 0 16.473 16.473">
                                  <path id="Path_376" data-name="Path 376"
                                    d="M14.667,9.131l-1.3-1.3L4.833,16.373v1.3h1.3l8.538-8.538Zm1.3-1.3,1.3-1.3-1.3-1.3-1.3,1.3ZM6.889,19.5H3V15.613L15.315,3.3a.917.917,0,0,1,1.3,0L19.2,5.891a.917.917,0,0,1,0,1.3L6.889,19.5Z"
                                    transform="translate(-3 -3.029)" fill="#00b247" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>