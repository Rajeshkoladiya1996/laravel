@extends('layouts.admin')
@section('title')
    Event List
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::to('storage/app/public/Adminassets/css/jquery-ui.css')}}">
@endsection
@section('content')
    <div class="main-title">
        <h4>Event </h4>
        <div id="level-point-btn">
            <a href="javascript:void(0)" class="btn btn-pink btn-header-pink" id="add_event_btn"  data-toggle="modal" data-target="#add-event">Add Event</a>
        </div>
    </div>

    <div class="row financial-row">
        <div class="col-lg-12">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active reward-list-page" id="eventList" role="tabpanel" aria-labelledby="rewardList-tab">
                    {{-- @include('admin.event.eventList') --}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

{{-- Start Store Reward  --}}
<div class="modal fade" id="add-event" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px;">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
      </button>
      <div class="modal-body password-modal">
        <div class="password-moda">
          <h5>Add Event</h5>
          <form name="addevent_from" id="addevent_from">
            <div class="row">

                <div class="col-lg-6">
                    <div class="login-input no-icon">
                        <span>Event Name:</span>
                        <input type="text" placeholder="Name" class="pr-3" name="event_name" id="event_name">
                        <span id="err-event_name" class="error"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-input no-icon">
                        <span>Event Thai Name:</span>
                        <input type="text" placeholder="Thai Name" class="pr-3" name="event_thai_name" id="event_thai_name">
                        <span id="err-event_thai_name" class="error"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-input no-icon">
                        <span>Event Description:</span>
                        <textarea placeholder="Description" class="pr-3" name="description" id="description" cols="25" rows="2"></textarea>
                        <span id="err-description" class="error"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-input no-icon">
                        <span>Event Thai Description:</span>
                        <textarea placeholder="Thai Description" class="pr-3" name="thai_description" id="thai_description" cols="25" rows="2"></textarea>
                        <span id="err-thai_description" class="error"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                        <div class="login-input no-icon">
                            <span>Event Terms & Condition:</span>
                            <textarea placeholder="Terms & condition" id="terms_condition" name="terms_condition" class="pr-3" cols="25" rows="2"></textarea>
                            <span id="err-terms_condition" class="error"></span>
                        </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-input no-icon">
                        <span>Event Thai Terms & Condition:</span>
                        <textarea placeholder="Thai Terms & condition" id="thai_terms_condition" name="thai_terms_condition" class="pr-3" cols="25" rows="2"></textarea>
                        <span id="err-thai_terms_condition" class="error"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-input no-icon">
                        <span>Event Start Date:</span>
                        <input type="text" placeholder="event start date" id="start_date" name="start_date" class="pr-3">
                        <span id="err-start_date" class="error"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-input no-icon">
                        <span>Event End Date:</span>
                        <input type="text" placeholder="event end date" id="end_date" name="end_date" class="pr-3">
                        <span id="err-end_date" class="error"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-input no-icon mb-0">
                        <span>Event Type</span>
                        <div class="row event-type-checkbox">
                            <div class="col-lg-6">
                                <div class="login-input no-icon">
                                    <input type="radio" id="vj" class="event_typeClass" name="event_type" value="vj">
                                    <label for="solo"> VJ</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="login-input no-icon">
                                    <input type="radio" id="user" class="event_typeClass" name="event_type" value="user">
                                    <label for="pk"> User</label><br>
                                </div>
                            </div>
                            <span id="err-event_type" class="error"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-input no-icon mb-0">
                        <span>Stream Type</span>
                        <div class="row stream-type-checkbox">
                            <div class="col-lg-6">
                                <div class="login-input no-icon">
                                    <input type="checkbox" id="solo" class="stream_typeClass" name="stream_type[]" value="solo">
                                    <label for="solo" class="cursor-pointer"> Solo</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="login-input no-icon">
                                    <input type="checkbox" id="pk" class="stream_typeClass" name="stream_type[]" value="pk">
                                    <label for="pk" class="cursor-pointer"> PK Host</label><br>
                                </div>
                            </div>
                            <span id="err-stream_type" class="error"></span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                        <span>Reward Type</span>
                        <div class="row reward-type-radio">
                            <div class="col-lg-4">
                                <div class="login-input no-icon">
                                    <input type="radio"  id="salmon" name="reward_type" value="salmon" class="reward_typeClass"><label for="salmon" class="cursor-pointer">Salmon</label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="login-input no-icon">
                                    <input type="radio" id="time" name="reward_type" class="reward_typeClass" value="time"><label for="time" class="cursor-pointer">Time(Min)</label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="login-input no-icon">
                                    <input type="radio" id="gift" name="reward_type" class="reward_typeClass" value="gift"><label for="gift" class="cursor-pointer">Gift</label>
                                </div>
                            </div>
                            <div class="col-lg-6 gift_category_div" >
                                <div class="login-input no-icon">
                                    <span>Gift Category</span>
                                    <select name="gift_catgeory" id="gift_catgeory" class="gift_catgeory" data-id="add">
                                        <option value="">Select Gift Category</option>
                                        @foreach ($giftCategory as $data)
                                            <option value="{{$data->id}}">{{$data->name}}</option>
                                        @endforeach
                                    </select>
                                    <span id="err-gift_catgeory" class="error"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 gift_category_div">
                                <div class="login-input no-icon" style="">
                                    <span>Gift</span>
                                    <select name="giftSalmon[]" id="giftSalmon" class="giftSalmon" data-id="add" multiple>
                                        <option value="" disabled="disabled" selected="true">Select Gift</option>
                                    </select>
                                    <span id="err-giftSalmon" class="error"></span>
                                </div>
                            </div>
                        </div>
                        <span id="err-reward_type" class="error"></span>
                </div>

                <div class="col-lg-6">
                    <div class="login-input no-icon">
                        <span>Primary color</span>
                        <input type="color" placeholder="event primary color" id="primarycolor" name="primary_color" class="pr-3">
                        <span id="err-primary_color" class="error"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-input no-icon">
                        <span>Secondry color</span>
                        <input type="color" placeholder="event secondry color " id="secondrycolor" name="secondry_color" class="pr-3">
                        <span id="err-secondry_color" class="error"></span>
                    </div>
                </div>

                <div class="col-lg-6 gradient-checkbox">
                    <div class="login-input no-icon">
                        <span>Is Gradient</span>
                        <input type="checkbox" id="is_gradient" name="is_gradient" value="true">
                        <span id="err-is_gradient" class="error"></span>
                    </div>
                    <div class="row gradient">
                        <div class="col-lg-6">
                            <div class="login-input no-icon gradient">
                                <span>Start gradient</span>
                                <input type="color" placeholder="event start gradient" id="start_gradient" name="start_gradient" class="pr-3">
                                <span id="err-start_gradient" class="error"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="login-input no-icon ">
                                <span>End gradient</span>
                                <input type="color" placeholder="event end gradient" id="end_gradient" name="end_gradient" class="pr-3">
                                <span id="err-end_gradient" class="error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 gift-input">
                    <div class="login-input no-icon">
                        <label for="event_image" class="gift-label">
                            <input type="file" id="event_image" class="up-image" name="event_image">
                            <div class="upload-box upload-box2">
                                <span class="smaller-img"><img class="preview-img preview-img_gif" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                                <h6>Upload Image</h6>
                            </div>
                            <span id="err-event_image" class="error"></span>
                        </label>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="login-input no-icon reward_list">
                        <span>Reward List</span>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="reward_data">
                                    <div class="row" id="reward0">
                                        <div class="col-lg-3">
                                            <input type="text" placeholder="Description" id="reward_desc0" name="reward_desc[]" class="pr-3">
                                            <span id="err-reward_desc_0" class="error"></span>
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="text" placeholder="Thai Description" id="thai_reward_desc0" name="thai_reward_desc[]" class="pr-3">
                                            <span id="err-thai_reward_desc_0" class="error"></span>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" placeholder="Days" id="reward_day0" name="reward_day[]" class="pr-3" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                                            <span id="err-reward_day_0" class="error"></span>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" placeholder="Point" id="reward_point0" name="reward_point[]" class="pr-3" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                                            <span id="err-reward_point_0" class="error" ></span>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="javascript:void(0)" id="addReward" data-id="0">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="login-input no-icon">
                    <input type="text" placeholder="Points" class="pr-3" name="event_points" id="event_points">
                    <span id="err-event_points" class="error"></span>
                </div> --}}

                <div id="reward_value" class="login-input no-icon">

                </div>
                <button type="submit" class="btn btn-black" id="event_button">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- End Store Reward  --}}


