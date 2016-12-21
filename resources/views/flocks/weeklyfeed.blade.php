@extends('layouts.default')

@section('title')
Weekly Progress - {{$flock->display_id}}
@stop

@section('page_title')
  Weekly Progress - {{$flock->display_id}}
@stop

@sub_page_title

@stop
@section('content')
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
 
 
<div class="row">
    
    @if(Session::has('unauthorize_access'))
    <!-- Error Message Display Start -->
    <div class="alert alert-danger alert-dismissible ssg-alert" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h3>
        <span class="glyphicon glyphicon-exclamation-sign"></span>
        Unauthorize Access
      </h3>
      <span>You are trying to reach an unauthorize area. If you think you seen this alert by mistake, please contact admistrator.</span>
    </div>
    <!-- Error Message Display Ends -->
    @endif

    <div class="col-sm-12 widgets panel_container">
      <div class="row panel_container_top">
        <div class="panel panel-default">
          <div class="panel-heading">
              {{$flock->display_id}}
              <button type="button" class="btn btn-primary modal_button pull-right" data-toggle="modal" data-target=".bs-example-modal">Add New</button></th>
          </div>
          <div class="panel-body table-responsive">
              <div class="" id="tabs">
                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" onclick="tab_link('body_weight')" href="#body_weight">Body Weight</a></li>
                    <li><a data-toggle="tab" onclick="tab_link('uniformity')" href="#uniformity">Uniformity</a></li>
                    <li><a data-toggle="tab" onclick="tab_link('manure_removal')" href="#manure_removal">Manure Removal</a></li>
                    <li><a data-toggle="tab" onclick="tab_link('light_intensity')" href="#light_intensity">Light Intensity</a></li>
                    <li><a data-toggle="tab" onclick="tab_link('wind_velocity')" href="#wind_velocity">Wind Velocity</a></li>
                    
                  </ul>
                  <div class="tab-content">
                    <div id="body_weight"  class="tab-pane fade in active table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="body_weight_list">
                          <thead>
                            <tr>
                                <th>Flock Age</th>
                                <th>Entry Date</th>
                                <th>Standard(g)</th>
                                <th>Actual(g)</th>
                                <th>Comments</th>
                                 @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                 <th>Action</th>
                                 @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($body_weight as $weightRow)
                              <tr class="feed_id_{{$weightRow->feed_id}}">
                                <td>{{$weightRow->bird_age_week}}</td>
                                <td>{{$weightRow->entry_date}}</td>
                                <td>{{$weightRow->standard_value}}</td>
                                <td>{{$weightRow->field_value}}</td>
                                <td>{{empty($weightRow->comment) ? 'N/A' : $weightRow->comment}}</td>
                                 @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <td>
                                    <button class="btn btn-default" onclick="editFeed('{{$weightRow->feed_id}}')">Edit</button>
                                    <button class="btn btn-default" onclick="deleteFeed('{{$weightRow->feed_id}}')">Delete</button>
                                  </td>
                                 @endif
                              </tr>
                            @endforeach
                          </tbody>
                          
                        </table>
                    </div>
                    <div id="uniformity"  class="tab-pane fade table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="uniformity_list">
                          <thead>
                            <tr>
                                <th>Flock Age</th>
                                <th>Entry Date</th>
                                <th>Standard(%)</th>
                                <th>Actual(%)</th>
                                <th>Comments</th>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <th>Action</th>
                                @endif
                            </tr>
                          </thead>
                          <tbody>
                             @foreach($uniformity as $uniformityRow)
                              <tr class="feed_id_{{$uniformityRow->feed_id}}">
                                <td>{{$uniformityRow->bird_age_week}}</td>
                                <td>{{$uniformityRow->entry_date}}</td>
                                <td>{{$uniformityRow->standard_value}}</td>
                                <td>{{$uniformityRow->field_value}}</td>
                                <td>{{empty($uniformityRow->comment) ? 'N/A' : $uniformityRow->comment}}</td>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <td>
                                    <button class="btn btn-default" onclick="editFeed('{{$uniformityRow->feed_id}}')">Edit</button>
                                    <button class="btn btn-default" onclick="deleteFeed('{{$uniformityRow->feed_id}}')">Delete</button>
                                  </td>
                                @endif
                              </tr>
                            @endforeach
                             
                          </tbody>
                          
                        </table>
                    </div>

                    <div id="manure_removal"  class="tab-pane fade table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="manure_removal_list">
                          <thead>
                            <tr>
                                <th>Flock Age</th>
                                <th>Entry Date</th>
                                <th>Standard(Kg)</th>
                                <th>Actual(Kg)</th>
                                <th>Comments</th>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <th>Action</th>
                                @endif
                            </tr>
                          </thead>
                          <tbody>
                             @foreach($manure_removal as $mrRow)
                              <tr class="feed_id_{{$mrRow->feed_id}}">
                                <td>{{$mrRow->bird_age_week}}</td>
                                <td>{{$mrRow->entry_date}}</td>
                                <td>{{$mrRow->standard_value}}</td>
                                <td>{{$mrRow->field_value}}</td>
                                <td>{{empty($mrRow->comment) ? 'N/A' : $mrRow->comment}}</td>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <td>
                                    <button class="btn btn-default" onclick="editFeed('{{$mrRow->feed_id}}')">Edit</button>
                                    <button class="btn btn-default" onclick="deleteFeed('{{$mrRow->feed_id}}')">Delete</button>
                                  </td>
                                @endif
                              </tr>
                            @endforeach
                             
                          </tbody>
                          
                        </table>
                      </div>    
                      <div id="light_intensity"  class="tab-pane fade table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="light_intensity_list">
                          <thead>
                            <tr>
                                <th>Flock Age</th>
                                <th>Entry Date</th>
                                <th>Standard(Lux)</th>
                                <th>Actual(Lux)</th>
                                <th>Comments</th>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <th>Action</th>
                                @endif
                            </tr>
                          </thead>
                          <tbody>
                             @foreach($light_intensity as $liRow)
                              <tr class="feed_id_{{$liRow->feed_id}}">
                                <td>{{$liRow->bird_age_week}}</td>
                                <td>{{$liRow->entry_date}}</td>
                                <td>{{$liRow->standard_value}}</td>
                                <td>{{$liRow->field_value}}</td>
                                <td>{{empty($liRow->comment) ? 'N/A' : $liRow->comment}}</td>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                   <td>
                                    <button class="btn btn-default" onclick="editFeed('{{$liRow->feed_id}}')">Edit</button>
                                    <button class="btn btn-default" onclick="deleteFeed('{{$liRow->feed_id}}')">Delete</button>
                                  </td>
                                @endif
                              </tr>
                            @endforeach
                             
                          </tbody>
                          
                        </table>
                      </div>
                    <div id="wind_velocity" class="tab-pane fade table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="wind_velocity_list">
                          <thead>
                            <tr>
                                <th>Flock Age</th>
                                <th>Entry Date</th>
                                <th>Standard(CFM)</th>
                                <th>Actual(CFM)</th>
                                <th>Comments</th>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <th>Action</th>
                                @endif
                            </tr>
                          </thead>
                          <tbody>
                             @foreach($wind_velocity as $wvRow)
                              <tr class="feed_id_{{$wvRow->feed_id}}">
                                <td>{{$wvRow->bird_age_week}}</td>
                                <td>{{$wvRow->entry_date}}</td>
                                <td>{{$wvRow->standard_value}}</td>
                                <td>{{$wvRow->field_value}}</td>
                                <td>{{empty($wvRow->comment) ? 'N/A' : $wvRow->comment}}</td>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <td>
                                    <button class="btn btn-default" onclick="editFeed('{{$wvRow->feed_id}}')">Edit</button>
                                    <button class="btn btn-default" onclick="deleteFeed('{{$wvRow->feed_id}}')">Delete</button>
                                  </td>
                                @endif
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
  </div>
