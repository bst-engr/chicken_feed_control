@extends('layouts.default')

@section('title')
 Vaccine Administration
@stop

@section('page_title')
  Vaccine Administration
@stop

@sub_page_title

@stop

@section('content')
<style type="text/css">
.titer-class{
    width: 225px;
  }
.titer-class div { border-right: 1px solid #ddd; word-wrap: break-word;}
.titer-class div:last-child { border-right: none; }
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
      	
		    <div class="table-responsive">
		        <table class="table table-striped table-bordered table-hover" id="history_list">
		            <thead>
                    <tr>
                      <th colspan="4"></th>
                      <?php $flockCount=$flockCount1=0; ?>
                      @if($existingFlocks)
                        @foreach($existingFlocks as $row)
                          <th>{{$row->display_id}}</th>
                          <?php $flockCount++; ?>
                        @endforeach
                      @endif
                      <?php $flockCount1 = $flockCount; ?>
                    </tr>
		                <tr>
		                	<th>Vaccine Age</th>
                      <th>vaccine Name</th>
                      <th>Route</th>
                      <th>Source</th>
                      @if($existingFlocks)
                      <?php while($flockCount>0){ ?>
                      <th>
                          <div class="clear-fix titer-class" style="width:225px;">
                              <div class="col-sm-4">Start Date</div>
                              <div class="col-sm-4">Finish Date</div>
                              <div class="col-sm-4">Age In Days</div>
                          </div>
                      </th>
                     <?php $flockCount--; } ?>
                     @endif
		            	</tr>
		            </thead>
		             <tbody>
		             	  
        @if($vaccines)
        
          @foreach($vaccines as $vaccine)
          
           		<tr class="vaccine_id_{{$vaccine->vaccine_id}}">
           			<td>{{$vaccine->vaccine_age}}</td>
                <td>{{$vaccine->vaccine_name}}</a></td>
                <td>{{$vaccine->route}}</td>
           			<td>{{$vaccine->source}}</td>
               @if($existingFlocks)
                  @foreach($existingFlocks as $row)
                    <?php $currRow = isset($flocks[$row->display_id][$vaccine->vaccine_id]) ? $flocks[$row->display_id][$vaccine->vaccine_id] : array('start_date'=>'','finish_date'=>'','age_in_days'=>''); ?>
                <td>
                  <div class="clear-fix titer-class">
                    <div class="col-sm-4">{{$currRow['start_date']}}</div>
                    <div class="col-sm-4">{{$currRow['finish_date']}}</div>
                    <div class="col-sm-4">{{$currRow['age_in_days']}}</div>
                  </div>
                </td>
           			  @endforeach
                @endif
           		</tr>
           		
          @endforeach
        @else
          <tr><td colspan="5"><h3>No data Found!!!</h3></td></tr>
        @endif
        			</tbody>
		        </table>
		    </div>
		
      </div>
    </div>
   
</div>
<!-- Form To add New Resources -->
<script type="text/javascript">
$(function(){
  $('#history_list').DataTable({
          responsive: true
  });
});
</script>

@stop