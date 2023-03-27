<table id="HotTagList" class="table table-striped table-bordered dt-responsive nowrap mytabel"
    style="width:100%">
    <thead>
        <tr>
            <th>Followers</th>
            <th>Salmon Coin</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataList as $data)
            <tr>
                <td>{{$data->followers}}</td>
                <td>{{$data->salmon_coin}}</td>
                <td>
                    <ul class="action-wrap">
                        <li>
                            <a href="javascript:void(0)" data-id="{{$data->id}}" id="editHotTagSetting" title="Edit">
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