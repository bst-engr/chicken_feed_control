@extends('layouts.default')

@section('title')
Flocks
@stop

@section('page_title')
  Manage Flocks 
  @if(Sentry::getUser()->hasAccess('manage_flocks'))
    <button type="button" class="btn btn-primary modal_button pull-right flock_modal_button" data-toggle="modal" data-target=".bs-example-modal">Add New Flock</button>
    <button type="button" class="btn btn-primary modal_button pull-right standard_model_button" data-toggle="modal" data-target=".bs-standard-modal">standards</button>
  @endif
@stop

@sub_page_title

@stop
@section('content')
<script src="{{ asset('js/jquery-ui.min.js') }}"></script> 
 <style type="text/css">.form-horizontal .control-label {text-align: left;}</style>
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
      	
		    <div class="table-responsive">
		        <table class="table table-bordered table-striped table-hover" id="flock_list">
		            <thead>
		                <tr>
		                	<th>Sr#</th>
		                	<th>Flock</th>
		                	<th>Section Head</th>
		                	<th>Arrival Date</th>
                      <th>Batch Size</th>
                      <th>Status</th>
                      <th>Action</th>
		            	</tr>
		            </thead>
		             <tbody>
		             	  
        @if($flocks)
        
          @foreach($flocks as $flock)
          
           		<tr class="flock_id_{{$flock->flock_id}}">
           			<td>{{$flock->flock_id}}</td>
           			<td>{{$flock->display_id}}</td>
           			<td>{{$flock->first_name.' '.$flock->last_name}}</td>
           			<td>{{$flock->arrival_date}}</td>
                <td>{{$flock->batch_size}}</td>
                <td>{{$flock->status==1 ? 'Running' : 'Closed'}}</td>
                <td>
                  @if(Sentry::getUser()->hasAccess('manage_flocks'))
                  <button class="btn btn-default" onclick="editFlock('{{$flock->flock_id}}')">Edit</button>
                  <button class="btn btn-default" onclick="closeFlock('{{$flock->flock_id}}')">Close</button>
                  <!-- <button class="btn btn-default" onclick="deleteFlock('{{$flock->flock_id}}')">Delete</button> -->
                  @endif
                  @if(Sentry::getUser()->hasAccess('add_daily_feed'))
                    <a class="btn btn-default" href="{{action('FlocksController@dailyFeed',array($flock->flock_id))}}">Daily Record Entry</a>
                  @endif                    
                  @if(Sentry::getUser()->hasAccess('weekly_data'))
                    <a class="btn btn-default" href="{{action('FlocksController@weeklyFeed',array($flock->flock_id))}}">WeeKly Record Entry</a>
                  @endif
                  @if(Sentry::getUser()->hasAccess('monthly_data'))
                   <a class="btn btn-default" href="{{action('TiterController@titers',array($flock->flock_id))}}">Monthly Record Entry</a>
                   @endif
                  @if(Sentry::getUser()->hasAccess('flock_vaccination'))
                   <a class="btn btn-default" href="{{action('VaccinesController@vaccinationHistory',array($flock->flock_id))}}">Vaccination</a>
                   @endif
                    @if(Sentry::getUser()->hasAccess('add_periodical_reports'))
                   <a class="btn btn-default" href="{{action('PeriodicalreportController@index',array($flock->flock_id))}}">Periodical Reports</a>
                   @endif
                </td>
           		</tr>
           		
          @endforeach
        @endif
        			</tbody>
		        </table>
		    </div>
		
      </div>
    </div>
   
</div>
<!-- Form To add New Resources -->


