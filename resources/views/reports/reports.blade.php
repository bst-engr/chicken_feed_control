@extends('layouts.default')

@section('title')
 System Reports
@stop

@section('page_title')
  Generate Reports
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
		        <div class="col-sm-2">
                  <label>Report Format</label>
            </div>
            <div class="col-sm-10">
              <div class="form-group clearfix">
                  <label><input type="radio" name="report_format" class="report_format" value="1"/>&nbsp;&nbsp;&nbsp;Flock Wise Report</label>
                  <label><input type="radio" name="report_format" class="report_format" value="2"/>&nbsp;&nbsp;&nbsp;Comparitive Report</label>
              </div>
            </div>
          </div>
          <div class="row">
              <div class="col-sm-12 col-md-3">
                <div class="form-group clearfix">
                    <label for="inputEmail3" class="col-sm-12 control-label"><input type="checkbox" class="checkAll"/>Record for All Dates</label>
                </div>
              </div>
              <div class="col-sm-12 col-md-4">
                <div class="form-group clearfix">
                  <label class="col-sm-6 col-md-4 control-label">From Date:</label>
                  <div class="col-sm-6 col-md-8">
                    <input type="text" id="dateFrom" class="form-control datepicker" placeholder="fetch record from date" />
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-4">
                <div class="form-group clearfix">
                  <label class="col-sm-6 col-md-4 control-label">End Date:</label>
                  <div class="col-sm-6 col-md-8">
                    <input type="text" id="dateTo" class="form-control datepicker" placeholder="fetch record from date" />
                  </div>
                </div>
              </div>
          </div>
          <div class="row flockwise_reports">
              <div class="col-sm-12 col-md-3">
                <div class="form-group clearfix">
                  <label class="col-sm-6 col-md-4 control-label">Flock:</label>
                  <div class="col-sm-6 col-md-8">
                    <select name="flocks" id="flocks" class="form-control">
                      <option value="">Select</option>
                      @if($existingFlocks)
                        @foreach($existingFlocks as $flock)
                          <option value="{{$flock->flock_id}}">{{$flock->display_id}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-4">
                <div class="form-group clearfix">
                  <label class="col-sm-6 col-md-4 control-label">ReportType:</label>
                  <div class="col-sm-6 col-md-8">
                    <select name="report_type" id="report_type" class="form-control">
                      <option value="">Select</option>
                      <option value="daily">Daily Feeed Report</option>
                      <option value="weekly">Weekly Flock Report</option>
                      <option value="consolidated">Consolidated weekly & Daily</option>
                      <option value="titers">Blood Titers</option>  
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-5">
                <div class="form-group clearfix">
                    <div class="daily_feeds">
                          
                      <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="feed_per_bird"/>&nbsp;&nbsp;&nbsp;Daily Feed per Bird</span>
                      <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="feed_water_consumption"/>&nbsp;&nbsp;&nbsp;Water Consumption</span>
                      <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="feed_mortality"/>&nbsp;&nbsp;&nbsp;Mortality</span>
                      <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="feed_temprature"/>&nbsp;&nbsp;&nbsp;Temprature</span>
                      <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="feed_humidity"/>&nbsp;&nbsp;&nbsp;Humidity</span>
                      <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="feed_egg_weight"/>&nbsp;&nbsp;&nbsp;Egg Weight</span>
                      <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="feed_egg_production"/>&nbsp;&nbsp;&nbsp;Egg Production</span>
                    </div>
                    <div class="weekly_feeds">
                      
                      <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="body_weight"/>&nbsp;&nbsp;&nbsp;Body Weight</span>
                      <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="uniformity"/>&nbsp;&nbsp;&nbsp;Uniformity</span>
                      <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="manure_removal"/>&nbsp;&nbsp;&nbsp;Manure Removal</span>
                      <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="light_intensity"/>&nbsp;&nbsp;&nbsp;Light Intensity</span>
                      <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="wind_velocity"/>&nbsp;&nbsp;&nbsp;Wind Velocity</span>
                    </div>
                    <div class="cosolidated_report_options">
                        <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="daily_consolidated"/>&nbsp;&nbsp;&nbsp;Daily Consolidated Report</span>
                      <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="weekly_consolidated"/>&nbsp;&nbsp;&nbsp;Weekly Consolidated Report</span>
                    </div>
                    <div class="titers">
                      @if($titers)
                        @foreach($titers as $titer)
                          <span class="span-sm-3"><input type="radio" name="reportParam" class="report_fields" value="{{$titer->disease_id}}"/> &nbsp;&nbsp;&nbsp;{{$titer->disease_name}}</span>
                        @endforeach
                      @endif
                    </div>
                </div>
              </div>
            </div>
            <div class="row comparitive_reports">
              <div class="col-sm-6">
                  <div class="form-group clearfix">
                    <label class="col-sm-3 control-label">Compare Section: </label>
                    <div class="col-sm-9">
                      <select class="section_to_compare form-control">
                          <option value="">Select</option>
                          <option value="">Feed</option>
                          <option value="">Water Consumption</option>
                          <option value="">Mortality</option>
                          <option value="">Temprature</option>
                          <option value="">Humidity</option>
                          <option value="">Egg Weight</option>
                          <option value="">Body Weight</option>
                          <option value="">Manure Removal</option>
                          <option value="">Light Intensity</option>
                          <option value="">Wind Velocity</option>
                          <option value="">block Titers</option>
                          <option value="">Cost/ Egg Daily Weekly Monthly D to D Reports</option>
                      </select>
                    </div>
                  </div>
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
          <div class="table-responsive section_reports hideIt" id="section_feed_per_bird">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#daily_feed_rep">Feed Consumption/Bird</a></li>
              <li><a data-toggle="tab" href="#commulative_feed_rep">Commulative Weekly Feed Consumption/Bird</a></li>
              <li><a data-toggle="tab" href="#commulative_flock_feed">Commulative Flock Feed Consumption/Bird</a></li>
              <li><a data-toggle="tab" href="#feed_per_bird_rep">Daily Feed Consumption/Bird</a></li>
              
            </ul>
            <div class="tab-content">
              <div id="daily_feed_rep" class="tab-pane fade in active">
                <table class="table table-bordered table-stripped" id="daily_feed_table" width="100%">
                    <thead>
                      <tr>
                        <td rowspan="2" valign="bottom">Entry Date</td>
                        <td rowspan="2" valign="bottom">Flock Age(week)</td>
                        <td rowspan="2" valign="bottom">Flock Age(Day)</td>
                        <td colspan="2" align="center"><strong>Feed</strong><span>grm</span></td>
                      </tr>
                      <tr>
                        <td class="standard_feed_per_bird">Standard</td>
                        <td class="feed_per_bird">Actual</td>
                      </tr>
                    </thead>

                </table>
              </div>
              <div id="commulative_feed_rep" class="tab-pane fade">
                <table class="table table-bordered table-stripped" id="comulative_weekly_feed_table" width="100%">
                    <thead>
                      <tr>
                        <td rowspan="2" valign="bottom">Entry Date</td>
                        <td rowspan="2" valign="bottom">Flock Age(week)</td>
                        <td rowspan="2" valign="bottom">Flock Age(Day)</td>
                        <td colspan="2" align="center"><strong>Feed</strong><span>grm</span></td>
                      </tr>
                      <tr>
                        <td class="standard_feed_per_bird">Standard</td>
                        <td class="feed_per_bird">Actual</td>
                      </tr>
                    </thead>

                </table>
              </div>
              <div id="commulative_flock_feed" class="tab-pane fade">
                <table class="table table-bordered table-stripped" id="comulative_flock_feed_table" width="100%">
                    <thead>
                      <tr>
                        <td rowspan="2" valign="bottom">Entry Date</td>
                        <td rowspan="2" valign="bottom">Flock Age(week)</td>
                        <td rowspan="2" valign="bottom">Flock Age(Day)</td>
                        <td colspan="2" align="center"><strong>Feed</strong><span>Kg.</span></td>
                      </tr>
                      <tr>
                        <td class="standard_feed_per_bird">Standard</td>
                        <td class="feed_per_bird">Actual</td>
                      </tr>
                    </thead>

                </table>
              </div>
              <div id="feed_per_bird_rep" class="tab-pane fade">
                <table class="table table-bordered table-stripped" id="daily_feed_per_egg" width="100%">
                    <thead>
                      <tr>
                        <td rowspan="2" valign="bottom">Entry Date</td>
                        <td rowspan="2" valign="bottom">Flock Age(week)</td>
                        <td rowspan="2" valign="bottom">Flock Age(Day)</td>
                        <td colspan="2" align="center"><strong>Feed</strong><span>grm</span></td>
                      </tr>
                      <tr>
                        <td class="standard_feed_per_bird">Standard</td>
                        <td class="feed_per_bird">Actual</td>
                      </tr>
                    </thead>

                </table>
              </div>
            </div>
          </div>
          <!-- Daily Water Consumptions. -->
          <div class="table-responsive section_reports hideIt" id="section_feed_water_consumption">
              <table class="table table-bordered table-stripped" id="daily_feed_water_consumption_table">
                    <thead>
                      <tr>
                        <td rowspan="2" valign="bottom">Entry Date</td>
                        <td rowspan="2" valign="bottom">Flock Age(week)</td>
                        <td rowspan="2" valign="bottom">Flock Age(Day)</td>
                        <td colspan="2" align="center"><strong>Water Consumption</strong><span>ml</span></td>
                      </tr>
                      <tr>
                        <td class="standard_feed_per_bird">Standard</td>
                        <td class="feed_per_bird">Actual</td>
                      </tr>
                    </thead>

                </table>
          </div>
          <!-- Daily Mortality. --> 
          <div class="table-responsive section_reports hideIt" id="section_feed_mortality">
              <table class="table table-bordered table-stripped" id="daily_feed_mortality_table">
                    <thead>
                      <tr>
                        <td rowspan="2" valign="bottom">Entry Date</td>
                        <td rowspan="2" valign="bottom">Flock Age(week)</td>
                        <td rowspan="2" valign="bottom">Flock Age(Day)</td>
                        <td colspan="2" align="center"><strong>Reasons</strong><span>no of birds.</span></td>
                        <td colspan="{{count($reasons)}}">Reasons</td>
                      </tr>
                      <tr>
                        <td class="standard_feed_per_bird">Standard</td>
                        <td class="feed_per_bird">Actual</td>
                        <?php
                          foreach($reasons as $reason){
                            ?>
                            <td class="reason_{{$reason->id}}">{{$reason->reason_name}}</td>
                            <?php
                          }
                        ?>
                      </tr>
                    </thead>

                </table>
          </div>
          <!-- Daily Temprature. -->
          <div class="table-responsive section_reports hideIt" id="section_feed_temprature">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#temprature_record_rep">Temprature Record</a></li>
              <li><a data-toggle="tab" href="#feeling_temprature_record">Feeling Temprature Record</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade in active" id="temprature_record_rep">
                <table class="table table-bordered table-stripped" id="daily_feed_temprature_table">
                    <thead>
                      <tr>
                        <td rowspan="2" valign="bottom">Entry Date</td>
                        <td rowspan="2" valign="bottom">Flock Age(week)</td>
                        <td rowspan="2" valign="bottom">Flock Age(Day)</td>
                        <td colspan="5" align="center"><strong>Inner</strong><span>C</span></td>
                        <td colspan="2" align="center">Outside</td>
                      </tr>
                      <tr>
                        <td class="standard_feed_per_bird">Standard</td>
                        <td class="feed_per_bird">Average</td>
                        <td class="feed_per_bird">Feeling Temp</td>
                        <td class="feed_per_bird">Lowest</td>
                        <td class="feed_per_bird">Higest</td>
                        <td class="feed_per_bird">Highest</td>
                        <td class="feed_per_bird">Lowest</td>

                      </tr>
                    </thead>

                </table>
              </div>
              <div class="tab-pane fade" id="feeling_temprature_record">
                  <table class="table table-bordered table-stripped" id="daily_feed_feeling_temprature" width="100%">
                    <thead>
                      <tr>
                        <td rowspan="2" valign="bottom">Entry Date</td>
                        <td rowspan="2" valign="bottom">Flock Age(week)</td>
                        <td rowspan="2" valign="bottom">Flock Age(Day)</td>
                        <td colspan="2" align="center"><strong>Temprature</strong><span>c</span></td>
                      </tr>
                      <tr>
                        <td class="standard_feed_per_bird">Standard</td>
                        <td class="feed_per_temprature">Average</td>
                      </tr>
                    </thead>

                </table>
              </div>
            </div>
          </div>

          <!-- Daily Humidity --> 
          <div class="table-responsive section_reports hideIt" id="section_feed_humidity">
              <table class="table table-bordered table-stripped" id="daily_feed_humidity_table">
                    <thead>
                      <tr>
                        <td rowspan="2" valign="bottom">Entry Date</td>
                        <td rowspan="2" valign="bottom">Flock Age(week)</td>
                        <td rowspan="2" valign="bottom">Flock Age(Day)</td>
                        <td></td>
                        <td colspan="" align="center"><strong>Inner</strong><span>%age</span></td>
                        <td colspan="" align="center"><strong>Outside</strong><span>%age</span></td>
                      </tr>
                      <tr>
                        <td class="standard_feed_per_bird">Standard</td>
                        <td class="feed_humidity">Actual</td>
                        <td class="feed_humidity">Actual</td>
                      </tr>
                    </thead>

                </table>
          </div>
          <!-- Daily Water Consumptions. --> 
          <div class="table-responsive section_reports hideIt" id="section_feed_egg_weight">
              <table class="table table-bordered table-stripped" id="daily_feed_egg_weight_table">
                    <thead>
                      <tr>
                        <td rowspan="2" valign="bottom">Entry Date</td>
                        <td rowspan="2" valign="bottom">Flock Age(week)</td>
                        <td rowspan="2" valign="bottom">Flock Age(Day)</td>
                        <td colspan="2" align="center"><strong>Egg Weight</strong><span>grm.</span></td>
                      </tr>
                      <tr>
                        <td class="standard_feed_per_bird">Standard</td>
                        <td class="feed_per_bird">Actual</td>
                      </tr>
                    </thead>

                </table>
          </div>
          <!-- Daily Water Consumptions. --> 
          <div class="table-responsive section_reports hideIt" id="section_feed_egg_production">
              <table class="table table-bordered table-stripped" id="daily_feed_egg_production_table">
                    <thead>
                      <tr>
                        <td rowspan="2" valign="bottom">Entry Date</td>
                        <td rowspan="2" valign="bottom">Flock Age(week)</td>
                        <td rowspan="2" valign="bottom">Flock Age(Day)</td>
                        <td colspan="2" align="center"><strong>Egg Production</strong><span>no of eggs.</span></td>
                      </tr>
                      <tr>
                        <td class="standard_feed_per_bird">Standard</td>
                        <td class="feed_per_bird">Actual</td>
                      </tr>
                    </thead>

                </table>
          </div>
          <!--Weekly Reporting Section Start-->
          <div class="table-responsive section_reports hideIt" id="section_body_weight">
            <div>
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#weekly_body_weight_rep">Weekly Body Weight Record</a></li>
                <li><a data-toggle="tab" href="#weekly_body_weight_gain_loss">Weekly Bird Weight Per Day Gain/Loss</a></li>              
              </ul>
              <div class="tab-content">  
                <div class="tab-pane fade in active" id="weekly_body_weight_rep">
                  <table class="table table-bordered table-stripped" id="weekly_body_weight_table" width="100%">
                      <thead>
                        <tr>
                          <td rowspan="2" valign="bottom">Entry Date</td>
                          <td rowspan="2" valign="bottom">Flock Age(week)</td>
                          <td colspan="2" align="center"><strong>Weight Grams</strong><span>Weekly</span></td>
                          <td colspan="2" align="center"><strong>Weight Uniformity</strong><span>%</span></td>
                        </tr>
                        <tr>
                          <td class="standard_feed_per_bird">Standard</td>
                          <td class="feed_per_bird">Actual</td>
                          <td class="standard_feed_per_bird">Standard</td>
                          <td class="feed_per_bird">Actual</td>
                        </tr>
                      </thead>

                  </table>
                </div>
                <div class="tab-pane fade" id="weekly_body_weight_gain_loss">
                  <table class="table table-bordered table-stripped" id="weekly_body_weight_gain_table" width="100%">
                      <thead>
                        <tr>
                          <td rowspan="2" valign="bottom">Entry Date</td>
                          <td rowspan="2" valign="bottom">Flock Age(week)</td>
                          <td colspan="2" align="center"><strong>Weight Grams</strong><span>Weekly</span></td>
                          
                        </tr>
                        <tr>
                          <td class="standard_feed_per_bird">Standard</td>
                          <td class="feed_per_bird">Actual</td>
                        </tr>
                      </thead>

                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- Uniformity -->
          <div class="table-responsive section_reports hideIt" id="section_uniformity">
             
            
              <table class="table table-bordered table-stripped" id="weekly_uniformity_table" width="100%">
                  <thead>
                    <tr>
                      <td rowspan="2" valign="bottom">Entry Date</td>
                      <td rowspan="2" valign="bottom">Flock Age(week)</td>
                      <td colspan="2" align="center"><strong>Uniformity</strong><span>%</span></td>
                    </tr>
                    <tr>
                      <td class="standard_feed_per_bird">Standard</td>
                      <td class="feed_per_bird">Actual</td>
                    </tr>
                  </thead>

              </table>
            
             
          </div>
          <!-- Manure Removal  -->
          <div class="table-responsive section_reports hideIt" id="section_manure_removal">
             
            
              <table class="table table-bordered table-stripped" id="weekly_manure_removal_table" width="100%">
                  <thead>
                    <tr>
                      <td rowspan="2" valign="bottom">Entry Date</td>
                      <td rowspan="2" valign="bottom">Flock Age(week)</td>
                      <td colspan="2" align="center"><strong>Manure Removal </strong><span>KG</span></td>
                    </tr>
                    <tr>
                      <td class="standard_feed_per_bird">Standard</td>
                      <td class="feed_per_bird">Actual</td>
                    </tr>
                  </thead>

              </table>
            
             
          </div>
          <!-- Light Intensity -->
          <div class="table-responsive section_reports hideIt" id="section_light_intensity">
             
            
              <table class="table table-bordered table-stripped" id="weekly_light_intensity_table" width="100%">
                  <thead>
                    <tr>
                      <td rowspan="2" valign="bottom">Entry Date</td>
                      <td rowspan="2" valign="bottom">Flock Age(week)</td>
                      <td colspan="2" align="center"><strong>Light Intensity </strong><span>Lux</span></td>
                    </tr>
                    <tr>
                      <td class="standard_feed_per_bird">Standard</td>
                      <td class="feed_per_bird">Actual</td>
                    </tr>
                  </thead>

              </table>
            
             
          </div>
          <!-- Wind Velocity -->
          <div class="table-responsive section_reports hideIt" id="section_wind_velocity">
             
            
              <table class="table table-bordered table-stripped" id="weekly_wind_velocity_table" width="100%">
                  <thead>
                    <tr>
                      <td rowspan="2" valign="bottom">Entry Date</td>
                      <td rowspan="2" valign="bottom">Flock Age(week)</td>
                      <td colspan="2" align="center"><strong>Wind Velocity </strong><span>CFM</span></td>
                    </tr>
                    <tr>
                      <td class="standard_feed_per_bird">Standard</td>
                      <td class="feed_per_bird">Actual</td>
                    </tr>
                  </thead>

              </table>
            
             
          </div>
          <!-- End Weekly Reporting Section -->
          <!-- Consolidated Report  -->
            
          <div class="table-responsive section_reports hideIt" id="section_daily_consolidated">
            <table class="table table-bordered table-stripped" id="daily_consolidated_table">
              <thead>
                  <thead>
                    <tr>
                      <td rowspan="3">Entry Date</td>
                      <td rowspan="3">Flock Age(week)</td>
                      <td rowspan="3">Bird Age(Day)</td>
                      <td colspan="2" align="center"><strong>Feed/Bird</strong></td>
                      <td colspan="2" align="center"><strong>Water/Bird</strong></td>
                      <td colspan="2" align="center"><strong>Egg Production</strong></td>
                      <td colspan="2" align="center"><strong>Egg Weight</strong></td>
                      <td colspan="2" align="center"><strong>Mortality</strong></td>
                      <td colspan="2" align="center"><strong>Temprature</strong></td>
                      <td colspan="2" align="center"><strong>Humidity</strong></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center">grams</td>
                      <td colspan="2" align="center">ml.</td>
                      <td colspan="2" align="center">Percentage</td>
                      <td colspan="2" align="center">Grams</td>
                      <td colspan="2" align="center">Number of Birds</td>
                      <td colspan="2" align="center">Degree Celcius</td>
                      <td colspan="2" align="center">Percentage</td>
                    </tr>
                    <tr>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                    </tr>
                  </thead>
              </thead>
            </table>
            
        </div>

        <!-- -->
        <div class="table-responsive section_reports hideIt" id="section_weekly_consolidated">
            <table class="table table-bordered table-stripped" id="weekly_consolidated_table">
              <thead>
                  <thead>
                    <tr>
                      <td rowspan="3">Entry Date</td>
                      <td rowspan="3">Flock Age(week)</td>
                      <td colspan="2" align="center"><strong>Feed Intake</strong></td>
                      <td colspan="2" align="center"><strong>Water Intake</strong></td>
                      <td colspan="2" align="center"><strong>Mortality</strong></td>
                      <td colspan="2" align="center"><strong>Egg Production</strong></td>
                      <td colspan="2" align="center"><strong>Egg Weight</strong></td>
                      <td colspan="2" align="center"><strong>Egg Hen Housed</strong></td>
                      <td colspan="2" align="center"><strong>Body Weight</strong></td>
                      <td colspan="2" align="center"><strong>Manure Removal</strong></td>
                      <td colspan="2" align="center"><strong>Light Intensity</strong></td>
                      <td colspan="2" align="center"><strong>Wind Velocity</strong></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center">grams</td>
                      <td colspan="2" align="center">ml.</td>
                      <td colspan="2" align="center">Number of Birds</td>
                      <td colspan="2" align="center">Percentage</td>
                      <td colspan="2" align="center">Grams</td>
                      <td colspan="2" align="center"></td>
                      <td colspan="2" align="center">Grams</td>
                      <td colspan="2" align="center">KG</td>
                      <td colspan="2" align="center">Lux</td>
                      <td colspan="2" align="center">CFM</td>
                      
                    </tr>
                    <tr>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                      <td colspan="">Standard</td>
                      <td colspan="">Actual</td>
                    </tr>
                  </thead>
              </thead>
            </table>
            
        </div>

        <!-- Titers Report -->
         <div class="table-responsive section_reports hideIt" id="section_titers">
            <table class="table table-bordered table-stripped" id="titer_table">
              <thead>
                  <thead>
                    <tr>
                      <td rowspan="">Entry Date</td>
                      <td rowspan="">Flock Age(week)</td>
                      <td align="center"><strong>Lab Name</strong></td>
                      <td colspan="" align="center"><strong>Range</strong></td>
                      <td colspan="" align="center"><strong>Average</strong></td>
                    </tr>
                  </thead>
              </thead>
            </table>
            
        </div>

        <!-- Basic Comparative Reports -->
		
      </div>
    </div>
   
</div>
<!-- Form To add New Resources -->
<script type="text/javascript">
$(function(){
  
  $("#generate_report").click(function(){
    //checks for report format either flock wise or comparitive.
      if($(".report_format:checked").val() == 1){
          var currVal = $("#report_type").val();
          if($("#flocks").val() == ''){
            alert("Select Any flock to proceed");
            return false;
          }
          //setting up variables to submit for data.
          var isAll = $(".checkAll").is(":checked") ? true : false;
          var fromDate =  $("#dateFrom").val();
          var endDate =  $("#dateTo").val();
          var report_type = $("#report_type").val();

          if(currVal == 'daily') {
            generateReportData($(".daily_feeds input:checked").val());
            //--------------------------------------
          } else if (currVal == 'weekly'){
            WeeklyReportings($(".weekly_feeds input:checked").val());
          } else if (currVal == 'consolidated'){
            consolidatedReportings($(".cosolidated_report_options input:checked").val());
          } else if (currVal == 'titers'){
           titersReporting($(".titers input:checked").val())
          } else {
            alert("Please Choose report Type to continue");
          }
      
      } else if ($(".report_format:checked").val() == 2) {
        $(".comparitive_reports").hide();
      } else {
        alert("Choose Report Format to continue");
      }
  });

  $('.datepicker').datepicker({'format':'yyyy-mm-dd','viewMode':'2',autoclose: true, startDate: '-1d'}).on('changeDate', function(e){
        $(this).datepicker('hide');
    });
  $('#history_list').DataTable({
          responsive: true
  });
  $(".checkAll").click(function(){
      if($(this).is(':checked')){
        $(".datepicker").attr('disabled',true);
      } else {
        $(".datepicker").attr('disabled',false);
      }
  });

  $("#report_type").change(function(){
    var currVal = $(this).val();
    if(currVal == 'daily') {
      $(".daily_feeds").show();
      $(".weekly_feeds, .titers, .cosolidated_report_options").hide();
    } else if (currVal == 'weekly'){
      $(".weekly_feeds").show();
      $(".daily_feeds, .titers,.cosolidated_report_options").hide();
    } else if (currVal == 'consolidated'){
      $(".cosolidated_report_options").show();
      $(".titers,.daily_feeds, .weekly_feeds").hide();
    } else if (currVal == 'titers'){
      $(".titers").show();
      $(".weekly_feeds, .daily_feeds,.cosolidated_report_options").hide();
    } else {
      $(".daily_feeds,.weekly_feeds, .titers,.cosolidated_report_options").hide();
    }
  });
  $(".report_format").click(function(){
    var reportFormat = $(".report_format:checked").val();
    if(reportFormat == '1'){
      $(".flockwise_reports").show();
      $(".comparitive_reports").hide();
    } else{
      $(".flockwise_reports").hide();
      $(".comparitive_reports").show();
    }
  });
});

function consolidatedReportings(reportParam){
  var isAll = $(".checkAll").is(":checked") ? true : false;
  var fromDate =  $("#dateFrom").val();
  var endDate =  $("#dateTo").val();
  var report_type = $("#report_type").val();
  var fields=['feed_per_bird','feed_water_consumption', 'feed_egg_production', 'feed_egg_weight', 'feed_mortality', 'feed_temprature','feed_humidity'];
  var columns=[];
  fields.push(reportParam);
  columns.push({'data': 'entry_date'});
  columns.push({'data': 'bird_age_week'});

  $(".section_reports").hide();
  $("#section_"+reportParam).show();
  if(reportParam == 'daily_consolidated'){
    columns.push({'data': 'bird_age_day'});
    columns.push({'data': 'standard_feed_per_bird'});
    columns.push({'data': 'feed_per_bird'});
    columns.push({'data': 'standard_feed_water_consumption'});
    columns.push({'data': 'feed_water_consumption'});
    columns.push({'data': 'standard_feed_egg_production'});
    columns.push({'data': 'feed_egg_production'});
    columns.push({'data': 'standard_feed_egg_weight'});
    columns.push({'data': 'feed_egg_weight'});
    columns.push({'data': 'standard_feed_mortality'});
    columns.push({'data': 'feed_mortality'});
    columns.push({'data': 'standard_feed_temprature'});
    columns.push({'data': 'feed_temprature'});
    columns.push({'data': 'standard_feed_humidity'});
    columns.push({'data': 'feed_humidity'});

    $('#daily_consolidated_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@consolidatedDailyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });  

  } else if (reportParam == 'weekly_consolidated'){
    columns.push({'data': 'standard_feed_per_bird'});
    columns.push({'data': 'feed_per_bird'});
    columns.push({'data': 'standard_feed_water_consumption'});
    columns.push({'data': 'feed_water_consumption'});
    columns.push({'data': 'standard_feed_mortality'});
    columns.push({'data': 'feed_mortality'});
    columns.push({'data': 'standard_feed_egg_production'});
    columns.push({'data': 'feed_egg_production'});
    columns.push({'data': 'standard_feed_egg_weight'});
    columns.push({'data': 'feed_egg_weight'});
    columns.push({'data': 'standard_feed_egg_housed'});
    columns.push({'data': 'feed_egg_housed'});

    //--
    columns.push({'data': 'standard_body_weight'});
    columns.push({'data': 'body_weight'});
    columns.push({'data': 'standard_manure_removal'});
    columns.push({'data': 'manure_removal'});
    columns.push({'data': 'standard_light_intensity'});
    columns.push({'data': 'light_intensity'});
    columns.push({'data': 'standard_wind_velocity'});
    columns.push({'data': 'wind_velocity'});

    $('#weekly_consolidated_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@consolidatedWeeklyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });  
  }
}
function generateReportData(reportParam){
  var isAll = $(".checkAll").is(":checked") ? true : false;
  var fromDate =  $("#dateFrom").val();
  var endDate =  $("#dateTo").val();
  var report_type = $("#report_type").val();
  var fields=[];
  var columns=[];
  fields.push(reportParam);
  columns.push({'data': 'entry_date'});
  columns.push({'data': 'bird_age_week'});
  columns.push({'data': 'bird_age_day'});
  columns.push({'data': 'standard_'+reportParam});
  columns.push({'data': reportParam});
  $(".section_reports").hide();
  $("#section_"+reportParam).show();
  if(reportParam == 'feed_per_bird'){
    // daily record
    //
    $('#daily_feed_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@dailyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });  
    //commulative weekly Report
    $('#comulative_weekly_feed_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@commulativeWeeklyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });  
    //commulative flock Report
    $('#comulative_flock_feed_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@commulativeFlockReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });  
    //feed per egg
    //daily_feed_per_egg
  } else if (reportParam == 'feed_mortality'){

    <?php
      foreach($reasons as $reason){
        ?>
        columns.push({'data': '<?php echo "reason_".$reason->id ?>'});
        <?php
      }
    ?>
    $('#daily_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@dailyMortalityReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });
  } else if (reportParam == 'feed_temprature'){

    $('#daily_feed_feeling_temprature').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@dailyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });  

    columns.push({'data': 'feeling'});
    columns.push({'data': 'lowest_inner'});
    columns.push({'data': 'highest_inner'});
    columns.push({'data': 'highest_outter'});
    columns.push({'data': 'lowest_outter'});


    $('#daily_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@dailyTempratureReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });
  } else if(reportParam == 'feed_humidity'){
    //daily_feed_humidity_table
    columns.push({'data': 'outter_humidity'});
    $('#daily_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@dailyHumidityReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });  
  } else {
    $('#daily_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@dailyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });  
  }
  
}

function WeeklyReportings(reportParam){
  var isAll = $(".checkAll").is(":checked") ? true : false;
  var fromDate =  $("#dateFrom").val();
  var endDate =  $("#dateTo").val();
  var report_type = $("#report_type").val();
  var fields=[];
  var columns=[];
  fields.push(reportParam);
  columns.push({'data': 'entry_date'});
  columns.push({'data': 'bird_age_week'});
  columns.push({'data': 'standard_'+reportParam});
  columns.push({'data': reportParam});
  $(".section_reports").hide();
  $("#section_"+reportParam).show();

  if (reportParam == 'body_weight'){
    $('#weekly_body_weight_gain_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@getWeightGainPerDay')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });
    columns.push({'data': 'standard_uniformity'});
    columns.push({'data': 'uniformity'});
    console.log("there");
    $('#weekly_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@WeeklyBodyWeightReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });
  } else if (reportParam == 'wind_velocity'){
    $('#weekly_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@weeklyWindVelocityReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });  
  } else {
    $('#weekly_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@weeklyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });  
  }
}

function titersReporting(reportParam){
  var isAll = $(".checkAll").is(":checked") ? true : false;
  var fromDate =  $("#dateFrom").val();
  var endDate =  $("#dateTo").val();
  var report_type = $("#report_type").val();
  var fields=[];
  var columns=[];
  fields.push(reportParam);
  columns.push({'data': 'entry_date'});
  columns.push({'data': 'bird_age_week'});
  columns.push({'data': 'lab_name'});
  columns.push({'data': 'range'});
  columns.push({'data': 'average'});
  $(".section_reports").hide();
  $("#section_titers").show();
  
    $('#titer_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@titerReport')}}",
            "type": "POST",
            "data" : {
              options:reportParam,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}"
            }
        },
        "columns": columns
    });  
    //commulative weekly Report
}
</script>

@stop