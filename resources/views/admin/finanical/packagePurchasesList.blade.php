<h5>Package Purchases</h5>
<table id="packagePurchase" class="table table-striped table-bordered dt-responsive nowrap mytabel" style="width:100%">
    <thead>
        <tr>
            <th>User Name</th>
            <th>Package</th>
            <th>Transaction Id</th>
            <th>Device Type</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($packagePurchases as $key => $value)
            <tr>
                <td>
                    @if (!filter_var($value->user->profile_pic, FILTER_VALIDATE_URL))
                        @if (\File::exists(storage_path('app/public/uploads/users/$value->user->profile_pic')))
                            <span class="tabel-profile-img">
                                <img src="{{asset('storage/app/public/uploads/users/'.$value->user->profile_pic)}}" alt="">
                            </span>
                            {{$value['user']->username!='' ? $value['user']->username : '-' }}
                            <br/>
                            {{strtolower($value['user']->stream_id)}}
                        @else
                            <span class="tabel-profile-img">
                                <img src="{{asset('storage/app/public/uploads/users/default.png')}}" alt="">
                            </span> 
                            {{$value['user']->username!='' ? $value['user']->username : '-' }}
                            <br/>
                            {{strtolower($value['user']->stream_id)}}
                        @endif
                    @else
                        <span class="tabel-profile-img">
                            <img src="{{$value->user->profile_pic}}" alt="">
                        </span> 
                        {{$value['user']->username!='' ? $value['user']->username : '-' }}
                        <br/>
                        {{strtolower($value['user']->stream_id)}}
                    @endif               
                </td>
                <td>
                    {{$value->package->name}}
                </td>

                <td>
                    {{$value->transaction_id}}
                </td>
                <td>
                    {{$value->device_type}}
                </td>
                <td>
                    {{$value->purchase_date}}
                </td>
                <td>
                    {{$value->purchase_status}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>