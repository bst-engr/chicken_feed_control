@extends('layouts.default')

@section('title')
Daily Data Record - {{$flock->display_id}}
@stop

@section('page_title')
  Daily Data Record - {{$flock->display_id}}
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
                    <li class="active"><a data-toggle="tab" onclick="tab_link('feed_per_bird')" href="#feed_per_bird">Feed Consumption</a></li>
                    <li><a data-toggle="tab" onclick="tab_link('feed_water_consumption')" href="#feed_water_consumption">Water Consumption</a></li>
                    <li><a data-toggle="tab" onclick="tab_link('feed_mortality')" href="#feed_mortality">Mortality</a></li>
                    <li><a data-toggle="tab" onclick="tab_link('feed_temprature')" href="#feed_temprature">Temprature</a></li>
                    <li><a data-toggle="tab" onclick="tab_link('feed_humidity')" href="#feed_humidity">Humidity</a></li>
                    <li><a data-toggle="tab" onclick="tab_link('feed_egg_weight')" href="#feed_egg_weight">Egg Weight</a></li>
                    <li><a data-toggle="tab" onclick="tab_link('feed_egg_production')" href="#feed_egg_production">Egg Production</a></li>
                    
                  </ul>
                  <div class="tab-content">
                    <div id="feed_per_bird"  class="tab-pane fade in active table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="feed_pir_bird_list">
                          <thead>
                            <tr>
                                <th>Week</th>
                                <th>Flock Age(Day)</th>
                                <th>Entry Date</th>
                                <th>Standard(grm)</th>
                                <th>Actual(grm)</th>
                                <th>Comments</th>
                                 @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                 <th>Action</th>
                                 @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($feed_per_bird as $feedRow)

                                  <?php
                                  $datetime1 = date_create($flock->arrival_date);
                                  $datetime2 = date_create($feedRow->entry_date);
                                  $interval = date_diff($datetime1, $datetime2);
                                  //echo $interval->format('%R%a days');
                                  ?>

                              <tr class="feed_id_{{$feedRow->feed_id}}">
                                <td>{{$feedRow->bird_age_week}}</td>
                                <td>{{$interval->format('%a')+1}}</td>
                                <td>{{$feedRow->entry_date}}</td>
                                <td>{{$feedRow->standard_value}}</td>
                                <td>{{$feedRow->field_value}}</td>
                                <td>{{empty($feedRow->comment) ? 'N/A' : $feedRow->comment}}</td>
                                 @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <td>
                                    <button class="btn btn-default" onclick="editFeed('{{$feedRow->feed_id}}','feed_per_bird')">Edit</button>
                                    <button class="btn btn-default" onclick="deleteFeed('{{$feedRow->feed_id}}')">Delete</button>
                                  </td>
                                 @endif
                              </tr>
                            @endforeach
                          </tbody>
                          
                        </table>
                    </div>
                    <div id="feed_water_consumption"  class="tab-pane fade table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="feed_water_consumption_list">
                          <thead>
                            <tr>
                                <th>Week</th>
                                <th>Flock Age(Day)</th>
                                <th>Entry Date</th>
                                <th>Standard(ml)</th>
                                <th>Actual(ml)</th>
                                <th>Comments</th>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <th>Action</th>
                                @endif
                            </tr>
                          </thead>
                          <tbody>
                             @foreach($water_consumption as $wcRow)
                             <?php
                                  $datetime1 = date_create($flock->arrival_date);
                                  $datetime2 = date_create($wcRow->entry_date);
                                  $interval = date_diff($datetime1, $datetime2);
                                  //echo $interval->format('%R%a days');
                                  ?>
                              <tr class="feed_id_{{$wcRow->feed_id}}">
                                <td>{{$wcRow->bird_age_week}}</td>
                                <td>{{$interval->format('%a')+1}}</td>
                                <td>{{$wcRow->entry_date}}</td>
                                <td>{{$wcRow->standard_value}}</td>
                                <td>{{$wcRow->field_value}}</td>
                                <td>{{empty($wcRow->comment) ? 'N/A' : $wcRow->comment}}</td>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <td>
                                    <button class="btn btn-default" onclick="editFeed('{{$wcRow->feed_id}}','feed_water_consumption')">Edit</button>
                                    <button class="btn btn-default" onclick="deleteFeed('{{$wcRow->feed_id}}')">Delete</button>
                                  </td>
                                @endif
                              </tr>
                            @endforeach
                             
                          </tbody>
                          
                        </table>
                    </div>

                    <div id="feed_mortality"  class="tab-pane fade table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="feed_mortality_list">
                          <thead>
                            <tr>
                                <th>Week</th>
                                <th>Flock Age(Day)</th>
                                <th>Entry Date</th>
                                <th>Standard</th>
                                <th>Actual</th>
                                <th>Comment</th>
                                
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <th>Action</th>
                                @endif
                            </tr>
                          </thead>
                          <tbody>
                             @foreach($mortality as $mortalityRow)
                             <?php
                                  $datetime1 = date_create($flock->arrival_date);
                                  $datetime2 = date_create($mortalityRow->entry_date);
                                  $interval = date_diff($datetime1, $datetime2);
                                  //echo $interval->format('%R%a days');
                                  ?>
                              <tr class="feed_id_{{$mortalityRow->feed_id}}">
                                <td>{{$mortalityRow->bird_age_week}}</td>
                                <td>{{$interval->format('%a')+1}}</td>
                                <td>{{$mortalityRow->entry_date}}</td>
                                <td>{{$mortalityRow->standard_value}}</td>
                                <?php $mReasons = !empty($mortalityRow->reasons) ? json_decode($mortalityRow->reasons,true) : array(); 
                                $append='';
                                      if(is_array($mReasons) && !empty($mReasons)) {
                                        foreach($mReasons as $key=>$value){
                                        
                                           $append .= $key.':'.(int)$value.", ";
                                        
                                        }
                                      }
                                  ?>
                                <td title="{{$append}}">{{$mortalityRow->field_value}}</td>
                                <td>{{empty($mortalityRow->comment) ? 'N/A' : $mortalityRow->comment}}</td>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <td>
                                    <button class="btn btn-default" onclick="editFeed('{{$mortalityRow->feed_id}}','feed_mortality')">Edit</button>
                                    <button class="btn btn-default" onclick="deleteFeed('{{$mortalityRow->feed_id}}')">Delete</button>
                                  </td>
                                @endif
                              </tr>
                            @endforeach
                             
                          </tbody>
                          
                        </table>
                      </div>    
                      <div id="feed_humidity"  class="tab-pane fade table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="feed_humidity_list">
                          <thead>
                            <tr>
                                <th>Week</th>
                                <th>Flock Age(Day)</th>
                                <th>Entry Date</th>
                                <th>Standard(%)</th>
                                <th>Inner(%)</th>
                                <th>Outer(%)</th>
                                <th>Comments</th>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <th>Action</th>
                                @endif
                            </tr>
                          </thead>
                          <tbody>
                             @foreach($humidity as $humidityRow)
                             <?php
                                  $datetime1 = date_create($flock->arrival_date);
                                  $datetime2 = date_create($humidityRow->entry_date);
                                  $interval = date_diff($datetime1, $datetime2);
                                  //echo $interval->format('%R%a days');
                                  ?>
                              <tr class="feed_id_{{$humidityRow->feed_id}}">
                                <td>{{$humidityRow->bird_age_week}}</td>
                                <td>{{$interval->format('%a')+1}}</td>
                                <td>{{$humidityRow->entry_date}}</td>
                                <td>{{$humidityRow->standard_value}}</td>
                                <td>{{$humidityRow->inner_humidity}}</td>
                                <td>{{$humidityRow->outter_humidity}}</td>
                                <!-- <td>{$humidityRow->field_value}}</td> -->
                                <td>{{empty($humidityRow->comment) ? 'N/A' : $humidityRow->comment}}</td>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                   <td>
                                    <button class="btn btn-default" onclick="editFeed('{{$humidityRow->feed_id}}','humidity')">Edit</button>
                                    <button class="btn btn-default" onclick="deleteFeed('{{$humidityRow->feed_id}}')">Delete</button>
                                  </td>
                                @endif
                              </tr>
                            @endforeach
                             
                          </tbody>
                          
                        </table>
                      </div>
                    <div id="feed_egg_weight" class="tab-pane fade table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="feed_egg_weight_list">
                          <thead>
                            <tr>
                                <th>Week</th>
                                <th>Flock Age(Day)</th>
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
                             @foreach($egg_weight as $weightRow)
                             <?php
                                  $datetime1 = date_create($flock->arrival_date);
                                  $datetime2 = date_create($weightRow->entry_date);
                                  $interval = date_diff($datetime1, $datetime2);
                                  //echo $interval->format('%R%a days');
                                  ?>
                              <tr class="feed_id_{{$weightRow->feed_id}}">
                                <td>{{$weightRow->bird_age_week}}</td>
                                <td>{{$interval->format('%a')+1}}</td>
                                <td>{{$weightRow->entry_date}}</td>
                                <td>{{$weightRow->standard_value}}</td>
                                <td>{{$weightRow->field_value}}</td>
                                <td>{{empty($weightRow->comment) ? 'N/A' : $weightRow->comment}}</td>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <td>
                                    <button class="btn btn-default" onclick="editFeed('{{$weightRow->feed_id}}','feed_egg_weight')">Edit</button>
                                    <button class="btn btn-default" onclick="deleteFeed('{{$weightRow->feed_id}}')">Delete</button>
                                  </td>
                                @endif
                              </tr>
                            @endforeach
                             
                          </tbody>
                          
                        </table>
                    </div>
                    <div id="feed_egg_production" class="tab-pane fade table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="feed_egg_product_list">
                          <thead>
                            <tr>
                                <th>Week</th>
                                <th>Flock Age(Day)</th>
                                <th>Entry Date</th>
                                <th>Standard</th>
                                <th>Actual</th>
                                <th>Comments</th>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <th>Action</th>
                                @endif
                            </tr>
                          </thead>
                          <tbody>
                             @foreach($egg_production as $productionRow)
                             <?php
                                  $datetime1 = date_create($flock->arrival_date);
                                  $datetime2 = date_create($productionRow->entry_date);
                                  $interval = date_diff($datetime1, $datetime2);
                                  //echo $interval->format('%R%a days');
                                  ?>
                              <tr class="feed_id_{{$productionRow->feed_id}}">
                                <td>{{$productionRow->bird_age_week}}</td>
                                <td>{{$interval->format('%a')+1}}</td>
                                <td>{{$productionRow->entry_date}}</td>
                                <td>{{$productionRow->standard_value}}</td>
                                <td>{{number_format((float)$productionRow->field_value,'2','.',',') }}</td>
                                <td>{{empty($productionRow->comment) ? 'N/A' : $productionRow->comment}}</td>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <td>
                                    <button class="btn btn-default" onclick="editFeed('{{$productionRow->feed_id}}','feed_egg_production')">Edit</button>
                                    <button class="btn btn-default" onclick="deleteFeed('{{$productionRow->feed_id}}')">Delete</button>
                                  </td>
                                @endif
                              </tr>
                            @endforeach
                              
                          </tbody>
                          
                        </table>
                    </div>
                    <div id="feed_temprature" class="tab-pane fade table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="feed_temprature_list">
                          <thead>
                            <tr>
                                <th>Week</th>
                                <th>Flock Age(Day)</th>
                                <th>Entry Date</th>
                                <th>Standard(C)</th>
                                <!-- <th>Actual</th> -->
                                <th>Avg.(C)</th>
                                <th>Feeling(C)</th>
                                <th>Inner Max.(C)</th>
                                <th>Inner Min.(C)</th>
                                <th>Out Max.(C)</th>
                                <th>Out Min.(C)</th>
                                <th>Comments</th>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                <th>Action</th>
                                 @endif
                            </tr>
                          </thead>
                          <tbody>
                             @foreach($feed_temprature as $tRow)
                             <?php
                                  $datetime1 = date_create($flock->arrival_date);
                                  $datetime2 = date_create($tRow->entry_date);
                                  $interval = date_diff($datetime1, $datetime2);
                                  //echo $interval->format('%R%a days');
                                  ?>
                              <tr class="feed_id_{{$tRow->feed_id}}">
                                <td>{{$tRow->bird_age_week}}</td>
                                <td>{{$interval->format('%a')+1}}</td>
                                <td>{{$tRow->entry_date}}</td>
                                <td>{{$tRow->standard_value}}</td>
                                <td>{{$tRow->field_value}}</td>
                                <td>{{$tRow->feeling}}</td>
                                <td>{{$tRow->inner_max}}</td>
                                <td>{{$tRow->inner_min}}</td>
                                <td>{{$tRow->outter_max}}</td>
                                <td>{{$tRow->outter_min}}</td>
                                <td>{{empty($tRow->comment) ? 'N/A' : $tRow->comment}}</td>
                                @if(Sentry::getUser()->hasAccess('manage_flocks'))
                                  <td>
                                    <button class="btn btn-default" onclick="editFeed('{{$tRow->feed_id}}','temprature')">Edit</button>
                                    <button class="btn btn-default" onclick="deleteFeed('{{$tRow->feed_id}}')">Delete</button>
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
        <h4 class="modal-title">Daily Record - <span class="daily_feed_active">Feed Per Bird</span></h4>
      </div>
      <form method="POST" class="form-horizontal" action="#" accept-charset="UTF-8" id="project_form">
          <div class="modal-body">       
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Record Date</label>
                    <div class="col-sm-9">
                      <input type="text" name="entry_date" id="entry_date" value="{{ date('Y-m-d', time()) }}" class="form-control datepicker" placeholder="Record Date - {{ date('Y-m-d', time()) }}" />
                    </div>
                </div>
                
                <div class="diseaseList" style="display:none;">
                  @foreach($reasons as $reason)
                    <div class="form-group">
                      <label class="col-sm-3 control-label">{{$reason->reason_name}}</label>
                      <div class="col-sm-9">
                        <input type="text" name="reason[{{$reason->reason_name}}]" id="{{$reason->reason_name}}" class="form-control reason_name" placeholder="Number of bird died of." />
                        <input type="hidden" name="reason_id[{{$reason->reason_name}}]" value="{{$reason->id}}" />
                      </div>
                    </div>
                  @endforeach
                </div>
                <div class="temperature_div_class" style="display:none">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Temprature Feeling</label>
                      <div class="col-sm-9">
                        <input type="text" name="feeling" id="feeling" class="form-control temprature_reading" placeholder="Temprature Feeling" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Inside Temperature Maximum</label>
                      <div class="col-sm-9">
                        <input type="text" name="inner_max" id="inner_max" class="form-control temprature_reading" placeholder="Inside Temperature Maximum" />
                      </div>
                    </div>                  
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Inside Temperature Minimum</label>
                      <div class="col-sm-9">
                        <input type="text" name="inner_min" id="inner_min" class="form-control temprature_reading" placeholder="Inside Temperature Minimum" />
                      </div>
                    </div>                  

                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Outside Temperature Maximum</label>
                    <div class="col-sm-9">
                      <input type="text" name="outter_max" id="outter_max" class="form-control" placeholder="Outside Temperature Maximum" />
                    </div>
                    </div>                  

                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Outside Temperature Minimum</label>
                    <div class="col-sm-9">
                      <input type="text" name="outter_min" id="outter_min" class="form-control" placeholder="Outside Temperature Minimum" />
                    </div>
                    </div>                  
                </div>

                <div class="humidity_div_class" style="display:none">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Humidity Inside</label>
                      <div class="col-sm-9">
                        <input type="text" name="inner_humidity" id="inner_humidity" class="form-control humidity_reading" placeholder="Humidity Inside" />
                      </div>
                    </div> 
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Humidity Outside</label>
                      <div class="col-sm-9">
                        <input type="text" name="outter_humidity" id="outter_humidity" class="form-control humidity_reading" placeholder="Humidity Outside" />
                      </div>
                    </div>                  
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label actual-label">Actual Value Recorded Today</label>
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
            <input type="hidden" name="field_name" id="field_name" value="feed_per_bird" />
            <input type="hidden" name="type_entry" id="type_entry" value="daily"/>
            <input type="hidden" name="feed_id" id="feed_id" value="" />
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
    $('#feed_pir_bird_list, #feed_temprature_list,#feed_egg_product_list,#feed_egg_weight_list, #feed_mortality_list, #feed_humidity_list, #feed_water_consumption_list').DataTable({
                responsive: true
        });
    $('.datepicker').datepicker({'format':'yyyy-mm-dd','viewMode':'2',autoclose: true, startDate: '-5', endDate:'0'}).on('changeDate', function(e){
        $(this).datepicker('hide');
    });

    $(".reason_name").blur(function(){
      var total = 0;
      $(".reason_name").each(function(){
          total = total + Number($(this).val());
        });
      $("#field_value").val(total);
    });
    
    // $(".temprature_reading").blur(function(){
    //   var total = 0;
    //     $(".temprature_reading").each(function(){
    //       total = total + Number($(this).val());
    //     });
    //     $("#field_value").val(total/3);
    // });

    $(".humidity_reading").blur(function(){
      var total = 0;
        $(".humidity_reading").each(function(){
          total = total + Number($(this).val());
        });
        $("#field_value").val(total/2);
    })
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
                var strHtml = '<tr class="feed_id_'+msg+'">';
                      strHtml += '<td><a href="#">'+$("#bird_age_week").val()+'</a></td>';
                      strHtml += '<td>'+$("#entry_date").val()+'</td>';
                      strHtml += '<td>'+$("#standard_value").val()+'</td>';
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
  
  if(fieldName == 'feed_mortality') {
    $(".diseaseList").show();
  } else {
    $(".diseaseList").hide();
  }

  if(fieldName == 'feed_temprature') {
    $(".temperature_div_class").show();
  } else {
    $(".temperature_div_class").hide();
  }

  if(fieldName == 'feed_humidity') {
    $(".humidity_div_class").show();
  } else {
    $(".humidity_div_class").hide();
  }

  //label
  if(fieldName == 'feed_mortality') {
    $(".actual-label").parent('.form-group').css({'visibility':'visible'});
    $(".actual-label").text('Total Number of Mortalities');
  } else if(fieldName == 'feed_temprature') {
    $(".actual-label").parent('.form-group').css({'visibility':'visible'});
    $(".actual-label").text('Average Temprature');
  } else if(fieldName == 'feed_humidity') {
    $(".actual-label").parent('.form-group').css({'visibility':'hidden'});
    $(".actual-label").text('Average Humidity');
  } else {
    $(".actual-label").parent('.form-group').css({'visibility':'visible'});
    $(".actual-label").text('Actual Value Recorded Today');
  }

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
function editFeed(flockID, field){
  var url = getvalidUrl('FlocksController@editDailyFeed', flockID);
  url = url+"?field="+field;
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
                        if(key=='reasons' && $("#field_name").val() =='feed_mortality'  && value != null){
                          var value12=jQuery.parseJSON(value);
                          if(typeof value12 =='object'){
                            $.each(value12, function(key1, value1) {
                              $("input[name='reason["+key1+"]']").val(value1);
                            });
                          }
                        }
                    });
                }
                //$("#doctor_id").attr('disabled', true);
                $(".modal_button").trigger('click');
            } 
            
        });
}


</script>

@stop