<div class="modal fade bs-standard-modal" id="standardModel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <!-- <button type="submit" class="btn btn-primary pull-right" id="submit_modal">Save changes</button> -->

        <h4 class="modal-title">Flock Standards</h4>
      </div>
      <form method="POST" action="#" accept-charset="UTF-8" id="standard_form">
          <div class="modal-body"> 
                <div class="table-responsive">
                  <table class="table table-striped table-hover" id="standard_list">
                    <thead>
                      <tr>
                        <th>Week</th>
                        <th>Feed Consumption(Grm.)</th>
                        <th>Water Consumption</th>
                        <th>Mortality</th>
                        <th>Temprature</th>
                        <th>Humidity</th>
                        <th>Egg Weight</th>
                        <th>Egg Production</th>
                        <th>Body Weight</th>
                        <th>Uniformity(%age)</th>
                        <th>Manure Removal</th>
                        <th>Light Intensity</th>
                        <th>Wind Velocity</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($standards as $standard)
                      <tr>
                          <td><div class="form-group"><input type="text" name="week[]" value="{{$standard->week}}" /></div></td>
                          <td><div class="form-group"><input type="text" name="feed[]" value="{{$standard->feed}}" /></div></td>
                          <td><div class="form-group"><input type="text" name="water_consumption[]" value="{{$standard->water_consumption}}" /></div></td>
                          <td><div class="form-group"><input type="text" name="mortality[]" value="{{$standard->mortality}}" /></div></td>
                          <td><div class="form-group"><input type="text" name="temprature[]" value="{{$standard->temprature}}" /></div></td>
                          <td><div class="form-group"><input type="text" name="humidity[]" value="{{$standard->humidity}}" /></div></td>
                          <td><div class="form-group"><input type="text" name="egg_weight[]" value="{{$standard->egg_weight}}" /></div></td>
                          <td><div class="form-group"><input type="text" name="egg_production[]" value="{{$standard->egg_production}}" /></div></td>
                          <td><div class="form-group"><input type="text" name="body_weight[]" value="{{$standard->body_weight}}" /></div></td>
                          <td><div class="form-group"><input type="text" name="uniformity[]" value="{{$standard->uniformity}}" /></div></td>
                          <td><div class="form-group"><input type="text" name="manure_removal[]" value="{{$standard->manure_removal}}" /></div></td>
                          <td><div class="form-group"><input type="text" name="light_intensity[]" value="{{$standard->light_intensity}}" /></div></td>
                          <td><div class="form-group"><input type="text" name="wind_velocity[]" value="{{$standard->wind_velocity}}" /></div></td>
                      </div>
                      @endforeach
                    </tbody>
                  </table>
                </div>

          </div>
          <div class="modal-footer">
            <input name="_token" value="{{ csrf_token() }}" type="hidden"/>
            <input name="standard_flock_id" id="standard_flock_id" value="" type="hidden" />
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="submit_modal">Save changes</button>
          </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade bs-example-modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Create New Flock</h4>
      </div>
      <form method="POST" action="#" class="form-horizontal" accept-charset="UTF-8" id="project_form">
          <div class="modal-body">       
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Flock Id</label>
                    <div class="col-sm-9">
                    <input type="text" name="display_id" id="display_id" class="form-control" placeholder="Flock ID" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Breed Name</label>
                    <div class="col-sm-9">
                    <input type="text" name="breed_name" id="breed_name" class="form-control" placeholder="Breed Name" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Section Head</label>
                    <div class="col-sm-9">
                      <!-- <input type="text" name="doctor_id" id="doctor_id" class="form-control" placeholder="Section Head" /> -->
                      <select name="doctor_id" id="doctor_id" class="form-control" placeholder="Section Head">
                        @foreach($users as $user)
                          <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                        @endforeach
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Flock Batch Details</label><span class="glyphicon glyphicon-plus pull-right add_new_batch"></span>
                </div>
                <div class="form-group batch_detail_row">
                  <div class="col-sm-6">
                  <label for="inputEmail3" class="col-sm-5 control-label">Batch Size</label>
                    <div class="col-sm-7">
                      <input type="text" name="batch1_size[]" id="batch1_size" class="form-control batchd_size" placeholder="First Batch Size" />
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <label for="inputEmail3" class="col-sm-5 control-label">Batch Arrival</label>
                    <div class="col-sm-7">
                      <input type="text" name="batch_arrival[]" id="batch1_arrival" class="form-control datepicker batchd_date" placeholder="Batch Arrival Date" />
                    </div>
                  </div>
                </div>
                
                
               

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Flock Size (No. of Birds)</label>
                    <div class="col-sm-9">
                      <input type="text" name="batch_size" id="batch_size" class="form-control" placeholder="Flock Size (No. of Birds)" />                    
                    </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Arrival Date</label>
                    <div class="col-sm-9">
                      <input type="text" name="arrival_date" readonly="readonly" id="arrival_date" class="form-control datepicker" placeholder="Arrival Date" />                    
                    </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Shed#</label>
                    <div class="col-sm-9">
                      <input type="text" name="shed_no" id="shed_no" class="form-control " placeholder="Shed#" />                    
                    </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Comments</label>
                    <div class="col-sm-9">
                      <input type="text" name="comments" id="comments" class="form-control " placeholder="Comments" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Tolerance Ranges</label>
                </div>

                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Daily Feed Consumption (upper limit) - Grm.</label>
                      <div class="col-sm-12">
                        <input type="text" placeholder="Daily Feed Consumption (upper limit)" class="form-control" id="feed_per_bird_upper" name="feed_per_bird[upper]">                    
                      </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Daily Feed Consumption (Lower limit) - Grm.</label>
                      <div class="col-sm-12">
                        <input type="text" placeholder="Daily Feed Consumption (Lower limit)" class="form-control" id="feed_per_bird_lower" name="feed_per_bird[lower]">                    
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Daily Water Consumption (upper limit) - ml.</label>
                    <div class="col-sm-12">
                        <input type="text" placeholder="Daily Water Consumption (upper limit)" class="form-control" id="feed_water_consumption_upper" name="feed_water_consumption[upper]">                    
                      </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Daily Water Consumption (Lower limit) - ml</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Daily Water Consumption (Lower limit)" class="form-control" id="feed_water_consumption_lower" name="feed_water_consumption[lower]">                    
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Mortality (upper limit)</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Mortality (upper limit)" class="form-control" id="feed_mortality_upper" name="feed_mortality[upper]">                    
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Mortality (Lower limit)</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Mortality (Lower limit)" class="form-control" id="feed_mortality_lower" name="feed_mortality[lower]">                    
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Temprature (upper limit) - c</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Temprature (upper limit)" class="form-control" id="feed_temprature_upper" name="feed_temprature[upper]">                    
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Temprature (Lower limit) - c</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Temprature (Lower limit)" class="form-control" id="feed_temprature_lower" name="feed_temprature[lower]">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Humidity (upper limit) - %</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Humidity (upper limit)" class="form-control" id="feed_humidity_upper" name="feed_humidity[upper]">
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Humidity (Lower limit) - %</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Humidity (Lower limit)" class="form-control" id="feed_humidity_lower" name="feed_humidity[lower]">                    
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Egg Weight (upper limit) - g</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Egg Weight (upper limit)" class="form-control" id="feed_egg_weight_upper" name="feed_egg_weight[upper]">                    
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Egg weight (Lower limit) - g</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Egg weight (Lower limit)" class="form-control" id="feed_egg_weight_lower" name="feed_egg_weight[lower]">                    
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Egg Production (upper limit)</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Egg Production (upper limit)" class="form-control" id="feed_egg_production_upper" name="feed_egg_production[upper]">                    
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Egg Production (Lower limit)</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Egg Production (Lower limit)" class="form-control" id="feed_egg_production_lower" name="feed_egg_production[lower]">                    
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Bird Body Weight (upper limit) - g</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Bird Body Weight (upper limit)" class="form-control" id="body_weight_upper" name="body_weight[upper]">                    
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Bird Body Weight (Lower limit) - g</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Bird Body Weight (Lower limit)" class="form-control" id="body_weight_lower" name="body_weight[lower]">                    
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Uniformity (upper limit) - %</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Uniformity (upper limit)" class="form-control" id="uniformity_upper" name="uniformity[upper]">                    
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Uniformitiy (Lower limit) - %</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Uniformitiy (Lower limit)" class="form-control" id="uniformity_lower" name="uniformity[lower]">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Manure Removal (upper limit) - Kg</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Manure Removal (upper limit)" class="form-control" id="manure_removal_upper" name="manure_removal[upper]">
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Manure Removal (Lower limit) - Kg</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Manure Removal (Lower limit)" class="form-control" id="manure_removal_lower" name="manure_removal[lower]">                    
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Light Intensity (upper limit) - Lux</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Light Intensity (upper limit)" class="form-control" id="light_intensity_upper" name="light_intensity[upper]">
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Light Intensity (Lower limit) - Lux</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Egg Production (Lower limit)" class="form-control" id="light_intensity_lower" name="light_intensity[lower]">                    
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Wind Velocity (upper limit) - CFM</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Wind Velocity (upper limit)" class="form-control" id="wind_velocity_upper" name="wind_velocity[upper]">                    
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="inputEmail3" class="col-sm-12 control-label">Wind Velocity (Lower limit) - CFM</label>
                    <div class="col-sm-12">
                      <input type="text" placeholder="Wind Velocity (Lower limit)" class="form-control" id="wind_velocity_lower" name="wind_velocity[lower]">                    
                    </div>
                  </div>
                </div>

               <!--  <div class="form-group">
                  <h3>Invite people to your team</h3>
                  <p>Anyone on your team will see everything posted to this project. Every message, to-do list, file, event, and text document.</p>
                </div>
                <div class="form-group">
                  <span class="input-group-addon glyphicon glyphicon-user"></span>
                  <input id="user_name" class="form-control usr ui-autocomplete-input" type="text" required="true" value="" name="users_name[]" autocomplete="off">
                  <span class="input-group-addon">
                  <a class="glyphicon glyphicon-plus" onclick="addMoreRows(this.form);" href="javascript:void(0);"></a>
                  </span>
                </div> -->
  
          </div>
          <div class="modal-footer">
            <input name="_token" value="{{ csrf_token() }}" type="hidden"/>
            <input name="flock_id" id="flock_id" value="" type="hidden" />
            <input name="email" id="email" value="" type="hidden" />
            <input name="user_id" id="user_id" value="" type="hidden" />
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
$('#flock_list').DataTable({
        responsive: true
});
  $("body").on('focus','.datepicker',function(){
    $(this).datepicker({'format':'yyyy-mm-dd','viewMode':'2',autoclose: true, startDate: '-1d'}).on('changeDate', function(e){
        $(this).datepicker('hide');
    });
  });
  // $('.datepicker').datepicker({'format':'yyyy-mm-dd','viewMode':'2',autoclose: true, startDate: '-1d'}).on('changeDate', function(e){
  //       $(this).datepicker('hide');
  //   });
  $("#doctor_id").change(function(){
    $("#user_id").val($(this).val());
  })