</div>
<!-- Form To add New Resources -->
<div class="modal fade bs-example-modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Weekly Record - <span class="daily_feed_active">Feed Per Bird</span></h4>
      </div>
      <form method="POST" class="form-horizontal" action="#" accept-charset="UTF-8" id="project_form">
          <div class="modal-body">       
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Record Date</label>
                    <div class="col-sm-9">
                    <input type="text" name="entry_date" id="entry_date" class="form-control datepicker" value="{{ date('Y-m-d', time()) }}" placeholder="Record Date - {{ date('Y-m-d', time()) }}" />
                    </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Actual Value Recorded Today</label>
                    <div class="col-sm-9">
                    <input type="text" name="field_value" id="field_value" class="form-control" placeholder="Actual Value Recorded Today" />
                    </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Comments if Any?</label>
                    <div class="col-sm-9">
                    <input type="text" name="comment" id="comment" class="form-control" placeholder="Comments if Any?" />
                  </div>
                </div>
  
          </div>
          <div class="modal-footer">
            <input name="_token" value="{{ csrf_token() }}" type="hidden"/>
            <input type="hidden" name="bird_age_week" value="{{$age_of_week->bird_age}}" id="bird_age_week" />
            <input type="hidden" name="flock_id" id="flock_id" value="{{$flock['flock_id']}}" />
            <input type="hidden" name="field_name" id="field_name" value="body_weight" />
        
            <input type="hidden" name="feed_id" id="feed_id" value="" />
            <input type="hidden" name="type_entry" id="type_entry" value="weekly"/>
            <input type="hidden" name="standard" id="standard" value="standard" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="submit_modal">Save changes</button>
          </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
var adjustment;

