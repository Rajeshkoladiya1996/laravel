<table id="PackageListTable" class="table table-striped table-bordered dt-responsive nowrap mytabel"
    style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>USD Price($)</th>
            <th>SGD Price(S$)</th>
            <th>Thai Price(฿)</th>
            <th>Salmon Coin</th>
            <th>Image</th>
            <th>IOS Product ID</th>
            <th>Android Product ID</th>
            <th>IOS Is Active</th>
            <th>Android Is Active</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i=0;
           
        @endphp
        @foreach ($package as $data)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{$data->name}}</td>
                <td>@if($data->price!=null) ${{$data->price}} @endif</td>
                <td>@if($data->SGD_price!=null) S${{$data->SGD_price}} @endif</td>
                <td>@if($data->thai_price!=null) ฿{{$data->thai_price}} @endif</td>
                <td>{{$data->salmon_coin}}</td>
                <td>@if (isset($data->image))
                        <img src="{{URL::to('storage/app/public/uploads/package/'.$data->image)}}" alt="" width="50px" height="50px">
                    @else
                        '-'
                    @endif
                </td>
                <td>{{$data->ios_product_id}}</td>
                <td>{{$data->android_product_id}}</td>
                <td>{!! ($data->ios_is_active == '1')? '<span class="green ios-status" data-status='.$data->ios_is_active.' data-id='.$data->id.'>Active</span>': '<span class="red ios-status" data-status='.$data->ios_is_active.' data-id='.$data->id.'>De-active</span>' !!}</td>
                <td>{!! ($data->android_is_active == '1')? '<span class="green android-status" data-status='.$data->android_is_active.' data-id='.$data->id.'>Active</span>': '<span class="red android-status" data-status='.$data->android_is_active.' data-id='.$data->id.'>De-active</span>' !!}</td>
                <td>
                    <ul class="action-wrap">
                        <li>
                            <a href="javascript:void(0)" class="editPackage" id="editPackage" data-id="{{$data->id}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16.473" height="16.473" viewBox="0 0 16.473 16.473">
                                <path id="Path_376" data-name="Path 376"
                                    d="M14.667,9.131l-1.3-1.3L4.833,16.373v1.3h1.3l8.538-8.538Zm1.3-1.3,1.3-1.3-1.3-1.3-1.3,1.3ZM6.889,19.5H3V15.613L15.315,3.3a.917.917,0,0,1,1.3,0L19.2,5.891a.917.917,0,0,1,0,1.3L6.889,19.5Z"
                                    transform="translate(-3 -3.029)" fill="#00b247" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="deletePackage" data-id="{{$data->id}}" data-type="packagelist">
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