/* calculate batch flock size.*/
  $("body").on('click','.remove_this_batch',function(){
    $(this).closest('.form-group').remove();
  });

  $(".modal-body").on("keyup",'.batchd_size', function(){
    var total=0;
    $(document).find(".batchd_size").each(function(){
      total = total + Number($(this).val());
    });
    $("#batch_size").val(total);
  });
  $(".modal-body").on("blur",'.batchd_size', function(){
    var total=0;
    $(document).find(".batchd_size").each(function(){
      total = total + Number($(this).val());
    });
    $("#batch_size").val(total);
  });
/*End flock size calculation.*/
  $(".add_new_batch").click(function(){
    
    var strHtml='<div class="form-group">';
        strHtml+=' <div class="col-sm-6">';
        strHtml+='<label for="inputEmail3" class="col-sm-5 control-label">Batch Size</label>';
        strHtml+=' <div class="col-sm-7">';
        strHtml+='   <input type="text" name="batch1_size[]" id="batch1_size" class="form-control batchd_size" placeholder="First Batch Size" />';
        strHtml+=' </div>';
        strHtml+='</div>';
        strHtml+='<div class="col-sm-6">';
        strHtml+='<label for="inputEmail3" class="col-sm-5 control-label">Batch Arrival</label>';
        strHtml+=' <div class="col-sm-7">';
        strHtml+=' <input type="text" name="batch_arrival[]" id="batch1_arrival" class="form-control datepicker batchd_date" placeholder="Batch Arrival Date" /><span class="glyphicon glyphicon-minus pull-right remove_this_batch"></span>';
        strHtml+=' </div>';
        strHtml+='</div>';
        strHtml+='</div>';
    $(".batch_detail_row").after(strHtml);
  });
  //function used to autocomplete the user ksill field
    var url = "{{action('FlocksController@doctors') }}";

    $( "#doctor_id" ).autocomplete({
        source: url,
        minLength: 1,
        select: function( event, ui ) {
          if( ui.item) {
              $(this).val(ui.item.label);
              $("#user_id").val(ui.item.id);
              $("#email").val(ui.item.email);
              return false;
          }
        }
      });

     // funciton handles new boards when dialog box submit a new request to create new board. 
     $('#myModal form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
          type: "POST",
          url: "{{ action('FlocksController@store') }}",
          data: $("#project_form").serialize(),
          beforeSend: function() {
            
            $(".modal-footer").append('<span class="loading">Processing...</span>');
            $("#project_form").find("input[type=text], textarea, input[type=submit]").attr("disable", 'disable');
          }
        })
        .done(function( msg ) {
            //check if response from server is success or not . because json object will be returned if there are validation errors.
            var url = getvalidUrl('FlocksController@view', msg);
            var url1 = getvalidUrl('VaccinesController@vaccinationHistory', msg);
           
            $("#project_form").find("input[type=text], textarea, input[type=submit]").removeAttr("disable");
            $(".modal-footer").find('span.loading').remove();
            var response=jQuery.parseJSON(msg);
            var alertMsg="";
            if(typeof response =='object'){
                
                var errors = jQuery.parseJSON(msg);
                for (var key in errors) {
                   // alert(key+ ">>>"+ errors[key][0]);
                    $("#"+key).after("<label class='error'>"+errors[key][0]+"</label>");
                }
            } else{
                
                var projectTitle = $( "#display_id" ).val();
                var specialistName = '';//$("#specialist_name").val();
                var strHtml = '<tr class="flock_id_'+msg+'"><td>'+msg+'</td>';
                      strHtml += '<td><a href="'+url+'">'+$("#display_id").val()+'</a></td>';
                      strHtml += '<td>'+$("#doctor_id").val()+'</td>';
                      strHtml += '<td>'+$("#arrival_date").val()+'</td>';
                      strHtml += '<td>'+$("#batch_size").val()+'</td>';
                      strHtml += '<td>';
                  <?php if(Sentry::getUser()->hasAccess('manage_flocks')) { ?>
                      strHtml += '<button class="btn btn-default" onclick="editFlock(\''+msg+'\')">Edit</button><button class="btn btn-default" onclick="deleteFlock(\''+msg+'\')">Delete</button>';
                  <?php } ?>
                <?php if(Sentry::getUser()->hasAccess(' add_daily_feed')) { ?>
                    strHtml += '<button class="btn btn-default" onclick="window.location=\'\'">Daily Feed</button>';
                <?php } ?>
                 @if(Sentry::getUser()->hasAccess('add_vaccination_detail'))
                    strHtml += '<button class="btn btn-default" onclick="window.location=\''+url1+'\'">Vaccination</button>';
                   @endif
                      
                      strHtml +='</td></tr>';
                if($("#flock_id").val() == '') {
                  $("#flock_list tbody").find('tr:last-child').after(strHtml);
                  alertMsg = "New Flock Has been Created";
                } else{
                  alertMsg = "Flock Content has been updated";
                  $("#flock_list tbody").find(".flock_id_"+$("#flock_id").val()).replaceWith(strHtml);
                  //$("#team_form_"+msg+" .panel-heading a").text($("#project_title").val())
                }

               $("#myModal").hide();
               $("#project_form").find("input[type=text], textarea").val("");
               $("#user_id").val("");

               //$(".ajax_box").removeClass('alert-danger').text("Success: New Project Has been Created").addClass('alert-success').show('slow').hide('slow');
              new PNotify({
                title: 'Success',
                text: alertMsg,
                type: 'success',
                addclass: "stack-topleft"
              });
              
              //if($("#flock_id").val() == '') {
                $("#standard_flock_id").val(msg);
                $(".standard_model_button").trigger('click');
              //} else {
               // location.reload();
              //}
              
            }
            
        });


    });