{{-- Start Update Event  --}}
<div class="modal fade" id="event-update-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px;">
      <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
          <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
        </button>
        <div class="modal-body password-modal">
          <div class="password-moda">
            <h5>Update Event</h5>
            <form name="event_update_from" id="event_update_from">
                <input type="hidden" name="id" id="update_id" />
                <div class="row">

                    <div class="col-lg-6">
                        <div class="login-input no-icon">
                            <span>Event Name:</span>
                            <input type="text" placeholder="Name" class="pr-3" name="edit_event_name" id="edit_event_name">
                            <span id="err-edit-edit_event_name" class="error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-input no-icon">
                            <span>Event Thai Name:</span>
                            <input type="text" placeholder="Thai Name" class="pr-3" name="edit_event_thai_name" id="edit_event_thai_name">
                            <span id="err-edit-edit_event_thai_name" class="error"></span>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="login-input no-icon">
                            <span>Event Description:</span>
                            <input type="text" placeholder="Description" class="pr-3" name="edit_description" id="edit_description">
                            <span id="err-edit-edit_description" class="error"></span>
                        </div>
                    </div>

                    <div class="col-lg-6">
                     <div class="login-input no-icon">
                        <span>Event Thai Description:</span>
                        <textarea placeholder="Thai Description" class="pr-3" name="edit_thai_description" id="edit_thai_description" cols="25" rows="2"></textarea>
                        <span id="err-edit-edit_thai_description" class="error"></span>
                      </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="login-input no-icon">
                            <span>Event Terms & Condition:</span>
                            <textarea placeholder="Terms & condition" id="edit_terms_condition" name="edit_terms_condition" class="pr-3" cols="25" rows="2"></textarea>
                            <span id="err-edit-edit_terms_condition" class="error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-input no-icon">
                            <span>Event Thai Terms & Condition:</span>
                            <textarea placeholder="Thai Terms & condition" id="edit_thai_terms_condition" name="edit_thai_terms_condition" class="pr-3" cols="25" rows="2"></textarea>
                            <span id="err-edit-edit_thai_terms_condition" class="error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-input no-icon">
                            <span>Event Start Date:</span>
                            <input type="text" placeholder="event start date" id="edit_start_date" name="edit_start_date" class="pr-3">
                            <span id="err-edit-edit_start_date" class="error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-input no-icon">
                            <span>Event End Date:</span>
                            <input type="text" placeholder="event end date" id="edit_end_date" name="edit_end_date" class="pr-3">
                            <span id="err-edit-edit_end_date" class="error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-input no-icon">
                            <span>Event Type</span>
                            <div class="row event-type-checkbox">
                                <div class="col-lg-6">
                                    <div class="login-input no-icon">
                                        <input type="radio" id="editvj" class="event_typeClass" name="editevent_type" value="vj">
                                        <label for="solo"> VJ</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="login-input no-icon">
                                        <input type="radio" id="edituser" class="event_typeClass" name="editevent_type" value="user">
                                        <label for="pk"> User</label><br>
                                    </div>
                                </div>
                                <span id="err-stream_type" class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <span>Stream Type</span>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="login-input no-icon">
                                        <input type="checkbox" id="edit_solo" class="editstream_typeClass" name="edit_stream_type[]" value="solo">
                                        <label for="edit_solo" class="cursor-pointer"> Solo</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="login-input no-icon">
                                        <input type="checkbox" id="edit_pk" class="editstream_typeClass" name="edit_stream_type[]" value="pk">
                                        <label for="edit_pk" class="cursor-pointer"> PK Host</label><br>
                                    </div>
                                </div>
                            </div>
                        <span id="err-edit-edit_stream_type" class="error"></span>
                    </div>
                    <div class="col-lg-12">
                        <span>Reward Type</span>
                        <div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="login-input no-icon">
                                        <input type="radio" id="edit_salmon" name="edit_reward_type" value="salmon" class="editreward_typeClass">
                                        <label for="edit_salmon">Salmon</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="login-input no-icon">
                                        <input type="radio" id="edit_time" name="edit_reward_type" class="editreward_typeClass" value="time">
                                        <label for="edit_time">Time(Min)</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="login-input no-icon">
                                        <input type="radio" id="edit_gift" name="edit_reward_type" class="editreward_typeClass" value="gift"><label for="edit_time">Gift</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span id="err-edit-edit_reward_type" class="error"></span>
                    </div>
                    <div class="col-lg-6 edit_gift_category_div">
                        <div class="login-input no-icon">
                            <span>Gift Category</span>
                            <select name="edit_gift_catgeory" id="edit_gift_catgeory" class="gift_catgeory" data-id="add">
                                <option value="" selected="true" disabled="disabled">Select Gift Category</option>
                                @foreach ($giftCategory as $data)
                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                            <span id="err-edit-edit_gift_catgeory" class="error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 edit_gift_category_div">
                        <div class="login-input no-icon">
                            <span>Gift</span>
                            <select name="editgiftSalmon[]" id="editgiftSalmon" class="editgiftSalmon" data-id="add" multiple>
                            </select>
                            <span id="err-edit-editgiftSalmon" class="error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-input no-icon">
                            <span>Primary color</span>
                            <input type="color" placeholder="event primary color" id="edit_primarycolor" name="edit_primary_color" class="pr-3">
                            <span id="err-edit-edit_primary_color" class="error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-input no-icon">
                            <span>Secondry color</span>
                            <input type="color" placeholder="event secondry color " id="edit_secondrycolor" name="edit_secondry_color" class="pr-3">
                            <span id="err-edit-edit_secondry_color" class="error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-input no-icon">
                            <input type="checkbox" id="edit_is_gradient" name="edit_is_gradient" value="true">
                            <span>Is Gradient</span>
                            <span id="err-edit-edit_is_gradient" class="error"></span>
                        </div>
                        <div class="row editgradient">
                            <div class="col-lg-6 ">
                                <div class="login-input no-icon">
                                    <span>Start gradient</span>
                                    <input type="color" placeholder="event start gradient" id="edit_start_gradient" name="edit_start_gradient" class="pr-3">
                                    <span id="err-edit-edit_start_gradient" class="error"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="login-input no-icon">
                                    <span>End gradient</span>
                                    <input type="color" placeholder="event end gradient" id="edit_end_gradient" name="edit_end_gradient" class="pr-3">
                                    <span id="err-edit-edit_end_gradient" class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="gift-input">
                            <label for="edit_event_image" class="gift-label edit">
                                <input type="file" id="edit_event_image" class="up-image" name="edit_event_image">
                                <div class="upload-box upload-box2">
                                    <span class="smaller-img"><img class="preview-img-edit" src="{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}" alt=""></span>
                                    <h6>Upload Image</h6>
                                </div>
                                <span id="err-edit-edit_event_image" class="error"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="login-input no-icon editreward_list">
                            <span>Reward List</span>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="editreward_data">
                                        <div class="row" id="editreward0">
                                            <div class="col-lg-3">
                                                <input type="text" placeholder="Description" id="edit_reward_desc0" name="edit_reward_desc[]" class="pr-3">
                                                <span id="err-edit-edit_reward_desc_0" class="error"></span>
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="text" placeholder="Thai Description" id="edit_thai_reward_desc0" name="edit_thai_reward_desc[]" class="pr-3">
                                                <span id="err-edit-edit_thai_reward_desc_0" class="error"></span>
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="text" placeholder="Days" id="edit_reward_day0" name="edit_reward_day[]" class="pr-3" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                                                <span id="err-edit-edit_reward_day_0" class="error"></span>
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="text" placeholder="Point" id="edit_reward_point0" name="edit_reward_point[]" class="pr-3" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                                                <span id="err-edit-edit_reward_point_0" class="error" ></span>
                                            </div>
                                            <div class="col-lg-2">
                                                <a href="javascript:void(0)" id="edit_addReward" data-id="0">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="login-input no-icon">
                    </div>

                    <div id="update_event_value" class="login-input no-icon">
                    </div>
                    <button type="submit" class="btn btn-black" id="event_edit_button">Update</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
{{-- End Update Event  --}}

