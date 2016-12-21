@extends('layouts.default')

@section('title')
 System Reports - Compare Flocks
@stop

@section('page_title')
  Flock Comparison
@stop

@sub_page_title

@stop

@section('content')
<style type="text/css">
.flockwise_reports, .comparitive_reports, .cosolidated_report_options, .daily_feeds,.weekly_feeds,.titers, #daily_report_table,
#weekly_report_table, #titers_report_table, #consolidated_report_table, .hideIt {display: none;}
td span{font-size: 11px; font-style: italic;}
</style>
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
      	<div>
		      <div class="row">
		        <div class="col-sm-4 col-md-2">
                  <label>Compare</label>
            </div>
            <div class="col-sm-8  col-md-10">
              <div class="form-group clearfix">
                  
                  <select class="section_to_compare form-control" id="parameter_to_compare">
                          <option value="">Select</option>
                          <option value="feed">Feed</option>
                          <option value="feed_water_consumption">Water Consumption</option>
                          <option value="mortality">Mortality</option>
                          <option value="feed_temprature">Temprature</option>
                          <option value="feed_humidity">Humidity</option>
                          <option value="egg_production">Egg Production</option>
                          <option value="feed_egg_weight">Egg Weight</option>
                          <option value="weight">Body Weight</option>
                          <option value="manure_removal">Manure Removal</option>
                          <option value="light_intensity">Light Intensity</option>
                          <option value="wind_velocity">Wind Velocity</option>
                          <option value="titers">Blood Titers</option>
                      </select>
              </div>
            </div>
          </div>
          <div class="row">
              <div class="col-sm-4 col-md-2">
                <label class="control-label">Record</label>
              </div>
              <div class="col-sm-8 col-md-10">
                <div class="form-group clearfix">
                    <div class="form-group clearfix">
                      <select id="record_type" name="record_type" class="form-control">
                        <option value="">--Select--</option>
                        <!-- <option value="days">Days</option> -->
                        <option value="weeks">Weeks</option>
                        <!-- <option value="months">Months</option> -->
                        <option value="date_range">Range of Date</option>
                      </select>
                    </div>
                 
                </div>
              </div>
          </div>
          <div class="row hideIt nested_section" id="blood_titers">
            <div class="col-sm-4 col-md-2">
                <label class="control-label">Blood Titers</label>
              </div>
              <div class="col-sm-8 col-md-10">
                <div class="form-group clearfix">
                    <div class="form-group clearfix">
                  
                      @foreach($titers as $titer)
                        <div class="col-sm-4 col-md-2"><input type="radio" name="blood_titers" class="titer_radio" value="{{$titer->disease_id}}" />&nbsp;&nbsp;{{$titer->disease_name}} </div>
                      @endforeach
                    </div>
                 
                </div>
              </div>
          </div>
          <!-- -->
          <div class="row hideIt nested_section" id="section_feed">
            <div class="col-sm-4 col-md-2">
                <label class="control-label">Feed Reports</label>
              </div>
              <div class="col-sm-8 col-md-10">
                <div class="form-group clearfix">
                    <div class="form-group clearfix">
                        <select class="form-control" id="feed_param">
                            <option value="feed_per_bird">Feed Per Bird</option>
                            <option value="commulative_weekly_feed">commulative weekly Feed Consumption/Bird</option>
                            <option value="commulative_feed_flock">Commulative flock feed consumption/Bird</option>
                            <option value="daily_feed_per_egg">Daily Feed Consumption / Egg</option>
                        </select>
                    </div>
                 
                </div>
              </div>
          </div>
          
          <!-- -->
          <div class="row hideIt nested_section" id="section_mortality">
            <div class="col-sm-4 col-md-2">
                <label class="control-label">Mortality Reports</label>
              </div>
              <div class="col-sm-8 col-md-10">
                <div class="form-group clearfix">
                    <div class="form-group clearfix">
                  
                        <select class="form-control" id="mortality_param">
                            <option value="feed_mortality">Daily Mortality</option>
                            <option value="commulative_daily_mortality">Comulative Daily Mortality Record</option>
                        </select>
                    </div>
                 
                </div>
              </div>
          </div>
          <!-- -->
          <div class="row hideIt nested_section" id="section_egg_production">
            <div class="col-sm-4 col-md-2">
                <label class="control-label">Egg Production Reports</label>
              </div>
              <div class="col-sm-8 col-md-10">
                <div class="form-group clearfix">
                    <div class="form-group clearfix">
                  
                      <select class="form-control" id="egg_production_param"> 
                            <option value="feed_egg_production">Daily Egg Production</option>
                            <option value="eggs_per_hen_housed">Eggs Per Hen Housed</option>
                        </select>
                    </div>
                 
                </div>
              </div>
          </div>
          <!-- -->
          <div class="row hideIt nested_section" id="section_body_weight">
            <div class="col-sm-4 col-md-2">
                <label class="control-label">Body Weight Reports</label>
              </div>
              <div class="col-sm-8 col-md-10">
                <div class="form-group clearfix">
                    <div class="form-group clearfix">
                        <select class="form-control" id="weight_report_param">
                            <option value="feed_egg_production">Weekly Bird Weight</option>
                            <option value="eggs_per_hen_housed">Weekly Bird Weight per day loss/gain</option>
                        </select>
                    </div>
                 
                </div>
              </div>
          </div>
          <!-- -->
          <div class="row">
              <div class="col-sm-12">
                <div id="compare_weeks" class="filters hideIt">
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group clearfix">
                      <label class="col-sm-6 control-label">Compare From Week:</label>
                      <div class="col-sm-6">
                        <div class="form-group clearfix">
                          <select id="compare_week_from" class="form-control">
                            <?php 
                            $strHtml='';
                              for($i=1; $i<90; $i++){
                                
                                $strHtml .= '<option value="'.$i.'">'.$i .'Week</option>';
                                
                              }
                              echo $strHtml;
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group clearfix">
                      <label class="col-sm-6 control-label">Compare End Week:</label>
                      <div class="col-sm-6">
                        <div class="form-group clearfix">
                          <select id="compare_week_end" class="form-control">
                            <?php echo $strHtml; ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <div id="compare_days" class="filters hideIt">
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group clearfix">
                      <label class="col-sm-6 control-label">Compare From Day:</label>
                      <div class="col-sm-6">
                        <div class="form-group clearfix">
                          <select id="compare_day_from" class="form-control">
                            <php 
                            $strHtml='';
                              for($i=1; $i<630; $i++){
                                
                                $strHtml .= '<option value="'.$i.'">'.$i .'Day</option>';
                                
                              }
                              echo $strHtml;
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group clearfix">
                      <label class="col-sm-6 control-label">Compare End Day:</label>
                      <div class="col-sm-6">
                        <div class="form-group clearfix">
                          <select id="compare_day_end" class="form-control">
                            <php echo $strHtml; ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
                <div id="compare_date_range" class="filters hideIt">
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group clearfix">
                      <label class="col-sm-6 col-md-4 control-label">From Date:</label>
                      <div class="col-sm-6 col-md-8">
                        <input type="text" id="dateFrom" class="form-control datepicker" placeholder="fetch record from date" />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group clearfix">
                      <label class="col-sm-6 col-md-4 control-label">End Date:</label>
                      <div class="col-sm-6 col-md-8">
                        <input type="text" id="dateTo" class="form-control datepicker" placeholder="fetch record from date" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="row">
            <div class="col-sm-4 col-md-2">
                  <label>Flocks</label>
            </div>
            <div class="col-sm-8 col-md-10 clearfix">
              
                  @foreach($existingFlocks as $flock)
                    <div class="col-sm-4 col-md-2"><input type="checkbox" name="flocks[]" class="flock_check" value="{{$flock->flock_id}}" />&nbsp;&nbsp;{{$flock->display_id}} </div>
                  @endforeach
              
            </div>
          </div>
          
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group clearfix">
                  <input type="button" class="btn btn-default btn-primary pull-right" id="generate_report" value="Generate It">
                </div>
              </div>    
		        </div>
          </div>
            
		    </div>

        <div id="flock_wise_reports">
          <div class="table-responsive section_reports hideIt" id="section_daily_consolidated">
            <table class="table table-bordered table-stripped" id="daily_consolidated_table" width="100%">
              
                  <thead>
                    <tr>
                      <td rowspan="2" class="flocktd all">Entry Date</td>
                      <td rowspan="2" class="flocktd weeks">Flock Age(week)</td>
                      <td rowspan="2" class="flocktd days">Bird Age(Day)</td>
                       @foreach($existingFlocks as $flock)
                       <td colspan="2" class="flocktd flocktd_{{$flock->flock_id}}" align="center"><strong>{{$flock->display_id}}</strong></td>
                       @endforeach
                    </tr>
                    
                    <tr>
                       @foreach($existingFlocks as $flock)
                        <td class="flocktd flocktd_{{$flock->flock_id}}" align="center">Standard</td>
                        <td class="flocktd flocktd_{{$flock->flock_id}}" align="center">Actual</td>
                      @endforeach
                    </tr>
                  </thead>
              
            </table>
            
        </div>
        <div class="table-responsive section_reports hideIt" id="section_titers_report">
            <table class="table table-bordered table-stripped" id="titer_comparison_table" width="100%">
              
                  <thead>
                    <tr>
                      <td rowspan="2" class="flocktd weeks">Flock Age(week)</td>
                      @foreach($existingFlocks as $flock)
                       <td colspan="2" class="flocktd flocktd_{{$flock->flock_id}}" align="center"><strong>{{$flock->display_id}}</strong></td>
                       @endforeach
                    </tr>
                    
                    <tr>
                       @foreach($existingFlocks as $flock)
                        <td class="flocktd flocktd_{{$flock->flock_id}}" align="center">Range</td>
                        <td class="flocktd flocktd_{{$flock->flock_id}}" align="center">Average</td>
                      @endforeach
                    </tr>
                  </thead>
              
            </table>
            
        </div>
          
      </div>
    </div>
   