//
// funciton handles new boards when dialog box submit a new request to create new board. 
     $('#standardModel form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
          type: "POST",
          url: "{{ action('FlocksController@storeStandards') }}",
          data: $("#standard_form").serialize(),
          beforeSend: function() {
            
            $(".modal-footer").append('<span class="loading">Processing...</span>');
            $("#standard_form").find("input[type=text], textarea, input[type=submit]").attr("disable", 'disable');
          }
        })
        .done(function( msg ) {
          
           
            $("#standard_form").find("input[type=text], textarea, input[type=submit]").removeAttr("disable");
            $(".modal-footer").find('span.loading').remove();
            var response=jQuery.parseJSON(msg);
            var alertMsg="";
            if(typeof response =='object'){
                
                var errors = jQuery.parseJSON(msg);
                for (var key in errors) {
                   // alert(key+ ">>>"+ errors[key][0]);
                    $("#"+key).after("<label class='error'>"+errors[key][0]+"</label>");
                }
            } else{
                
               var alertMsg = "Standards Has Been Saved.";
               $("#standardModel button.close").trigger('click');
               $("#standard_form").find("input[type=text], textarea").val("");
               $("#standard_flock_id").val("");

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

function appendBatchDetails(arrivalDate, batchSize){
  var strHtml='<div class="form-group">';
        strHtml+=' <div class="col-sm-6">';
        strHtml+='<label for="inputEmail3" class="col-sm-5 control-label">Batch Size</label>';
        strHtml+=' <div class="col-sm-7">';
        strHtml+='   <input type="text" value="'+batchSize+'" name="batch1_size[]" id="batch1_size" class="form-control batchd_size" placeholder="First Batch Size" />';
        strHtml+=' </div>';
        strHtml+='</div>';
        strHtml+='<div class="col-sm-6">';
        strHtml+='<label for="inputEmail3" class="col-sm-5 control-label">Batch Arrival</label>';
        strHtml+=' <div class="col-sm-7">';
        strHtml+=' <input type="text" value="'+arrivalDate+'"name="batch_arrival[]" id="batch1_arrival" class="form-control datepicker batchd_date" placeholder="Batch Arrival Date" /><span class="glyphicon glyphicon-minus pull-right remove_this_batch"></span>';
        strHtml+=' </div>';
        strHtml+='</div>';
        strHtml+='</div>';
    $(".batch_detail_row").after(strHtml);
}
//function used to remove project from database.
function deleteFlock(flockId){
  if(confirm("Are you Sure to delete This Flock?")) {
    var url = getvalidUrl('FlocksController@destroy', flockId);
    $.ajax({
      type: "post",
      url: url,
      data:{'_token': "{{ csrf_token() }}"}
      
    })
    .done(function( msg ) {
        //check if response from server is success or not . because json object will be returned if there are validation errors.

      $("#flock_list tbody").find("tr.flock_id_"+flockId).remove();
        
     
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
function editFlock(flockID){
  var url = getvalidUrl('FlocksController@edit', flockID);
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
                      if(key != 'tolerance_range' && key != 'batch_details') {
                        $("#"+key).val(value);
                        
                        if (key == 'user_id'){
                          console.log($("#doctor_id").children('option[value="'+value+'"]').prop('selected',true));
                          $("#doctor_id").find('option[value="'+value+'"]').prop('selected',true);//.val(value);
                        }

                        if(key != 'doctor_id' && key != 'shed_no' && key != 'comments'){
                          $("#"+key).attr('readonly',true);
                          //$("#"+key).children('option[value="'+value+'"]').prop('selected',true);
                        }
                      } else {
                        if(key == 'batch_details') {
                          var tRange=jQuery.parseJSON(value);
                          if(typeof tRange =='object'){
                            $.each(tRange, function(key2, value2) {
                              //console.log("#"+value1.key+"upper");
                              //$("#"+value1.key+"_upper").val(value1.upper_limit);
                              //$("#"+value1.key+"_lower").val(value1.lower_limit);
                              appendBatchDetails(value2.arrival_date, value2.batch_size);

                            });
                          }
                        } else {
                          var tRange=jQuery.parseJSON(value);
                          if(typeof tRange =='object'){
                            $.each(tRange, function(key1, value1) {
                              //console.log("#"+value1.key+"upper");
                              $("#"+value1.key+"_upper").val(value1.upper_limit);
                              $("#"+value1.key+"_lower").val(value1.lower_limit);

                            });
                          }
                        }
                      }
                    });
                }
                //$("#doctor_id").attr('disabled', true);
                $(".flock_modal_button").trigger('click');
            } 
            
        });
}

function closeFlock(flockId){
  if(confirm("Are you Sure to close This Flock?")) {
    var url = getvalidUrl('FlocksController@closeFlock', flockId);
    $.ajax({
      type: "post",
      url: url,
      data:{'_token': "{{ csrf_token() }}"}
      
    })
    .done(function( msg ) {
        //check if response from server is success or not . because json object will be returned if there are validation errors.

      $("#flock_list tbody").find("tr.flock_id_"+flockId+" td:nth-child(6)").text('Closed');
        
     
      //$(".panel_container_top").isotope();
      if(msg == 1 ) {
        new PNotify({
          title: 'Success',
          text: 'Flock has been Closed.',
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
</script>

@stop