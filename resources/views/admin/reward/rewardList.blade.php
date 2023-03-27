<table id="example" class="table td-wrap-table table-striped table-bordered dt-responsive nowrap mytabel" style="width:100%">
    <thead>
      <tr>
        <th>No</th>
        <th>Name</th>
        <th>Description</th>
        <th>Image</th>
        <th>Reward Type</th>
        <th>Reward Value</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
        @php
            $i=0;
        @endphp
        @foreach ($rewardList as $data)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $data->name }}</td>
                <td>{{ $data->description }}</td>
                <td>
                    @if (isset($data->image))
                        <img src="{{URL::to('storage/app/public/uploads/reward/'.$data->image)}}" alt="" width="50px" height="50px">
                    @else
                        '-'
                    @endif
                </td>
                <td>{{ isset($data->type) ? Str::ucfirst($data->type) : '-' }}</td>
                <td>
                    @if ($data->type == 'gift')
                        {{ isset($data->gift) ? Str::ucfirst($data->gift->name).'-'.$data->gift->gems. ' (Gems)'  : '-' }}
                    @else
                        {{ isset($data->type_value) ? $data->type_value : '-' }}
                    @endif    
                </td>

                <td>{!! ($data->status == '1')? '<span class="green reward-status" data-status='.$data->status.' data-id='.$data->id.'>Active</span>': '<span class="red reward-status" data-status='.$data->status.' data-id='.$data->id.'>De-active</span>' !!}</td>
                <td>
                    <ul class="action-wrap">
                        <li>
                            <a href="javascript:void(0)" id="editReward" data-id="{{$data->id}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16.473" height="16.473" viewBox="0 0 16.473 16.473">
                                <path id="Path_376" data-name="Path 376"
                                    d="M14.667,9.131l-1.3-1.3L4.833,16.373v1.3h1.3l8.538-8.538Zm1.3-1.3,1.3-1.3-1.3-1.3-1.3,1.3ZM6.889,19.5H3V15.613L15.315,3.3a.917.917,0,0,1,1.3,0L19.2,5.891a.917.917,0,0,1,0,1.3L6.889,19.5Z"
                                    transform="translate(-3 -3.029)" fill="#00b247" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="deleteReward" data-id="{{$data->id}}" data-type="rewardlist">
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