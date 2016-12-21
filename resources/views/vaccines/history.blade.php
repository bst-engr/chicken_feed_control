@extends('layouts.default')

@section('title')
 {{$flock->display_id}} vaccination history.
@stop

@section('page_title')
  {{$flock->display_id}}
  @if(Sentry::getUser()->hasAccess('flock_vaccination'))
    <button type="button" class="btn btn-primary modal_button pull-right" data-toggle="modal" data-target=".bs-example-modal">Add Vaccination</button>
  @endif
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
      	
		    <div class="table-responsive">
		        <table class="table table-striped table-hover" id="history_list">
		            <thead>
		                <tr>
		                	<th>Id</th>
		                	<th>vaccine Name</th>
                      <th>Vaccine Age</th>
                      <th>Route</th>
                      <th>Source</th>
                      <th>Action</th>
		            	</tr>
		            </thead>
		             <tbody>
		             	  
        @if($vaccination_history)
        
          @foreach($vaccination_history as $history)
          
           		<tr class="history_id_{{$history->history_id}}">
           			<td>{{$history->history_id}}</td>
                <td><a href="">{{$history->vaccine_name}}</a></td>
                <td>{{$history->age_in_days}}</td>
                <td>{{$history->route}}</td>
           			<td>{{$history->start_date}}</td>
           			<td>{{$history->finish_date}}</td>
                
                <td>
                  <button class="btn btn-default" onclick="editHistory('{{$history->history_id}}')">Edit</button>
                  <button class="btn btn-default" onclick="deleteHistory('{{$history->history_id}}')">Delete</button>
                </td>
           		</tr>
           		
          @endforeach
        @else
          <tr><td colspan="5"><h3>No vaccine added Yet!!!</h3></td></tr>
        @endif
        			</tbody>
		        </table>
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
        <h4 class="modal-title">Create New vaccine</h4>
      </div>
      <form method="POST" action="#" accept-charset="UTF-8" id="project_form">
          <div class="modal-body">       
                <div class="form-group">
                    <input type="text" name="flock" readonly="readonly" id="flock" class="form-control" placeholder="Flock" value="{{$flock->display_id}}" />
                </div>

                <div class="form-group">
                    <select name="vaccine_id" id="vaccine_id" class="form-control" placeholder="Vaccine">
                      @foreach($vaccines as $vaccine)
                        <option value="{{$vaccine->vaccine_id}}"> {{$vaccine->vaccine_name}} </option>
                      @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <input type="text" name="route" id="route" class="form-control " placeholder="Common Route for vaccination" />                    
                </div>

                <div class="form-group">
                    <input type="text" name="start_date" id="start_date" class="form-control datepicker" placeholder="Vaccination Start Date" />                    
                </div>

                <div class="form-group">
                    <input type="text" name="finish_date" id="finish_date" class="form-control datepicker" placeholder="vaccication Finish Date" />
                </div>

                <div class="form-group">
                    <input type="text" name="age_in_days" id="age_in_days" class="form-control " placeholder="Flock Age (in days)" />                    
                </div>

  
          </div>

          <div class="modal-footer">
            <input name="_token" value="{{ csrf_token() }}" type="hidden"/>
            <input name="flock_id" id="flock_id" type="hidden" value="{{$flock->flock_id}}" />
            <input name="history_id" id="history_id" type="hidden" value="" />
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

    $('.datepicker').datepicker({'format':'yyyy-mm-dd','viewMode':'2',autoclose: true, startDate: '-1d'}).on('changeDate', function(e){
        $(this).datepicker('hide');
    });
  
     // funciton handles new boards when dialog box submit a new request to create new board. 
     $('.modal form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
          type: "POST",
          url: "{{ action('VaccinesController@saveHistory') }}",
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
                
                var errors = jQuery.parseJSON(msg);
                for (var key in errors) {
                   // alert(key+ ">>>"+ errors[key][0]);
                    $("#"+key).after("<label class='error'>"+errors[key][0]+"</label>");
                }
            } else{
                var vaccineNAme = $("#vaccine_id").find("option[value="+$("#vaccine_id").val()+"]").text();
                var strHtml = '<tr class="history_id_'+msg+'"><td>'+msg+'</td>';
                      strHtml += '<td><a href="">'+vaccineNAme+'</a></td>';
                      strHtml += '<td>'+$("#age_in_days").val()+'</td>';
                      strHtml += '<td>'+$("#route").val()+'</td>';
                      strHtml += '<td>'+$("#start_date").val()+'</td>';
                      strHtml += '<td>'+$("#finish_date").val()+'</td>';
                      strHtml += '<td><button class="btn btn-default" onclick="editHistory(\''+msg+'\')">Edit</button><button class="btn btn-default" onclick="deleteHistory(\''+msg+'\')">Delete</button></td>';
                      strHtml +='</tr>';
                if($("#history_id").val() == '') {
                  $("#history_list tbody").find('tr:last-child').after(strHtml);
                  alertMsg = "New Vacccination Record Has been Saved";
                } else{
                  alertMsg = "Vaccinatopm Content has been updated";
                  $("#history_list tbody").find("tr.history_id_"+$("#history_id").val()).replaceWith(strHtml);
                  //$("#team_form_"+msg+" .panel-heading a").text($("#project_title").val())
                }

               $("#myModal").hide();
               $("#project_form").find("input[type=text], textarea").val("");
               $("#history_id").val("");

               //$(".ajax_box").removeClass('alert-danger').text("Success: New Project Has been Created").addClass('alert-success').show('slow').hide('slow');
              new PNotify({
                title: 'Success',
                text: alertMsg,
                type: 'success',
                addclass: "stack-topleft"
              });
            }
            
        });


    });

    $('#myModal').on('hidden.bs.modal', function (e) {
      $("#project_form")[0].reset();
    });

});


//function used to remove project from database.
function deleteHistory(Id){
  if(confirm("Are you Sure to delete This Record?")) {
    var url = getvalidUrl('VaccinesController@deleteHistory', Id);
    $.ajax({
      type: "post",
      url: url,
      data:{'_token': "{{ csrf_token() }}"}
      
    })
    .done(function( msg ) {
        //check if response from server is success or not . because json object will be returned if there are validation errors.

      $("#history_list tbody").find("tr.history_id_"+Id).remove();
        
     
      //$(".panel_container_top").isotope();
      if(msg == 1 ) {
        new PNotify({
          title: 'Success',
          text: 'History Record has been removed.',
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
function editHistory(Id){
  var url = getvalidUrl('VaccinesController@editHistory', Id);
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
                      if(key != 'vaccine_id') {
                       
                        $("#"+key).val(value);
                      } else {
                        $("#"+key).find("option[value="+value+"]").attr('selected',true);
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