$(function(){
    $('#body_weight_list, #uniformity_list,#manure_removal_list, #light_intensity_list, #wind_velocity_list').DataTable({
        responsive: true
    });

    $('.datepicker').datepicker({'format':'yyyy-mm-dd','viewMode':'2',autoclose: true, startDate: '-5', endDate:'0'}).on('changeDate', function(e){
        $(this).datepicker('hide');
    });
  
     // funciton handles new boards when dialog box submit a new request to create new board. 
     $('.modal form').on('submit', function(event) {
      
        event.preventDefault();
        $.ajax({
          type: "POST",
          url: "{{ action('FlocksController@storeDailyFeed',array($flock['flock_id'])) }}",
          data: $("#project_form").serialize(),
          beforeSend: function() {
            
            $(".modal-footer").append('<span class="loading">Processing...</span>');
            $("#project_form").find("input[type=text], textarea, input[type=submit]").attr("disable", 'disable');
          }
        })
        .done(function( msg ) {
            //check if response from server is success or not . because json object will be returned if there are validation errors.
            $("#project_form").find("input[type=text], textarea, input[type=submit]").removeAttr("disable");
            $(".modal-footer").find('span.loading').remove();
            var response=jQuery.parseJSON(msg);
            var alertMsg="";
            if(typeof response =='object'){
                $(document).find('label.error').remove();
                var errors = jQuery.parseJSON(msg);
                for (var key in errors) {
                   // alert(key+ ">>>"+ errors[key][0]);
                    $("#"+key).after("<label class='error'>"+errors[key][0]+"</label>");
                }
            } else{
                var projectTitle = $( "#display_id" ).val();
                var specialistName = '';//$("#specialist_name").val();
                var strHtml = '<tr class="feed_id_'+msg+'"><td>'+$("#bird_age_week").val()+'</td>';
                      //strHtml += '<td><a href="#">'+$("#bird_age_week").val()+'</a></td>';
                      strHtml += '<td>'+$("#entry_date").val()+'</td>';
                      strHtml += '<td>N/A</td>';
                      strHtml += '<td>'+$("#field_value").val()+'</td>';
                      strHtml += '<td>'+$("#comment").val()+'</td>';
                      //strHtml += '<td><button class="btn btn-default" onclick="editFlock(\''+msg+'\')">Edit</button><button class="btn btn-default" onclick="deleteFlock(\''+msg+'\')">Delete</button></td>';
                      strHtml +='</tr>';
                if($("#feed_id").val() == '') {
                  
                  $("#"+$("#field_name").val()+"_list tbody").append(strHtml);
                  alertMsg = "Data Has been saved";
                } else{
                  alertMsg = "Data has been updated";
                  $("#"+$("#field_name").val()+"_list tbody").find(".feed_id_"+$("#feed_id").val()).replaceWith(strHtml);
                  //$("#team_form_"+msg+" .panel-heading a").text($("#project_title").val())
                }

               $("#myModal").hide();
               $("#project_form").find("input[type=text], textarea").val("");
               $("#feed_id").val("");
               $('.modal').find('button.close').trigger('click');

               //$(".ajax_box").removeClass('alert-danger').text("Success: New Project Has been Created").addClass('alert-success').show('slow').hide('slow');
              new PNotify({
                title: 'Success',
                text: alertMsg,
                type: 'success',
                addclass: "stack-topleft"
              });
              location.reload();
            }
            
        });


    });

    $('#myModal').on('hidden.bs.modal', function (e) {
      $("#doctor_id").attr('disabled', false);
      $("#project_form")[0].reset();
    });

});

//
function tab_link(fieldName){
  $("#field_name").val(fieldName);
  $(".daily_feed_active").text(fieldName.replace(/_/g, ' '));    
}

//function used to remove project from database.
function deleteFeed(flockId){
  if(confirm("Are you Sure to delete This Record?")) {
    var url = getvalidUrl('FlocksController@deleteDailyFeed', flockId);
    $.ajax({
      type: "post",
      url: url,
      data:{'_token': "{{ csrf_token() }}"}
      
    })
    .done(function( msg ) {
        //check if response from server is success or not . because json object will be returned if there are validation errors.

      $("#"+$("#field_name").val()+"_list tbody").find("tr.feed_id_"+flockId).remove();
        
     
      //$(".panel_container_top").isotope();
      if(msg == 1 ) {
        new PNotify({
          title: 'Success',
          text: 'Flock has been removed.',
          type: 'success',
          addclass: "stack-topleft"
        });
      } else {
        new PNotify({
          title: 'Error',
          text: 'there is something wrong please contact Support.',
          type: 'error',
          addclass: "stack-topleft"
        });
      }
    });
  }
}

//function used to get project Detail from database to edit.
function editFeed(flockID){
  var url = getvalidUrl('FlocksController@editDailyFeed', flockID);
   $.ajax({
          type: "get",
          url: url,
          
        })
        .done(function( msg ) {
            //check if response from server is success or not . because json object will be returned if there are validation errors.
            var response=jQuery.parseJSON(msg);
            if(typeof response =='object'){
                
                var fields = jQuery.parseJSON(msg);
               //console.log(fields);
                if(fields.length > 0){

                    $.each(fields[0], function(key, value) {
                        $("#"+key).val(value);
                    });
                }
                //$("#doctor_id").attr('disabled', true);
                $(".modal_button").trigger('click');
            } 
            
        });
}


</script>

@stop