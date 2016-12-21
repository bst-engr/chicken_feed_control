@extends('layouts.default')

@section('title')
 System Reports - Daily Humidity Report
@stop

@section('page_title')
  Daily Humidity Report
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
                  <label>Select Flock</label>
            </div>
            <div class="col-sm-10">
              <div class="form-group clearfix">
                  
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
           <div class="row">
              <div class="col-sm-4 col-md-2">
                <label class="control-label">Record</label>
              </div>
              <div class="col-sm-8 col-md-10">
                <div class="form-group clearfix">
                    <div class="form-group clearfix">
                      <select id="record_type" name="record_type" class="form-control">
                        <option value="">--All--</option>
                        <!--<option value="days">Days</option>-->
                        <option value="weeks">Weeks</option>
                        <!-- <option value="months">Months</option> -->
                        <option value="date_range">Range of Date</option>
                      </select>
                    </div>
                 
                </div>
              </div>
          </div>
         <!--  <div class="row">
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
          </div> -->
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
                <div id="compare_days" class="filters hideIt">
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group clearfix">
                      <label class="col-sm-6 control-label">Compare From Day:</label>
                      <div class="col-sm-6">
                        <div class="form-group clearfix">
                          <select id="compare_day_from" class="form-control">
                            <?php 
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
                            <?php echo $strHtml; ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
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
          <div class="row flockwise_reports">
             
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
          
          
      </div>
    </div>
   
</div>
<!-- Form To add New Resources -->
<script type="text/javascript">
$(function(){
  
  $("#generate_report").click(function(){
    //checks for report format either flock wise or comparitive.
      
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
      generateReportData('feed_humidity');
      
  });

  $('.datepicker').datepicker({'format':'yyyy-mm-dd','viewMode':'2',autoclose: true, startDate: '-1d'}).on('changeDate', function(e){
        $(this).datepicker('hide');
    });
  $('#history_list').DataTable({
          responsive: true
  });
  
});
</script>
@include("reports/reportingFunctions")

@stop