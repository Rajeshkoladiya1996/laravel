<div class="row">
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span>Event Type:</span>
            <span style="font-weight: 400;">{{$EventDetail->event_type}}</span >
        </div>
    </div>
    <div class="col-lg-6">
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span >Event Name:</span>
            <span style="font-weight: 400;">{{$EventDetail->event_name}}</span >
        </div>
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span >Thai Event Name:</span>
            <span style="font-weight: 400;">{{$EventDetail->event_thai_name}}</span >
        </div>
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span >Description:</span>
            <span style="font-weight: 400;">{{$EventDetail->description}}</span >
        </div>
    </div>          
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span >Thai Description Name:</span>
            <span style="font-weight: 400;">{{$EventDetail->thai_description}}</span >
        </div>
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span >Terms & condition:</span>         
            <span style="font-weight: 400;">{{$EventDetail->terms_condition}}</span >
        </div>
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span >Thai Terms & condition:</span>             
            <span style="font-weight: 400;">{{$EventDetail->thai_terms_condition}}</span >
        </div>
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span >Event Start Date:</span>
            <span style="font-weight: 400;">{{$EventDetail->start_date}}</span >
        </div>
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span >Event End Date:</span>
            <span style="font-weight: 400;">{{$EventDetail->end_date}}</span >
        </div>
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span>Stream Type:</span>
            <span style="font-weight: 400;">{{$EventDetail->stream_type}}</span >
        </div>
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span>Reward Type:</span>
            <span style="font-weight: 400;">{{$EventDetail->reward_type}}</span >
        </div>
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            @if($EventDetail->reward_type=="gift")
                <div class="">
                    <span>Gift Category:</span>
                    <span style="font-weight: 400;">
                        @if($EventDetail->gift_category_id!=null)
                            {{$EventDetail->gift_category->name}}
                        @endif
                    </span >                    
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            @if($EventDetail->reward_type=="gift")
                <div class="">
                    <span>Gift:</span>
                    <span style="font-weight: 400;">
                        @if($EventDetail->gift_id!=null)
                            @foreach(explode(",",$EventDetail->gift_id) as $value)
                                @foreach($EventDetail->gift_category->gift as $key => $value2)
                                    @if($value2->id == $value)
                                        {{$value2->name}}({{$value2->gems}}),
                                    @endif                                    
                                @endforeach
                            @endforeach
                        @endif
                    </span>                    
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span>Primary color:</span>
            <input type="color" value="{{$EventDetail->primary_color}}" class="pr-3" readonly disabled>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span>Secondry color:</span>
            <input type="color" value="{{$EventDetail->secondry_color}}" class="pr-3" readonly disabled>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="login-input no-icon">
            <span>Is Gradient:</span>
            <span style="font-weight: 400;">
            @if($EventDetail->isGradient==1)
                True
            @else
                False
            @endif
            </span >
        </div>
         @if($EventDetail->isGradient==1)
            <div class="row ">
                <div class="col-lg-6 ">
                    <div class="login-input no-icon">
                        <span>Start gradient:</span>
                        <input type="color" value="{{$EventDetail->start_gradient}}" class="pr-3" readonly disabled>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-input no-icon">
                        <span>End gradient:</span>
                        <input type="color" value="{{$EventDetail->end_gradient}}" class="pr-3" readonly disabled>
                    </div>
                </div>    
            </div>
        @endif
    </div>
    <div class="col-lg-6">
        <div class="gift-input">
            <span class="smaller-img"><img class="preview-img-edit" src="{{URL::to('storage/app/public/uploads/event/')}}/{{$EventDetail->image}}" alt="" width="100px" height="100px"></span>
        </div>
    </div>
    
    <div class="col-lg-12">
        <div class="login-input no-icon editreward_list">
            <span>Reward List</span>
            <div class="row">
                <div class="col-lg-12">
                    <div class="editreward_data">
                        <table id="rewardEvent" class="table table-striped table-bordered dt-responsive mytabel" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Description</th>
                                    <th>Thai Description</th>
                                    <th>Days</th>
                                    <th>Point</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach($EventDetail->rewardEvent as $key => $value)
                                    <tr>
                                        <td>@php echo $i++; @endphp</td>
                                        <td>{{$value->description}}</td>
                                        <td>{{$value->thai_description}}</td>
                                        <td>{{$value->days}}</td>
                                        <td>{{$value->points}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>