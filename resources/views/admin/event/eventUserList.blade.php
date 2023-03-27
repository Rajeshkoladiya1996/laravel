<div class="profile_report row">
    <div class="col-lg-6">
      <span class="d-block">Event: {{$event->event_name}}</span>
      <span>Type: {{$event->event_type}}</span>
      
    </div>
    <div class="col-lg-6">
      <span class="d-block">Start Date: {{$event->start_date}}</span>
      <span class="d-block">End Date: {{$event->end_date}}</span>
    </div>
</div>
<table id="eventUserTable" class="table table-striped table-bordered dt-responsive mytabel" style="width:100%">
    <thead>
      <tr>
        <th>User Name</th>
        <th>Reward Type</th>
        <th>Points</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
</table>
