@extends('layouts.default')

@section('title')
Dashboard
@stop

@section('page_title')
  Dashboard
@stop

@sub_page_title

@stop
@section('content')
 
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
 <style type="text/css">
 .clsDisplay-none{display: none;}
 
 </style>
 
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

    <div class="col-md-12 widgets panel_container">
      <div class="row panel_container_top">
        <div class="panel panel-default">
          <div class="panel-heading">
              Flock Activities
          </div>  
          <div class="panel-body">
              <div id="" class="">
                  <ul class="nav nav-tabs">
                    @if($flocks)
                     <?php $i=0; ?>
                    @foreach($flocks as $flock)
                      <li class="<?php echo $i==0? 'active':''; ?>"><a data-toggle="tab" href="#daily_activity_{{$flock->flock_id}}">{{$flock->display_id}}</a></li>
                    <?php $i++; ?>
                    @endforeach
                  @endif
                    </ul>
                    <div class="tab-content">
                @if($flocks)
                  <?php $i=0; ?>
                  @foreach($flocks as $flock)
                  <div class="row tab-pane fade <?php echo $i==0? 'in active':''; ?>" id="daily_activity_{{$flock->flock_id}}">
                    <div class="col-sm-12">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                           <strong>{{$flock->display_id}}</strong>
                        </div>  
                        <div class="panel-body">
                          
                          <div class="row flock_data">
                            <div class="col-sm-4 col-md-2">
                              <p><strong>Feed/Bird</strong></p>
                              <p><img src="{{asset('images/gray.png')}}" id="feed_per_bird_{{$flock->flock_id}}" alt="" width="50" /></p>
                            </div>
                            <div class="col-sm-4 col-md-2">
                              <p><strong>Water/Bird</strong></p>
                              <p><img src="{{asset('images/gray.png')}}" id="feed_water_consumption_{{$flock->flock_id}}" alt="" width="50" /></p>
                            </div>
                            <div class="col-sm-4 col-md-2">
                              <p><strong>Egg Production</strong></p>
                              <p><img src="{{asset('images/gray.png')}}" id="feed_egg_production_{{$flock->flock_id}}" alt="" width="50" /></p>
                            </div>
                            <div class="col-sm-4 col-md-2">
                              <p><strong>Egg Weight</strong></p>
                              <p><img src="{{asset('images/gray.png')}}" id="feed_egg_weight_{{$flock->flock_id}}" alt="" width="50" /></p>
                            </div>
                            <div class="col-sm-4 col-md-2">
                              <p><strong>Mortality</strong></p>
                              <p><img src="{{asset('images/gray.png')}}" id="feed_mortality_{{$flock->flock_id}}" alt="" width="50" /></p>
                            </div>
                            <div class="col-sm-4 col-md-2">
                              <p><strong>Temprature</strong></p>
                              <p><img src="{{asset('images/gray.png')}}" id="feed_temprature_{{$flock->flock_id}}" alt="" width="50" /></p>
                            </div>
                            <div class="col-sm-4 col-md-2">
                              <p><strong>Humidity</strong></p>
                              <p><img src="{{asset('images/gray.png')}}" id="feed_humidity_{{$flock->flock_id}}" alt="" width="50" /></p>
                            </div>
                            <div class="col-sm-4 col-md-2">
                              <p><strong>Body Weight</strong></p>
                              <p><img src="{{asset('images/gray.png')}}" id="body_weight_{{$flock->flock_id}}" alt="" width="50" /></p>
                            </div>
                            <div class="col-sm-4 col-md-2">
                              <p><strong>Uniformity</strong></p>
                              <p><img src="{{asset('images/gray.png')}}" id="uniformity_{{$flock->flock_id}}" alt="" width="50" /></p>
                            </div>
                            <div class="col-sm-4 col-md-2">
                              <p><strong>Manure Removal</strong></p>
                              <p><img src="{{asset('images/gray.png')}}" id="manure_removal_{{$flock->flock_id}}" alt="" width="50" /></p>
                            </div>
                            <div class="col-sm-4 col-md-2">
                              <p><strong>Light Intensity</strong></p>
                              <p><img src="{{asset('images/gray.png')}}" id="light_intensity_{{$flock->flock_id}}" alt="" width="50" /></p>
                            </div>
                            <div class="col-sm-4 col-md-2">
                              <p><strong>Wind Velocity</strong></p>
                              <p><img src="{{asset('images/gray.png')}}" id="wind_velocity_{{$flock->flock_id}}" alt="" width="50" /></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php $i++; ?>
                  @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
              Last Month Activities
              
          </div>

          <div class="panel-body table-responsive col-md-12">
            <div class="row">
                <div class="col-md-6 pull-right">
                <div class="form-group">
                  <label class="col-md-4 control-label"> Flocks</label>
                  <div class="col-md-8">
                      <select id="active_flocks" class="form-control">
                          <option value=""> -- Select --</option>
                        @if($flocks)
                          @foreach($flocks as $flock)
                            <option value="{{$flock->flock_id}}">{{$flock->display_id}} </option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                </div>
              </div>
            </div>
            <?php  ?>
            @if($flocks)
              @foreach($flocks as $flock)
              <?php extract($flock_ids[$flock->flock_id]) ?>
                <div id="parent_tabs_{{$flock->flock_id}}" class="parent-tabs clsDisplay-none">
                  <ul class="nav nav-tabs">
                      <li class="active"><a data-toggle="tab" href="#daily_flock_data_{{$flock->flock_id}}">Daily Flock Data</a></li>
                      <li><a data-toggle="tab" href="#weekly_flock_data_{{$flock->flock_id}}">Weekly Flock Data</a></li>
                      <li><a data-toggle="tab" href="#monthly_flock_data_{{$flock->flock_id}}">Monthly Flock Data</a></li>
                    </ul>
                    <div class="tab-content">
                      <div id="daily_flock_data_{{$flock->flock_id}}"  class="tab-pane fade in active table-responsive">
                          <div class="table-responsive" id="section_daily_consolidated">
                            <table class="table table-bordered table-stripped" id="daily_consolidated_table_{{$flock->flock_id}}">
                              
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
                              <tbody>
                                <?php //var_dump($dailyConsolidated);exit; ?>
                                @if($dailyConsolidated)
                                  @foreach($dailyConsolidated['data'] as $dailyRow)
                                    <tr>
                                      <td colspan="">{{$dailyRow['standard_feed_per_bird']}}</td>
                                      <td colspan="">{{$dailyRow['feed_per_bird']}}</td>
                                      <td colspan="">{{$dailyRow['standard_feed_water_consumption']}}</td>
                                      <td colspan="">{{$dailyRow['feed_water_consumption']}}</td>
                                      <td colspan="">{{$dailyRow['standard_feed_egg_production']}}</td>
                                      <td colspan="">{{$dailyRow['feed_egg_production']}}</td>
                                      <td colspan="">{{$dailyRow['standard_feed_egg_weight']}}</td>
                                      <td colspan="">{{$dailyRow['feed_egg_weight']}}</td>
                                      <td colspan="">{{$dailyRow['standard_feed_mortality']}}</td>
                                      <td colspan="">{{$dailyRow['feed_mortality']}}</td>
                                      <td colspan="">{{$dailyRow['standard_feed_temprature']}}</td>
                                      <td colspan="">{{$dailyRow['feed_temprature']}}</td>
                                      <td colspan="">{{$dailyRow['standard_feed_humidity']}}</td>
                                      <td colspan="">{{$dailyRow['feed_humidity']}}</td>
                                    </tr>
                                  @endForeach
                                @endif
                              </tbody>
                            </table>
                            
                        </div>
                      </div>
                      <div id="weekly_flock_data_{{$flock->flock_id}}"  class="tab-pane fade active table-responsive">
                          <div class="table-responsive" id="section_weekly_consolidated">
                            <table class="table table-bordered table-stripped" id="weekly_consolidated_table_{{$flock->flock_id}}">
                              
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
                                  <tbody>
                                    <?php //var_dump($dailyConsolidated);exit; ?>
                                    @if($weeklyConsolidated)
                                      @foreach($weeklyConsolidated['data'] as $weeklyRow)
                                        <tr>
                                          <td colspan="">{{$weeklyRow['standard_feed_per_bird']}}</td>
                                          <td colspan="">{{$weeklyRow['feed_per_bird']}}</td>
                                          <td colspan="">{{$weeklyRow['standard_feed_water_consumption']}}</td>
                                          <td colspan="">{{$weeklyRow['feed_water_consumption']}}</td>
                                           <td colspan="">{{$weeklyRow['standard_feed_mortality']}}</td>
                                          <td colspan="">{{$weeklyRow['feed_mortality']}}</td>


                                          <td colspan="">{{$weeklyRow['standard_feed_egg_production']}}</td>
                                          <td colspan="">{{$weeklyRow['feed_egg_production']}}</td>
                                          <td colspan="">{{$weeklyRow['standard_feed_egg_weight']}}</td>
                                          <td colspan="">{{$weeklyRow['feed_egg_weight']}}</td>
                                          <td colspan="">{{$weeklyRow['standard_feed_egg_housed']}}</td>
                                          <td colspan="">{{$weeklyRow['feed_egg_housed']}}</td>
                                         
                                          <td colspan="">{{$weeklyRow['standard_body_weight']}}</td>
                                          <td colspan="">{{$weeklyRow['body_weight']}}</td>
                                          <td colspan="">{{$weeklyRow['standard_manure_removal']}}</td>
                                          <td colspan="">{{$weeklyRow['manure_removal']}}</td>
                                          <td colspan="">{{$weeklyRow['standard_light_intensity']}}</td>
                                          <td colspan="">{{$weeklyRow['light_intensity']}}</td>
                                          <td colspan="">{{$weeklyRow['standard_wind_velocity']}}</td>
                                          <td colspan="">{{$weeklyRow['wind_velocity']}}</td>
                                        </tr>
                                      @endForeach
                                    @endif
                                  </tbody>
                            </table>
                            
                        </div>
                      </div>
                      <div id="monthly_flock_data_{{$flock->flock_id}}"  class="tab-pane fade active table-responsive">
                          <table class="table table-bordered table-striped table-hover" id="titer_list_{{$flock->flock_id}}">
                              <thead>
                                  <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Lab</th>
                                    <th>Titer</th>
                                    <th>Range</th>
                                    <th>Avg.</th>
                                  
                                </tr>
                              </thead>
                               <tbody>
                                  <?php //var_dump($flock_ids[$flock->flock_id]) ?>
                                @if($titers)
                                
                                  @foreach($titers as $titer)
                                  
                                      <tr class="titer_id_{{$titer->titer_id}}">
                                        <td>{{$titer->titer_id}}</td>
                                        <td>{{$titer->date}}</td>
                                        <td>{{$titer->lab_name}}</td>
                                        <td>{{$titer->disease_name}}</td>
                                        <td>{{$titer->range}}</td>
                                        <td>{{number_format($titer->average,'2','.','')}}</td>
                                      </tr>
                                      
                                  @endforeach
                               
                                @endif
                            </tbody>
                          </table>
                      </div>
                    </div>
                </div>
              @endforeach
            @endif
          </div>
    
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
var adjustment;
var field = 0;
function updateFlocksData(){
    //alert(field);
    $.ajax({
          type: "POST",
          url: "{{ action('DashboardController@checkTodayRecord') }}",
          data: {'field':field,'_token': "{{ csrf_token() }}"},
        })
        .done(function( msg ) {
            field++;
            if(field == 7 ){
              field=0;
            }
            var errors = jQuery.parseJSON(msg);
           
             $.each(errors, function(index, element) {
                  var ele = $("#"+element.field_name+"_"+element.flock_id);
                  if(element.standard_value+element.upper_limit >= element.field_value && element.standard_value-element.lower_limit <= element.field_value ){
                    ele.attr('src','{{asset("images/green.png")}}');
                  } else{
                    ele.attr('src','{{asset("images/red.png")}}');
                  }
              });
               
            
            
        });
  }
  setInterval(updateFlocksData, 6000)
$(function(){


  $("ul.nav-tabs a").click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});

  @if($flocks)
    @foreach($flocks as $flock)
      // $('#daily_consolidated_table_{{$flock->flock_id}}, #weekly_consolidated_table_{{$flock->flock_id}}').DataTable({
      //     responsive: false
      // });
      $('#titer_list_{{$flock->flock_id}}').DataTable({
            responsive: false
        });
    @endforeach
  @endif

  $("#active_flocks").change(function(){
    $(document).find(".parent-tabs").addClass("clsDisplay-none");
    //alert($(this).val());
    if($(this).val() != ''){
      $("#parent_tabs_"+$(this).val()).removeClass('clsDisplay-none');
    }
  });
    
 });   
</script>
@stop