</div>
<!-- Form To add New Resources -->
<script type="text/javascript">
$(function(){
  $("#parameter_to_compare").change(function(){
    //section_feed
    // section_mortality
    // section_egg_production
    // section_body_weight
    $(".nested_section").hide();
    if($(this).val() == 'titers'){
      $("#blood_titers").show();
    } else if ($(this).val() == 'feed') {
      $("#section_feed").show();
    } else if ($(this).val() == 'mortality') {
      $("#section_mortality").show();
    } else if ($(this).val() == 'egg_production') {
      $("#section_egg_production").show();
    } else if ($(this).val() == 'weight') {
      $("#section_body_weight").show();
    } 
  })
  $("#record_type").change(function(){
    $(".filters").hide();
    
    $("#compare_"+$(this).val()).show();
    
  });
  $("#generate_report").click(function(){
      var parameter = $("#parameter_to_compare").val();
      if(parameter == ''){
        alert("Select parameter to compare");
        return false;
      }
      if($(".flock_check:checked").length <2){
        alert("please select atleast two flocks to compare");
        return false;
      }

      if($("#record_type").val() === ''){
        alert("Select record Type to proceed.");
        return false;
      }

     
    if(parameter != 'titers' && parameter != 'feed' && parameter != 'mortality' && parameter != 'egg_production' && parameter != 'weight') {
        
        normalComparison();
    } else { // start else statement

          if(parameter == 'titers') { // start if titers
              columns.push({'data': 'bird_age_week'});
              $(".flock_check").each(function(){
                if($(this).is(":checked")){
                  columns.push({'data':'titer_range_'+$(this).val()});
                  columns.push({'data':'titer_avg_'+$(this).val()});
                  $(".flocktd_"+$(this).val()).show();
                  flocks.push($(this).val());
                }
              });
              
              $(".section_reports").hide();
              $("#section_titers_report").show();
              if($(".titer_radio:checked").length == 0){
                alert("Please select blood titer to proceed");
                return false;
              }
              var titer = $(".titer_radio:checked").val();
              var fields= {_token:"{{ csrf_token() }}","titer":titer,"parameter":parameter, "recordType":recordType,"compareDayFrom":compareDayFrom,"compareDayTo":compareDayTo, "compareWeekFrom":compareWeekFrom, "compareWeekEnd":compareWeekEnd,"dateFrom":dateFrom, "dateTo":dateTo, "flocks":flocks }
              $('#titer_comparison_table').DataTable( {
                  "processing": true,
                  "responsive": true,
                  "serverSide": false,
                   destroy: true,
                  "ajax": {
                      "url": "{{action('ReportsController@titerComparisonReporting')}}",
                      "type": "POST",
                      "data" : fields
                  },
                  "columns": columns
              });  
          } // end if titers
          else if (parameter == 'feed') { //start if is feed
            var section= $("#feed_param").val();
              
              if(section == 'feed_per_bird'){
                  normalComparison();
              } else if (section == 'commulative_weekly_feed') {
                var parameter = $("#parameter_to_compare").val();
                var recordType = $("#record_type").val();
                var compareDayFrom=$("#compare_day_from").val();
                var compareDayTo = $("#compare_day_end").val();
                var compareWeekFrom = $("#compare_week_from").val();
                var compareWeekEnd = $("#compare_week_end").val();
                var dateFrom = $("#dateFrom").val();
                var dateTo = $("#dateTo").val();
                var columns=[];
                var flocks = [];

                $(".flocktd").hide();
                if(recordType == ''){
                  columns.push({'data': 'entry_date'});
                  $("td.all").show();
                } else if (recordType == 'days'){
                  columns.push({'data': 'bird_age_day'});
                  $("td.days").show();
                } else if (recordType == 'weeks'){
                  columns.push({'data': 'bird_age_week'})  
                  $("td.weeks").show();
                } else if (recordType == 'date_range'){
                  columns.push({'data': 'entry_date'})
                  $("td.all").show();
                }
                $(".flock_check").each(function(){
                  if($(this).is(":checked")){
                    columns.push({'data':'standard_flock_'+$(this).val()});
                    columns.push({'data':'flock_'+$(this).val()});
                    $(".flocktd_"+$(this).val()).show();
                    flocks.push($(this).val());
                  }
                });
              
                $(".section_reports").show();
                $("#section_titers_report").hide();
                
                var fields= {_token:"{{ csrf_token() }}","parameter":parameter, "recordType":recordType,"compareDayFrom":compareDayFrom,"compareDayTo":compareDayTo, "compareWeekFrom":compareWeekFrom, "compareWeekEnd":compareWeekEnd,"dateFrom":dateFrom, "dateTo":dateTo, "flocks":flocks }
                $('#daily_consolidated_table').DataTable( {
                    "processing": true,
                    "responsive": true,
                    "serverSide": false,
                     destroy: true,
                    "ajax": {
                        "url": "{{action('ReportsController@commulativeWeeklyFeedComp')}}",
                        "type": "POST",
                        "data" : fields
                    },
                    "columns": columns
                });  
              } else if (section == 'commulative_feed_flock') {
                var parameter = $("#parameter_to_compare").val();
                var recordType = $("#record_type").val();
                var compareDayFrom=$("#compare_day_from").val();
                var compareDayTo = $("#compare_day_end").val();
                var compareWeekFrom = $("#compare_week_from").val();
                var compareWeekEnd = $("#compare_week_end").val();
                var dateFrom = $("#dateFrom").val();
                var dateTo = $("#dateTo").val();
                var columns=[];
                var flocks = [];

                $(".flocktd").hide();
                if(recordType == ''){
                  columns.push({'data': 'entry_date'});
                  $("td.all").show();
                } else if (recordType == 'days'){
                  columns.push({'data': 'bird_age_day'});
                  $("td.days").show();
                } else if (recordType == 'weeks'){
                  columns.push({'data': 'bird_age_week'})  
                  $("td.weeks").show();
                } else if (recordType == 'date_range'){
                  columns.push({'data': 'entry_date'})
                  $("td.all").show();
                }
                $(".flock_check").each(function(){
                  if($(this).is(":checked")){
                    columns.push({'data':'standard_flock_'+$(this).val()});
                    columns.push({'data':'flock_'+$(this).val()});
                    $(".flocktd_"+$(this).val()).show();
                    flocks.push($(this).val());
                  }
                });
              
                $(".section_reports").show();
                $("#section_titers_report").hide();
                
                var fields= {_token:"{{ csrf_token() }}","parameter":parameter, "recordType":recordType,"compareDayFrom":compareDayFrom,"compareDayTo":compareDayTo, "compareWeekFrom":compareWeekFrom, "compareWeekEnd":compareWeekEnd,"dateFrom":dateFrom, "dateTo":dateTo, "flocks":flocks }
                $('#daily_consolidated_table').DataTable( {
                    "processing": true,
                    "responsive": true,
                    "serverSide": false,
                     destroy: true,
                    "ajax": {
                        "url": "{{action('ReportsController@commulativeFeedCompFlock')}}",
                        "type": "POST",
                        "data" : fields
                    },
                    "columns": columns
                });  
              } else if (section == 'daily_feed_per_egg') {
                var parameter = $("#parameter_to_compare").val();
                var recordType = $("#record_type").val();
                var compareDayFrom=$("#compare_day_from").val();
                var compareDayTo = $("#compare_day_end").val();
                var compareWeekFrom = $("#compare_week_from").val();
                var compareWeekEnd = $("#compare_week_end").val();
                var dateFrom = $("#dateFrom").val();
                var dateTo = $("#dateTo").val();
                var columns=[];
                var flocks = [];

                $(".flocktd").hide();
                if(recordType == ''){
                  columns.push({'data': 'entry_date'});
                  $("td.all").show();
                } else if (recordType == 'days'){
                  columns.push({'data': 'bird_age_day'});
                  $("td.days").show();
                } else if (recordType == 'weeks'){
                  columns.push({'data': 'bird_age_week'})  
                  $("td.weeks").show();
                } else if (recordType == 'date_range'){
                  columns.push({'data': 'entry_date'})
                  $("td.all").show();
                }
                $(".flock_check").each(function(){
                  if($(this).is(":checked")){
                    columns.push({'data':'standard_flock_'+$(this).val()});
                    columns.push({'data':'flock_'+$(this).val()});
                    $(".flocktd_"+$(this).val()).show();
                    flocks.push($(this).val());
                  }
                });
              
                $(".section_reports").show();
                $("#section_titers_report").hide();
                
                var fields= {_token:"{{ csrf_token() }}","parameter":parameter, "recordType":recordType,"compareDayFrom":compareDayFrom,"compareDayTo":compareDayTo, "compareWeekFrom":compareWeekFrom, "compareWeekEnd":compareWeekEnd,"dateFrom":dateFrom, "dateTo":dateTo, "flocks":flocks }
                $('#daily_consolidated_table').DataTable( {
                    "processing": true,
                    "responsive": true,
                    "serverSide": false,
                     destroy: true,
                    "ajax": {
                        "url": "{{action('ReportsController@comparisonFeedPerEgg')}}",
                        "type": "POST",
                        "data" : fields
                    },
                    "columns": columns
                }); 
              }

          } // end if is feed
          else if (parameter == 'mortality') { //start if mortality
            var section= $("#mortality_param").val();
            if(section == 'feed_mortality'){
                normalComparison();
            } else { //commulative_daily_mortality
                var parameter = $("#parameter_to_compare").val();
                var recordType = $("#record_type").val();
                var compareDayFrom=$("#compare_day_from").val();
                var compareDayTo = $("#compare_day_end").val();
                var compareWeekFrom = $("#compare_week_from").val();
                var compareWeekEnd = $("#compare_week_end").val();
                var dateFrom = $("#dateFrom").val();
                var dateTo = $("#dateTo").val();
                var columns=[];
                var flocks = [];

                $(".flocktd").hide();
                if(recordType == ''){
                  columns.push({'data': 'entry_date'});
                  $("td.all").show();
                } else if (recordType == 'days'){
                  columns.push({'data': 'bird_age_day'});
                  $("td.days").show();
                } else if (recordType == 'weeks'){
                  columns.push({'data': 'bird_age_week'})  
                  $("td.weeks").show();
                } else if (recordType == 'date_range'){
                  columns.push({'data': 'entry_date'})
                  $("td.all").show();
                }
                $(".flock_check").each(function(){
                  if($(this).is(":checked")){
                    columns.push({'data':'standard_flock_'+$(this).val()});
                    columns.push({'data':'flock_'+$(this).val()});
                    $(".flocktd_"+$(this).val()).show();
                    flocks.push($(this).val());
                  }
                });
              
                $(".section_reports").show();
                $("#section_titers_report").hide();

                var fields= {_token:"{{ csrf_token() }}","parameter":parameter, "recordType":recordType,"compareDayFrom":compareDayFrom,"compareDayTo":compareDayTo, "compareWeekFrom":compareWeekFrom, "compareWeekEnd":compareWeekEnd,"dateFrom":dateFrom, "dateTo":dateTo, "flocks":flocks }
                $('#daily_consolidated_table').DataTable( {
                    "processing": true,
                    "responsive": true,
                    "serverSide": false,
                     destroy: true,
                    "ajax": {
                        "url": "{{action('ReportsController@compCommulativeDailyMortality')}}",
                        "type": "POST",
                        "data" : fields
                    },
                    "columns": columns
                }); 
            }

          }//end if mortality
          else if (parameter == 'egg_production') { //start if egg_production
            var section= $("#egg_production_param").val();
            if(section == 'feed_egg_production'){
                normalComparison();
            } else { //eggs_per_hen_housed
                var parameter = $("#parameter_to_compare").val();
                var recordType = $("#record_type").val();
                var compareDayFrom=$("#compare_day_from").val();
                var compareDayTo = $("#compare_day_end").val();
                var compareWeekFrom = $("#compare_week_from").val();
                var compareWeekEnd = $("#compare_week_end").val();
                var dateFrom = $("#dateFrom").val();
                var dateTo = $("#dateTo").val();
                var columns=[];
                var flocks = [];

                $(".flocktd").hide();
                if(recordType == ''){
                  columns.push({'data': 'entry_date'});
                  $("td.all").show();
                } else if (recordType == 'days'){
                  columns.push({'data': 'bird_age_day'});
                  $("td.days").show();
                } else if (recordType == 'weeks'){
                  columns.push({'data': 'bird_age_week'})  
                  $("td.weeks").show();
                } else if (recordType == 'date_range'){
                  columns.push({'data': 'entry_date'})
                  $("td.all").show();
                }
                $(".flock_check").each(function(){
                  if($(this).is(":checked")){
                    columns.push({'data':'standard_flock_'+$(this).val()});
                    columns.push({'data':'flock_'+$(this).val()});
                    $(".flocktd_"+$(this).val()).show();
                    flocks.push($(this).val());
                  }
                });
              
                $(".section_reports").show();
                $("#section_titers_report").hide();

                var fields= {_token:"{{ csrf_token() }}","parameter":parameter, "recordType":recordType,"compareDayFrom":compareDayFrom,"compareDayTo":compareDayTo, "compareWeekFrom":compareWeekFrom, "compareWeekEnd":compareWeekEnd,"dateFrom":dateFrom, "dateTo":dateTo, "flocks":flocks }
                $('#daily_consolidated_table').DataTable( {
                    "processing": true,
                    "responsive": true,
                    "serverSide": false,
                     destroy: true,
                    "ajax": {
                        "url": "{{action('ReportsController@compEggPerHenHoused')}}",
                        "type": "POST",
                        "data" : fields
                    },
                    "columns": columns
                }); 
            }
          } // end if egg production
          else if (parameter == 'weight') { //start if weight
            var section= $("#weight_report_param").val();
            if(section == 'feed_weight'){
                normalComparison();
            } else { //eggs_per_hen_housed
                 var parameter = $("#parameter_to_compare").val();
                var recordType = $("#record_type").val();
                var compareDayFrom=$("#compare_day_from").val();
                var compareDayTo = $("#compare_day_end").val();
                var compareWeekFrom = $("#compare_week_from").val();
                var compareWeekEnd = $("#compare_week_end").val();
                var dateFrom = $("#dateFrom").val();
                var dateTo = $("#dateTo").val();
                var columns=[];
                var flocks = [];

                $(".flocktd").hide();
                if(recordType == ''){
                  columns.push({'data': 'entry_date'});
                  $("td.all").show();
                } else if (recordType == 'days'){
                  columns.push({'data': 'bird_age_day'});
                  $("td.days").show();
                } else if (recordType == 'weeks'){
                  columns.push({'data': 'bird_age_week'})  
                  $("td.weeks").show();
                } else if (recordType == 'date_range'){
                  columns.push({'data': 'entry_date'})
                  $("td.all").show();
                }
                $(".flock_check").each(function(){
                  if($(this).is(":checked")){
                    columns.push({'data':'standard_flock_'+$(this).val()});
                    columns.push({'data':'flock_'+$(this).val()});
                    $(".flocktd_"+$(this).val()).show();
                    flocks.push($(this).val());
                  }
                });
              
                $(".section_reports").show();
                $("#section_titers_report").hide();

                var fields= {_token:"{{ csrf_token() }}","parameter":parameter, "recordType":recordType,"compareDayFrom":compareDayFrom,"compareDayTo":compareDayTo, "compareWeekFrom":compareWeekFrom, "compareWeekEnd":compareWeekEnd,"dateFrom":dateFrom, "dateTo":dateTo, "flocks":flocks }
                $('#daily_consolidated_table').DataTable( {
                    "processing": true,
                    "responsive": true,
                    "serverSide": false,
                     destroy: true,
                    "ajax": {
                        "url": "{{action('ReportsController@compBodyWeight')}}",
                        "type": "POST",
                        "data" : fields
                    },
                    "columns": columns
                }); 
            }
          }//end if weight
    } //end else statement if not general parameters
      
  });

  $('.datepicker').datepicker({'format':'yyyy-mm-dd','viewMode':'2',autoclose: true, startDate: '-1d'}).on('changeDate', function(e){
        $(this).datepicker('hide');
    });
  
  
});

