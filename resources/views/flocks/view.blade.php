@extends('layouts.default')

@section('title')
Flocks
@stop

@section('page_title')
  {{$flock->display_id}}
@stop

@sub_page_title
History
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
		        <table style="display:none;" class="table table-striped table-bordered table-condensed table-hover" id="flock_list">
		            <thead>
		                <tr>
		                	<th>Day</th>
		                	<th>Date</th>
		                	<th>Feed</th>
		                	<th>Egg Weight</th>
		                	<th>Egg Production</th>
                      <th>Water Consuption</th>
                      <th>Temprature</th>
                      <th>Humidity</th>
                      <th>Mortality</th>

		            	</tr>
                  <tr>
                      <th></th>
                      <th></th>
                      <th>
                        <table class="table table-bordered">
                          <tr>
                              <td>Standard</td>
                              <td>Actual</td>
                          </tr>
                        </table>
                      </th>
                      <th>
                        <table class="table table-bordered">
                          <tr>
                              <td>Standard</td>
                              <td>Actual</td>
                          </tr>
                        </table>
                      </th>
                      <th>
                        <table class="table table-bordered">
                          <tr>
                              <td>Standard</td>
                              <td>Actual</td>
                          </tr>
                        </table>
                      </th>
                      <th>
                        <table class="table table-bordered">
                          <tr>
                              <td>Standard</td>
                              <td>Actual</td>
                          </tr>
                        </table>
                      </th>
                      <th>
                        <table class="table table-bordered">
                          <tr>
                              <td>Standard</td>
                              <td>min</td>
                              <td>max</td>
                              <td>avg.</td>
                          </tr>
                        </table>
                      </th>
                      <th>
                        <table class="table table-bordered">
                          <tr>
                              <td>Standard</td>
                              <td>Actual</td>
                          </tr>
                        </table>
                      </th>
                      <th>
                        <table class="table table-bordered">
                          <tr>
                              <td>Standard</td>
                              <td>Actual</td>
                          </tr>
                        </table>
                      </th>
                  </tr>
		            </thead>
		             <tbody>
		             	  
        @if($feeds)
        
          @foreach($feeds as $feed)
          
           		
          @endforeach
        @else
          <tr><td colspan="5"><h3>No Data added Yet!!!</h3></td></tr>
        @endif
        			</tbody>
		        </table>
            <div class="" id="tabs">
                <ul class="nav nav-tabs">
                  <li><a data-toggle="tab" href="#feed_tab">Feed Per Bird</a></li>
                  <li><a data-toggle="tab" href="#feed_consumption">WAter Consumption</a></li>
                  <li><a data-toggle="tab" href="#feed_weight">Egg Weight</a></li>
                  <li><a data-toggle="tab" href="#feed_production">Egg PRoduction</a></li>
                  <li><a data-toggle="tab" href="#feed_temprature">Temprature</a></li>
                </ul>
                <div class="tab-content">
                <div id="feed_tab"  class="tab-pane fade in active table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                      <thead>
                        <tr>
                            <th>Flock Age</th>
                            <th>Entry Date</th>
                            <th>Standard</th>
                            <th>Actual</th>
                            <th>Comments
                              <button type="button" class="btn btn-primary modal_button pull-right" data-toggle="modal" data-target=".bs-example-modal">Add New</button></th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>59.6</th>
                            <th>N/A</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>16 Dec 2015</th>
                            <th>61</th>
                            <th>61.5</th>
                            <th>N/A</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>55</th>
                            <th>sudden shed cleanup process was in process</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>59.6</th>
                            <th>N/A</th>
                          </tr>
                      </tbody>
                      
                    </table>
                </div>
                <div id="feed_consumption"  class="tab-pane fade table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                      <thead>
                        <tr>
                            <th>Flock Age</th>
                            <th>Entry Date</th>
                            <th>Standard</th>
                            <th>Actual</th>
                            <th>Comments</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>59.6</th>
                            <th>N/A</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>16 Dec 2015</th>
                            <th>61</th>
                            <th>61.5</th>
                            <th>N/A</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>55</th>
                            <th>sudden shed cleanup process was in process</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>59.6</th>
                            <th>N/A</th>
                          </tr>
                      </tbody>
                      
                    </table></div>
                <div id="feed_weight" class="tab-pane fade table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                      <thead>
                        <tr>
                            <th>Flock Age</th>
                            <th>Entry Date</th>
                            <th>Standard</th>
                            <th>Actual</th>
                            <th>Comments</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>59.6</th>
                            <th>N/A</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>16 Dec 2015</th>
                            <th>61</th>
                            <th>61.5</th>
                            <th>N/A</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>55</th>
                            <th>sudden shed cleanup process was in process</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>59.6</th>
                            <th>N/A</th>
                          </tr>
                      </tbody>
                      
                    </table></div>
                <div id="feed_production" class="tab-pane fade table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                      <thead>
                        <tr>
                            <th>Flock Age</th>
                            <th>Entry Date</th>
                            <th>Standard</th>
                            <th>Actual</th>
                            <th>Comments</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>59.6</th>
                            <th>N/A</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>16 Dec 2015</th>
                            <th>61</th>
                            <th>61.5</th>
                            <th>N/A</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>55</th>
                            <th>sudden shed cleanup process was in process</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>59.6</th>
                            <th>N/A</th>
                          </tr>
                      </tbody>
                      
                    </table></div>
                <div id="feed_temprature" class="tab-pane fade table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                      <thead>
                        <tr>
                            <th>Flock Age</th>
                            <th>Entry Date</th>
                            <th>Standard</th>
                            <th>Actual</th>
                            <th>Comments</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>59.6</th>
                            <th>N/A</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>16 Dec 2015</th>
                            <th>61</th>
                            <th>61.5</th>
                            <th>N/A</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>55</th>
                            <th>sudden shed cleanup process was in process</th>
                          </tr>
                          <tr>
                            <th>59</th>
                            <th>15 Dec 2015</th>
                            <th>61</th>
                            <th>59.6</th>
                            <th>N/A</th>
                          </tr>
                      </tbody>
                      
                    </table></div>
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
        <h4 class="modal-title">Daily Feed Per Bird</h4>
      </div>
      <form method="POST" action="#" accept-charset="UTF-8" id="project_form">
          <div class="modal-body">       
                <div class="form-group">
                    <input type="text" name="display_id" id="display_id" class="form-control" placeholder="Feed Per Bird (grm)" />
                </div>

                <div class="form-group">
                    <input type="text" name="doctor_id" id="doctor_id" class="form-control" placeholder="Comments if Any?" />
                </div>
  
          </div>
          <div class="modal-footer">
            <input name="_token" value="{{ csrf_token() }}" type="hidden"/>
            
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
  //$("#tabs").tabs();
  $('.datepicker').datepicker({'format':'yyyy-mm-dd','viewMode':'2',autoclose: true, startDate: '-1d'}).on('changeDate', function(e){
        $(this).datepicker('hide');
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
              return false;
          }
        }
      });

     // funciton handles new boards when dialog box submit a new request to create new board. 
     $('.modal form').on('submit', function(event) {
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
                      strHtml += '<td><a href="">'+$("#display_id").val()+'</a></td>';
                      strHtml += '<td>'+$("#doctor_id").val()+'</td>';
                      strHtml += '<td>'+$("#arrival_date").val()+'</td>';
                      strHtml += '<td>'+$("#batch_size").val()+'</td>';
                      strHtml += '<td><button class="btn btn-default" onclick="editFlock(\''+msg+'\')">Edit</button><button class="btn btn-default" onclick="deleteFlock(\''+msg+'\')">Delete</button></td>';
                      strHtml +='</tr>';
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
            }
            
        });


    });

    $('#myModal').on('hidden.bs.modal', function (e) {
      $("#doctor_id").attr('disabled', false);
      $("#project_form")[0].reset();
    });

});


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