{{-- Start View Event  --}}
<div class="modal fade" id="event-view-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px;">
      <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
          <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
        </button>
        <div class="modal-body password-modal">
            <div class="password-moda">
                <h5>Event</h5>
                <div class="viewEventData"></div>
            </div>
        </div>
      </div>
    </div>
</div>
{{-- End View Event  --}}

{{-- Start View Event  --}}
<div class="modal fade" id="eventUser-view-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px;">
      <div class="modal-content">
        <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
          <img src="{{URL::to('storage/app/public/Adminassets/image/close.svg')}}" alt="">
        </button>
        <div class="modal-body password-modal">
            <div class="password-moda">
                <h5>Event User</h5>
                <div class="viewEventUserData"></div>
            </div>
        </div>
      </div>
    </div>
</div>
{{-- End View Event  --}}

<div class="modal fade" id="event-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body p-0">
        <div class="block-modal">
          <h5>Delete Event</h5>
          <p>Are you sure you want to delete this Event.</p>
          <input type="hidden" name="type" id="type">
          <input type="hidden" name="del_id" id="del_id">
          <div class="block-btn">
            <a href="javascript:void(0)" class="btn btn-black delete" data-id="yes">Yes</a>
            <a href="javascript:void(0)" class="btn btn-red delete" data-id="no">No</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="event-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="close-icon" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body p-0">
        <div class="block-modal">
          <h5>Change Status Event</h5>
          <p>Are you sure you want to Change Status of this Event.</p>
          <input type="hidden" name="event_id" id="event_id">
          <input type="hidden" name="status" id="status">
          <div class="block-btn">
            <a href="javascript:void(0)" class="btn btn-black change" data-id="yes">Yes</a>
            <a href="javascript:void(0)" class="btn btn-red change" data-id="no">No</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    // get Event list
    var eventUserTable=null;
    function getEventList() {
        $.ajax({
            url:"{{ route('admin.event.list') }}",
            type:'GET',
            success:function(response){
                $('#eventList').html(response);
                $("#eventTable").DataTable();
            }
        });
    }
    $( document ).ready(function() {
        getEventList();
        $('.gift_category_div').hide();
        $('.gradient').hide();
        $('.reward_list').hide();
        $('.editgradient').hide();

        $("#start_date").datepicker({
            numberOfMonths: 1,
            dateFormat: 'yy-mm-dd',
            onSelect: function(selected) {
            $("#end_date").datepicker("option","minDate", selected)
            }
        });
        $("#end_date").datepicker({
            numberOfMonths: 1,
            dateFormat: 'yy-mm-dd',
            onSelect: function(selected) {
            $("#start_date").datepicker("option","maxDate", selected)
            }
        });

        $("#edit_start_date").datepicker({
            numberOfMonths: 1,
            dateFormat: 'yy-mm-dd',
            onSelect: function(selected) {
            $("#edit_end_date").datepicker("option","minDate", selected)
            }
        });
        $("#edit_end_date").datepicker({
            numberOfMonths: 1,
            dateFormat: 'yy-mm-dd',
            onSelect: function(selected) {
            $("#edit_start_date").datepicker("option","maxDate", selected)
            }
        });

        // $('#giftSalmon').select2();
        // $('#editgiftSalmon').select2();
    });

    $("#gift_catgeory").change(function(){
        var id=$(this).val();
        $.ajax({
            url:"{{URL::to('godmode/event/giftData/')}}"+"/"+id,
            type:'GET',
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success:function(response){
                var giftData="";
                $("#giftSalmon").html("<option value='' disabled='disabled' selected='true'>Select Gift</option>");
                $.each(response.giftList, function (key, val) {
                    giftData+="<option value="+val.id+">"+val.name+" : "+val.gems+"</option>"
                });
                $("#giftSalmon").append(giftData);
            }
        });
    });

    $("#edit_gift_catgeory").change(function(){
        var id=$(this).val();
        $.ajax({
            url:"{{URL::to('godmode/event/giftData/')}}"+"/"+id,
            type:'GET',
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success:function(response){
                var giftData="";
                $("#editgiftSalmon").html("<option value='' disabled='disabled' selected='true'>Select Gift</option>");
                $.each(response.giftList, function (key, val) {
                    giftData+="<option value="+val.id+">"+val.name+" : "+val.gems+"</option>"
                });
                $("#editgiftSalmon").append(giftData);
            }
        });
    });

    $("#event_image").change(function() {
        readURLimage(this);
    });
    $("#edit_event_image").change(function() {
        readURLEdit(this);
    });

    $("#add_event_btn").click(function(){
        $(".error").text("");

        $('#event_button').prop("disabled", false);

        $('.gift_category_div').hide();
        $('.gradient').hide();
        $('.reward_list').hide();
        $('.rewardBlock').each(function(i) {
            i++;
           $("#reward"+i).remove();
        });
        count=1;
    });

     function readURLimage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            const type = input.files[0].type.split('/');
            $('#err-event_image').text("");
            if (type[0] == 'image') {
				reader.onload = function(e) {
                    $('.preview-img_gif').attr('src', e.target.result);
                }
				if(type[1]=='jpeg' || type[1]=="png" || type[1]=="jpg" || type[1]=="svg"){

				}else{
					toastr.error('Invalid File input.');
					$('#err-event_image').text("The event image must be a file of type: jpeg, png, jpg, svg.");
				}
			}else {
				$('#err-event_image').text("The event image must be a file of type: jpeg, png, jpg, svg.");
				toastr.error('Invalid File input.')
				return false;
			}


            reader.readAsDataURL(input.files[0]);
        }
    };

    function readURLEdit(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();



            const type = input.files[0].type.split('/');
            $('#err-edit-edit_event_image').text("");
            if (type[0] == 'image') {
				reader.onload = function(e) {
                    $('.preview-img-edit').attr('src', e.target.result);
                }
				if(type[1]=='jpeg' || type[1]=="png" || type[1]=="jpg" || type[1]=="svg"){

				}else{
					toastr.error('Invalid File input.');
					$('#err-edit-edit_event_image').text("The edit event image must be a file of type: jpeg, png, jpg, svg.");
				}
			}else {
				$('#err-edit-edit_event_image').text("The edit event image must be a file of type: jpeg, png, jpg, svg.");
				toastr.error('Invalid File input.')
				return false;
			}


            reader.readAsDataURL(input.files[0]);
        }
    };

    $("#is_gradient").change(function() {
        if(this.checked) {
            $('.gradient').show();
        }else{
            $('.gradient').hide();
        }
    });

    $("#edit_is_gradient").change(function() {
        if(this.checked) {
            $('.editgradient').show();
        }else{
            $('.editgradient').hide();
        }
    });
    $("input.stream_typeClass").click(function () {
        var checkCount=0;
        $('.stream_typeClass').each(function(){
            if($(this).is(':checked')){
                checkCount++;
                $('.reward_typeClass:checked').each(function(){
                    if($(this).is(':checked')){
                        $('.reward_list').show();
                    }
                    if(!$(this).is(':checked')){
                        $('.reward_list').hide();
                    }
                });
            }else{
                if(checkCount<=0){
                    $('.reward_list').hide();
                }
            }
        });
    });

    $("input.editstream_typeClass").click(function () {
        var checkCount=0;
        $('.editstream_typeClass').each(function(){
            if($(this).is(':checked')){
                checkCount++;
                $('.editreward_typeClass:checked').each(function(){
                    if($(this).is(':checked')){
                        $('.editreward_list').show();
                    }
                });
            }else{
                if(checkCount<=0){
                    $('.editreward_list').hide();
                }
            }
        });

        // if($(this).is(':checked')){
        //     $('.editreward_typeClass:checked').each(function(){
        //         if($(this).is(':checked')){
        //             $('.editreward_list').show();
        //         }
        //         if(!$(this).is(':checked')){
        //             $('.editreward_list').hide();
        //         }
        //     });
        // }
        // if(!$(this).is(':checked')){
        //     $('.editreward_list').hide();
        // }
    });

    //on gift reward type click
    $("input.reward_typeClass").click(function () {
        if($(this).val()=="gift"){
            $('.gift_category_div').show();
        }else{
            $('.gift_category_div').hide();
        }
        if($(this).is(':checked')){
            $('.stream_typeClass:checked').each(function(){
                if($(this).is(':checked')){
                    $('.reward_list').show();
                }
                if(!$(this).is(':checked')){
                    $('.reward_list').hide();
                }
            });
        }
        if(!$(this).is(':checked')){
            $('.reward_list').hide();
        }
    });

    $("input.editreward_typeClass").click(function () {
            if($(this).val()=="gift"){
                $('.edit_gift_category_div').show();
            }else{
                $('.edit_gift_category_div').hide();
            }
            if($(this).is(':checked')){
                $('.editstream_typeClass:checked').each(function(){
                    if($(this).is(':checked')){
                        $('.editreward_list').show();
                    }
                    if(!$(this).is(':checked')){
                        $('.editreward_list').hide();
                    }
                });
            }
            if(!$(this).is(':checked')){
                $('.editreward_list').hide();
            }
    });
    var count=1,ecount=1;
    $("#addReward").click(function(){
        $('.reward_data').append(`<div class="row rewardBlock" id="reward`+count+`">
                        <div class="col-lg-3">
                            <input type="text" placeholder="Description" id="reward_desc`+count+`" name="reward_desc[]" class="pr-3 reward_descClass">
                            <span id="err-reward_desc_`+count+`" class="error reward_descErrorClass"></span>
                        </div>
                        <div class="col-lg-3">
                            <input type="text" placeholder="Thai Description" id="thai_reward_desc`+count+`" name="thai_reward_desc[]" class="pr-3 thai_reward_descClass">
                            <span id="err-thai_reward_desc_`+count+`" class="error thai_reward_descErrorClass"></span>
                        </div>
                        <div class="col-lg-2">
                            <input type="text" placeholder="Days" id="reward_day`+count+`" name="reward_day[]" class="pr-3 reward_dayClass" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                            <span id="err-reward_day_`+count+`" class="error reward_dayErrorClass"></span>
                        </div>
                        <div class="col-lg-2">
                            <input type="text" placeholder="Point" id="reward_point`+count+`" name="reward_point[]" class="pr-3 reward_pointClass" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;">
                            <span id="err-reward_point_`+count+`" class="error reward_pointErrorClass"></span>
                        </div>
                        <div class="col-lg-2">
                            <a href="javascript:void(0)" class="deleteRewardButton" id="deleteReward" data-id="`+count+`">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>`);
                    count++;
    });
    $("#edit_addReward").click(function(){
        $('.editreward_data').append(`<div class="row erewardBlock" id="editreward`+ecount+`">
                <div class="col-lg-3">
                    <input type="text" placeholder="Description" id="edit_reward_desc`+ecount+`" name="edit_reward_desc[]" class="pr-3 edit_reward_descClass" >
                    <span id="err-edit-edit_reward_desc_`+ecount+`" class="error edit_reward_descErrorClass"></span>
                </div>
                <div class="col-lg-3">
                    <input type="text" placeholder="Thai Description" id="edit_thai_reward_desc`+ecount+`" name="edit_thai_reward_desc[]" class="pr-3 edit_thai_reward_descClass">
                    <span id="err-edit-edit_thai_reward_desc_`+ecount+`" class="error edit_thai_reward_descErrorClass"></span>
                </div>
                <div class="col-lg-2">
                    <input type="text" placeholder="Days" id="edit_reward_day`+ecount+`" name="edit_reward_day[]" class="pr-3 edit_reward_dayClass" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;" >
                    <span id="err-edit-edit_reward_day_`+ecount+`" class="error edit_reward_dayErrorClass"></span>
                </div>
                <div class="col-lg-2">
                    <input type="text" placeholder="Point" id="edit_reward_point`+ecount+`" name="edit_reward_point[]" class="pr-3 edit_reward_pointClass" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;" >
                    <span id="err-edit-edit_reward_point_`+ecount+`" class="error edit_reward_pointErrorClass"></span>
                </div>
                <div class="col-lg-2">
                    <a href="javascript:void(0)" class="edeleteRewardButton" id="edeleteReward" data-id="`+ecount+`">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </a>
                </div>
            </div>`);
       ecount++;
    });

    $(document).on('click', '#deleteReward', function(e) {
        e.preventDefault();
        var id=$(this).data('id');
        $("#reward"+id).remove();

        //change block id
        var idCount=1;
        $('.rewardBlock').each(function(i) {
           $(this).attr('id', 'reward'+idCount);
           idCount++;
        });
        //delete button count change
        var idCount = 1;
        $('.deleteRewardButton').each(function(i) {
           $(this).attr('data-id', idCount);
           idCount++;
        });
        //Description count change
        idCount = 1;
        $('.reward_descClass').each(function(i) {
           $(this).attr('id', "reward_desc"+idCount);
           $(this).attr('name', "reward_desc["+idCount+"]");
           idCount++;
        });
        //Description error count change
        idCount = 1;
        $('.reward_descErrorClass').each(function(i) {
           $(this).attr('id', "err-reward_desc_"+idCount);
           idCount++;
        });

        //Thai Description count change
        idCount = 1;
        $('.thai_reward_descClass').each(function(i) {
           $(this).attr('id', "thai_reward_desc"+idCount);
           $(this).attr('name', "thai_reward_desc["+idCount+"]");
           idCount++;
        });
        //Thai Description error count change
        idCount = 1;
        $('.thai_reward_descErrorClass').each(function(i) {
           $(this).attr('id', "err-thai_reward_desc_"+idCount);
           idCount++;
        });

        //Reward day count change
        idCount = 1;
        $('.reward_dayClass').each(function(i) {
           $(this).attr('id', "reward_day"+idCount);
           $(this).attr('name', "reward_day["+idCount+"]");
           idCount++;
        });
        //Reward day error count change
        idCount = 1;
        $('.reward_dayErrorClass').each(function(i) {
           $(this).attr('id', "err-reward_day_"+idCount);
           idCount++;
        });

        //Reward poin count change
        idCount = 1;
        $('.reward_pointClass').each(function(i) {
           $(this).attr('id', "reward_point"+idCount);
           $(this).attr('name', "reward_point["+idCount+"]");
           idCount++;
        });
        //Reward point error count change
        idCount = 1;
        $('.reward_pointErrorClass').each(function(i) {
           $(this).attr('id', "err-reward_point_"+idCount);
           idCount++;
        });
        count--;

    });

    $(document).on('click', '#edeleteReward', function(e) {
        e.preventDefault();
        var id=$(this).data('id');
        $("#editreward"+id).remove();

        //change block id
        var idCount=1;
        $('.erewardBlock').each(function(i) {
           $(this).attr('id', 'editreward'+idCount);
           idCount++;
        });
        //delete button count change
        var idCount = 1;
        $('.edeleteRewardButton').each(function(i) {
           $(this).attr('data-id', idCount);
           idCount++;
        });
        //Description count change
        idCount = 1;
        $('.edit_reward_descClass').each(function(i) {
           $(this).attr('id', "edit_reward_desc"+idCount);
           $(this).attr('name', "edit_reward_desc["+idCount+"]");
           idCount++;
        });
        //Description error count change
        idCount = 1;
        $('.edit_reward_descErrorClass').each(function(i) {
           $(this).attr('id', "err-edit_reward_desc_"+idCount);
           idCount++;
        });

        //Thai Description count change
        idCount = 1;
        $('.edit_thai_reward_descClass').each(function(i) {
           $(this).attr('id', "edit_thai_reward_desc"+idCount);
           $(this).attr('name', "edit_thai_reward_desc["+idCount+"]");
           idCount++;
        });
        //Thai Description error count change
        idCount = 1;
        $('.edit_thai_reward_descErrorClass').each(function(i) {
           $(this).attr('id', "err-edit_thai_reward_desc_"+idCount);
           idCount++;
        });

        //Reward day count change
        idCount = 1;
        $('.edit_reward_dayClass').each(function(i) {
           $(this).attr('id', "edit_reward_day"+idCount);
           $(this).attr('name', "edit_reward_day["+idCount+"]");
           idCount++;
        });
        //Reward day error count change
        idCount = 1;
        $('.edit_reward_dayErrorClass').each(function(i) {
           $(this).attr('id', "err-edit_reward_day_"+idCount);
           idCount++;
        });

        //Reward poin count change
        idCount = 1;
        $('.edit_reward_pointErrorClass').each(function(i) {
           $(this).attr('id', "edit_reward_point"+idCount);
           $(this).attr('name', "edit_reward_point["+idCount+"]");
           idCount++;
        });
        //Reward point error count change
        idCount = 1;
        $('.edit_reward_pointErrorClass').each(function(i) {
           $(this).attr('id', "err-edit_reward_point_"+idCount);
           idCount++;
        });
        ecount--;

    });

    $('#addevent_from').on('submit',function (e) {
        e.preventDefault();
        // $('#event_button').prop("disabled", true);
        // if($("#addevent_from").valid()){
            $('.error').text("");
            var fd = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.event.store')}}",
                method:'POST',
                data:fd,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                  // $("#loading-image").show();
                },
                success:function(data){
                    if(data == 1){
                        $('#event_button').prop("disabled", true);
                        $('#add-event').modal('hide');
                        $('#addevent_from')[0].reset();
                        getEventList();
                        toastr.success('Event Added successfully.');
                        $('.preview-img').attr('src',"{{URL::to('storage/app/public/Adminassets/image/gift-2.svg')}}");
                    }
                },
                error:function(errors){
                    $('#event_button').prop("disabled", false);
                    for(error in errors.responseJSON.errors){
                        console.log('#err-'+error.replace('.', '_')+":"+errors.responseJSON.errors[error]);
                        $('#err-'+error.replace('.', '_')).text(errors.responseJSON.errors[error]);
                    }
                }
            });
        // }else{
        //         $('#event_button').prop("disabled", false);
        // }
    });

    // get Event list
    function getEventList() {
        $.ajax({
            url:"{{ route('admin.event.list') }}",
            type:'GET',
            success:function(response){
                $('#eventList').html(response);
                $("#eventTable").DataTable();
            }
        });
    }


   // Event Status
    $('body').on('click','.reward-status',function(){
        $('#event_id').val($(this).attr('data-id'));
        $('#status').val($(this).attr('data-status'));
        $('#event-status').modal('show');
    })
    $('body').on('click','.change',function(){
        let status = $('#status').val();
        let confim=$(this).attr('data-id');
        let id=$('#event_id').val();
            if(confim=="yes"){
                console.log("yes");
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('admin.event.status') }}",
                    method:'POST',
                    data:{id:id,status:status},
                    beforeSend: function() {
                        // $("#loading-image").show();
                    },
                    success:function(data){
                        if(data == 1){
                            $('#event-status').modal('hide');
                            getEventList();
                        }else{

                        }
                    },error:function(error){
                    }
                });
            }else{
                $('#event-status').modal('hide');
            }
    })

    // Edit Event

    $('body').on('click','#editevent',function(e){
        $('#event_edit_button').prop("disabled", false);
        $("#edit_solo").prop("checked", false );
        $("#edit_pk").prop("checked", false );

        $("#edit_salmon").prop("checked", false );
        $("#edit_time").prop("checked", false );
        $("#edit_gift").prop("checked", false );

        // $("#edit_gift_catgeory").val([]);
        $("#editgiftSalmon").val([]);
        $(".edit_gift_category_div").hide();

        $("#edit_is_gradient").prop("checked", false);
        $(".editgradient").hide();

        $('.erewardBlock').each(function(i) {
            i++;
           $("#editreward"+i).remove();
        });
        $("#edit_reward_desc0").val("");
        $("#edit_thai_reward_desc0").val("");
        $("#edit_reward_day0").val("");
        $("#edit_reward_point0").val("");
        ecount=1;
        $('.editgradient').hide();
        $(".reward_list").hide();

        // $('#edit_gift_catgeory').val('').trigger("change");

        $(".error").text("");
        const id = $(this).attr('data-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{URL::to('godmode/event/edit/')}}"+"/"+id,
            method:'GET',
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success:function(data){
                $('#update_id').val(data.eventDetail.id);
                $('#edit_event_name').val(data.eventDetail.event_name);
                $('#edit_description').val(data.eventDetail.description);
                $('#edit_event_points').val(data.eventDetail.points);
                $('#edit_event_thai_name').val(data.eventDetail.event_thai_name);
                $('#edit_thai_description').val(data.eventDetail.thai_description);
                $('#edit_terms_condition').val(data.eventDetail.terms_condition);
                $('#edit_thai_terms_condition').val(data.eventDetail.thai_terms_condition);
                $('#edit_start_date').val(data.eventDetail.start_date);
                $('#edit_end_date').val(data.eventDetail.end_date);
                var streamType=data.eventDetail.stream_type;
                if(streamType!=null){
                    var streamTypeArray = streamType.split(',');
                    console.log(streamTypeArray);
                    for(i in streamTypeArray){
                        if(streamTypeArray[i]==$('#edit_solo').val()){
                            $("#edit_solo").prop("checked", true );
                        }
                        if(streamTypeArray[i]==$('#edit_pk').val()){
                            $("#edit_pk").prop("checked", true );
                        }
                    }
                }

                if(data.eventDetail.event_type==$('#editvj').val()){
                    $("#editvj").prop("checked", true );
                }else if(data.eventDetail.event_type==$('#edituser').val()){
                    $("#edituser").prop("checked", true );
                }

                if(data.eventDetail.reward_type==$('#edit_salmon').val()){
                    $("#edit_salmon").prop("checked", true );
                }else if(data.eventDetail.reward_type==$('#edit_time').val()){
                    $("#edit_time").prop("checked", true );
                }else if(data.eventDetail.reward_type==$('#edit_gift').val()){
                    $("#edit_gift").prop("checked", true );
                    $(".edit_gift_category_div").show();
                    $('#edit_gift_catgeory option[value='+data.eventDetail.gift_category_id+']').attr('selected','true');

                    $("#editgiftSalmon").html("<option value='' disabled='disabled' selected='true'>Select Gift</option>");
                    var giftData="";
                    if(data.eventDetail.gift_id!=null  && data.eventDetail.gift_id!=""){
                        var gift=data.eventDetail.gift_id.split(",");
                        $.each(data.eventDetail.gift_category.gift, function (key, val) {
                            giftData+="<option value="+val.id+">"+val.name+" : "+val.gems+"</option>"
                        });
                        $("#editgiftSalmon").append(giftData);

                        $.each(gift, function (key, val) {
                            if(val!=""){
                                $('#editgiftSalmon').children("option[value=" + val + "]").prop("selected", true);
                            }
                        });
                    }

                }

                $("#edit_primarycolor").val(data.eventDetail.primary_color);
                $("#edit_secondrycolor").val(data.eventDetail.secondry_color);

                var is_gradient=(data.eventDetail.isGradient == 1) ? "true" : "false";
                if(is_gradient==$('#edit_is_gradient').val()){
                    $("#edit_is_gradient").prop("checked", true );
                    $(".editgradient").show();
                }

                $("#edit_start_gradient").val(data.eventDetail.start_gradient);
                $("#edit_end_gradient").val(data.eventDetail.end_gradient);

                if(data.eventDetail.reward_type!=null && data.eventDetail.stream_type!=null){
                    $(".reward_list").show();
                }
                var reward=``;
                // $('.editreward_data').html('');
                if(data.eventDetail.reward_event.length != 0){
                    $.each(data.eventDetail.reward_event, function (i) {
                        if(i!=0){
                            reward+=`<div class="row erewardBlock" id="editreward`+ecount+`">`;
                        }
                        var desc,tdesc,rday,point;
                        $.each(data.eventDetail.reward_event[i], function (key, val) {
                            if(i==0){
                                if(key=="description")
                                    $("#edit_reward_desc0").val(val);
                                if(key=="thai_description")
                                    $("#edit_thai_reward_desc0").val(val);
                                if(key=="points")
                                    $("#edit_reward_point0").val(val);
                                if(key=="days")
                                    $("#edit_reward_day0").val(val);
                            }else{
                                if(key=="description"){

                                    desc=`<div class="col-lg-3">
                                                <input type="text" placeholder="Description" id="edit_reward_desc`+ecount+`" name="edit_reward_desc[]" class="pr-3 edit_reward_descClass" value="`+val+`">
                                                <span id="err-edit_reward_desc_`+ecount+`" class="error edit_reward_descErrorClass"></span>
                                            </div>`;
                                }
                                if(key=="thai_description"){
                                    tdesc=`<div class="col-lg-3">
                                                <input type="text" placeholder="Thai Description" id="edit_thai_reward_desc`+ecount+`" name="edit_thai_reward_desc[]" class="pr-3 edit_thai_reward_descClass" value="`+val+`">
                                                <span id="err-edit_thai_reward_desc_`+ecount+`" class="error edit_thai_reward_descErrorClass"></span>
                                            </div>`;
                                }
                                if(key=="points"){
                                    point=`<div class="col-lg-2">
                                                <input type="text" placeholder="Point" id="edit_reward_point`+ecount+`" name="edit_reward_point[]" class="pr-3 edit_reward_pointClass" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;" value="`+val+`">
                                                <span id="err-edit_reward_point_`+ecount+`" class="error edit_reward_pointErrorClass"></span>
                                            </div>`;
                                }
                                if(key=="days"){
                                    rday=`<div class="col-lg-2">
                                                <input type="text" placeholder="Days" id="edit_reward_day`+ecount+`" name="edit_reward_day[]" class="pr-3 edit_reward_dayClass" onkeypress="if(event.which < 48 || event.which > 57 ) if(event.which != 8) if(event.keyCode != 9) return false;" value="`+val+`">
                                                <span id="err-edit_reward_day_`+ecount+`" class="error edit_reward_dayErrorClass"></span>
                                            </div>`;
                                }

                            }
                        });
                        if(i!=0){
                            reward+=desc+tdesc+rday+point;
                            reward+=`<div class="col-lg-2">
                                            <a href="javascript:void(0)" class="edeleteRewardButton" id="edeleteReward" data-id="`+ecount+`">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </a>
                                    </div>
                                </div>`;
                            ecount++;
                        }
                    });
                    $('.editreward_data').append(reward);
                }

                $('#event-update-model').modal('show');
                $('.preview-img-edit').attr('src',"{{URL::to('storage/app/public/uploads/event')}}"+"/"+data.eventDetail.image);
            },error:function(error){
            }
        });
    })

    $('body').on('click','#viewEvent',function(e){
        const id = $(this).attr('data-id');
        $.ajax({
            url:"{{URL::to('godmode/event/data/')}}"+"/"+id,
            type:'GET',
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success:function(response){
                $(".viewEventData").html(response);
                $('#event-view-model').modal('show');
                $("#rewardEvent").DataTable();
            }
        });
    });

    $('body').on('click','#event-user-list',function(e){
        const id = $(this).attr('data-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ route('admin.event.user') }}",
            type: 'POST',
            data: {
                'event_id': id
            },
            beforeSend: function() {
                // $("#loading-image").show();
            },
            success:function(response){
                $(".viewEventUserData").html(response);
                $('#eventUser-view-model').modal('show');

                $.fn.dataTable.ext.errMode = 'none';
                eventUserTable = $("#eventUserTable").DataTable({
                    processing: true,
                    pageLength: 10,
                    aaSorting: [],
                    responsive: true,
                    serverSide: true,
                    ordering: true,
                    searching: true,
                    "ajax": {
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "url":'{{route("admin.event.user.list")}}',
                        "type": "POST",
                        "data": {
                            'event_id': id
                        },
                    },
                    "columns": [{
                            "data": "username"
                        },
                        {
                            "data": "reward_type"
                        },
                        {
                            "data": "event_counts"
                        },
                        {
                            "data": "action",
                            orderable: false
                        }
                    ],
                    "initComplete": function(settings, json) {
                    },
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 0
                        },
                        {
                            responsivePriority: 2,
                            targets: -1
                        }
                    ]
                });
                $("#eventUserTable").DataTable();
            }
        });
    });

    $('#event_update_from').on('submit',function (e) {
        e.preventDefault();
        $('.error').text("");
        $('#event_edit_button').prop("disabled", true);
        if($("#event_update_from").valid()){
            var fd = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.event.update')}}",
                method:'POST',
                data:fd,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                  // $("#loading-image").show();
                },
                success:function(data){
                    if(data == 1){
                        $('#event-update-model').modal('hide');
                        $('#event_update_from')[0].reset();
                        $(".error").text("");
                        toastr.success('Event updated successfully.');
                        getEventList();
                    }else{

                    }
                },
                error:function(errors){
                    $('#event_edit_button').prop("disabled", false);
                    for(error in errors.responseJSON.errors){
                        console.log('#err-edit-'+error.replace('.', '_')+":"+errors.responseJSON.errors[error]);
                        $('#err-edit-'+error.replace('.', '_')).text(errors.responseJSON.errors[error]);
                    }
                }
            });
        }
    })

    // delete Event

    $('body').on('click','#deleteevent',function(){
        $('#del_id').val($(this).attr('data-id'));
        $('#type').val($(this).attr('data-type'));
        $('#event-delete').modal('show');
    })

    $('.delete').on('click',function (e) {
        let confim=$(this).attr('data-id');
        let id=$('#del_id').val();
        let type = $('#type').val();
        if(confim=="yes"){
            console.log("yes");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{route('admin.event.delete')}}",
                method:'POST',
                data:{id:id},
                beforeSend: function() {
                  // $("#loading-image").show();
                },
                success:function(data){
                    if(data == 1){
                        $('#event-delete').modal('hide');
                        getEventList();
                    }
                },error:function(error){
                    console.log(error);
                }
            });
        }else{
            $('#event-delete').modal('hide');
        }
    });

</script>

{{-- <script src="{{URL::to('storage/app/public/Adminassets/js/jquery-1.9.1.js')}}"></script> --}}

<script src="{{URL::to('storage/app/public/Adminassets/js/jquery-ui.js')}}"></script>
@endsection