function normalComparison () {
      var parameter = $("#parameter_to_compare").val();
      var recordType = $("#record_type").val();
      var compareDayFrom=$("#compare_day_from").val();
      var compareDayTo = $("#compare_day_end").val();
      var compareWeekFrom = $("#compare_week_from").val();
      var compareWeekEnd = $("#compare_week_end").val();
      var dateFrom = $("#dateFrom").val();
      var dateTo = $("#dateTo").val();
      var columns=[];
      var flocks = [];

      $(".flocktd").hide();
      if(recordType == ''){
        columns.push({'data': 'entry_date'});
        $("td.all").show();
      } else if (recordType == 'days'){
        columns.push({'data': 'bird_age_day'});
        $("td.days").show();
      } else if (recordType == 'weeks'){
        columns.push({'data': 'bird_age_week'})  
        $("td.weeks").show();
      } else if (recordType == 'date_range'){
        columns.push({'data': 'entry_date'})
        $("td.all").show();
      }
      $(".flock_check").each(function(){
        if($(this).is(":checked")){
          columns.push({'data':'standard_flock_'+$(this).val()});
          columns.push({'data':'flock_'+$(this).val()});
          $(".flocktd_"+$(this).val()).show();
          flocks.push($(this).val());
        }
      });
      $(".section_reports").hide();
      $("#section_daily_consolidated").show();
        var fields= {_token:"{{ csrf_token() }}","parameter":parameter, "recordType":recordType,"compareDayFrom":compareDayFrom,"compareDayTo":compareDayTo, "compareWeekFrom":compareWeekFrom, "compareWeekEnd":compareWeekEnd,"dateFrom":dateFrom, "dateTo":dateTo, "flocks":flocks }
      $('#daily_consolidated_table').DataTable( {
          "processing": true,
          "responsive": true,
          "serverSide": false,
           destroy: true,
          "ajax": {
              "url": "{{action('ReportsController@flockComparisonReporting')}}",
              "type": "POST",
              "data" : fields
          },
          "columns": columns
      });  

}
</script>
@include("reports/reportingFunctions")

@stop