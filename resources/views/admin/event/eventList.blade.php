<table id="eventTable" class="table table-striped table-bordered dt-responsive mytabel" style="width:100%">
    <thead>
      <tr>
        <th>No</th>
        <th>Event Name</th>
        <th>Thai Name</th>
        <th>Description</th>
        <th>Thai Description</th>
        <th>Type </th>
        <th>Start-End Date </th>
        <th>Image</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>

        @foreach ($eventList as $i => $data)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $data->event_name }}</td>
                <td>{{ $data->event_thai_name }}</td>
                <td>{{ $data->description }}</td>
                <td>{{ $data->thai_description }}</td>
                <td>{{$data->event_type}}</td>
                <td>{{$data->start_date}} To {{$data->end_date}}</td>
                <td>
                    <img src="{{URL::to('storage/app/public/uploads/event/'.$data->image)}}" alt="" width="50px" height="50px">
                </td>
                <td> <span class="{{($data->status == '1')?'green' : 'red' }} reward-status" data-status="{{$data->status}}" data-id="{{$data->id}}">{!! ($data->status == '1')? 'Active' : 'De-active' !!}</span> </td>
                <td>
                    <ul class="action-wrap">
                        <li>
                            <a href="javascript:void(0)" class="event-user-list-model" id="event-user-list" data-id="{{$data->id}}"  title="View E User List">
                                <svg height="20" viewBox="0 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m512 511.992188h-512v-78.367188c0-26.914062 16.832031-50.945312 42.128906-60.144531l133.871094-48.6875v-31.457031l-48-64v-96.816407c0-68.113281 51.28125-127.679687 119.230469-132.222656 74.53125-5.007813 136.769531 54.222656 136.769531 127.695313v101.328124l-48 64v31.472657l133.871094 48.6875c25.296875 9.183593 42.128906 33.214843 42.128906 60.144531zm0 0" fill="#64ccf4"/><path d="m288 223.992188h-64v-96h32v64h32zm0 0" fill="#40a2e7"/><path d="m336 324.792969v-31.457031l48-64v-5.34375c-88.222656 0-160 71.777343-160 160 0 35.632812 11.96875 68.351562 31.761719 94.925781h-255.761719v33.074219h512v-123.199219zm0 0" fill="#43ade8"/><path d="m288 47.992188h32v32h-32zm0 0" fill="#fff"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="assign-model" id="viewEvent" data-id="{{$data->id}}" data-type="streamer" title="View Event">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path fill="#d6b755"
                                    d="M21 8v12.993A1 1 0 0 1 20.007 22H3.993A.993.993 0 0 1 3 21.008V2.992C3 2.455 3.449 2 4.002 2h10.995L21 8zm-2 1h-5V4H5v16h14V9zM8 7h3v2H8V7zm0 4h8v2H8v-2zm0 4h8v2H8v-2z" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="editevent" data-id="{{$data->id}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16.473" height="16.473" viewBox="0 0 16.473 16.473">
                                <path id="Path_376" data-name="Path 376"
                                    d="M14.667,9.131l-1.3-1.3L4.833,16.373v1.3h1.3l8.538-8.538Zm1.3-1.3,1.3-1.3-1.3-1.3-1.3,1.3ZM6.889,19.5H3V15.613L15.315,3.3a.917.917,0,0,1,1.3,0L19.2,5.891a.917.917,0,0,1,0,1.3L6.889,19.5Z"
                                    transform="translate(-3 -3.029)" fill="#00b247" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="deleteevent" data-id="{{$data->id}}" data-type="eventlist">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm-8 5v6h2v-6H9zm4 0v6h2v-6h-2zM9 4v2h6V4H9z"
                                    fill="rgba(255,0,0,1)" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
