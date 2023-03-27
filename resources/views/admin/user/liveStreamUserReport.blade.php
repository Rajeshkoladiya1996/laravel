<div class="profile_report">
    <span class="tabel-profile-img mr-3">
        <img src="{{asset('storage/app/public/uploads/users/'.$users->profile_pic)}}" alt="">
    </span>
    <div>
        <span class="d-block">{{$users->username}}</span>
        <span>{{strtolower($users->stream_id)}}</span>
    </div>
    <div class="px-5">
        <span class="d-block">Total Days: {{$diff_in_days}}</span>
        <span>Time:{{$total_time}}</span>
    </div>

</div>
<div class="position-relative">
        <form id="filter_user_report" name="filter_user_report_form"
            class="d-inline-flex flex-wrap align-items-center position-absolute"
            style="top: 8px; right: 270px; z-index: 1;">

            <div class="profile-input user-report-datepicker mx-3 my-0">
                <input type="text"  class="bg-transparent daterange" name="daterange" id="daterange" />
                <i class="fa fa-calendar"></i>
            </div>
        </form>
    <table class='table table-striped table-bordered dt-responsive mytabel dataTable no-footer' id='liveStreamTable'>
        <thead >
            <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Duration</th>

            </tr>
        </thead>
        <tbody>

           
        </tbody>
    </table>
</div>
