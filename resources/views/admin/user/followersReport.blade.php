<div class="profile_report">
    <span class="tabel-profile-img mr-3">
        <img src="{{asset('storage/app/public/uploads/users/'.$user->profile_pic)}} " alt="">
    </span>
    <div>
        <span class="d-block">{{$user->username}}</span>
        <span>{{strtolower($user->stream_id)}}</span>
    </div>
</div>
    <div class="user-coinlist-content">
        <div class="position-relative">
            <form id="filter_user_report" name="filter_user_report_form"
                class="d-inline-flex flex-wrap align-items-center position-absolute"
                style="top: 8px; right: 270px; z-index: 1;">

                <div class="profile-input user-report-datepicker mx-3 my-0">
                    <input type="text"  class="bg-transparent daterange" name="daterange" id="daterange" />
                    <i class="fa fa-calendar"></i>
                </div>
            </form>
            <table id="followerTable" class="table table-striped table-bordered dt-responsive  mytabel" style="width:100%">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Stream Id</th>
                        <th>Mobile</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
