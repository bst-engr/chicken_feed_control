@extends('layouts.default')

@section('title')
Other Periodical Report
@stop

@section('page_title')
  Periodical Others Reports
  <!-- if(Sentry::getUser()->hasAccess(''))-->
    <button type="button" class="btn btn-primary modal_button pull-right" data-toggle="modal" data-target=".bs-example-modal">Add New Report</button>
  
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
		        <table class="table table-bordered table-striped table-hover" id="report_list">
		            <thead>
		                <tr>
		                	<th>Id</th>
                      <th>Entry Date</th>
		                	<th>Title</th>
		                	<th>Attachment</th>
                      <th>Action</th>
		            	</tr>
		            </thead>
		             <tbody>
		             	  
        @if($reports)
        
          @foreach($reports as $report)
          
           		<tr class="report_id_{{$report->report_id}}">
           			<td>{{$report->report_id}}</td>
           			<td>{{$report->entry_date}}</td>
                <td>{{$report->title}}</td>
                <td>{{!empty($report->attachment) ? 'yes' : 'no'}}</td>
           			<td>
                  <button class="btn btn-default" onclick="editMortality('{{$report->report_id}}')">Edit</button>
                  <button class="btn btn-default" onclick="deleteMortality('{{$report->report_id}}')">Delete</button>
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





<div class="modal fade bs-example-modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add new Report</h4>
      </div>
      <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="#" accept-charset="UTF-8" id="project_form">
          <div class="modal-body">       
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Entry Date</label>
                    <div class="col-sm-9">
                    <input type="text" name="entry_date" id="entry_date" class="form-control datepicker" placeholder="Mortality Reason Name" />
                    </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Title</label>
                    <div class="col-sm-9">
                    <input type="text" name="title" id="title" class="form-control" placeholder="Mortality Reason Name" />
                    </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9">
                    <input type="text" name="description" id="description" class="form-control" placeholder="Mortality Reason Name" />
                    </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Report Type</label>
                    <div class="col-sm-9">
                    <select name="type" id="type" class="form-control" >
                      <option value=""> Select </option>
                      <option value="1">Day one Shed disinfection</option>
                      <option value="2">Disease Attach</option>
                      <option value="3">Others</option>

                    </select>
                    </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Attachment</label>
                    <div class="col-sm-9">
                    <input type="file" name="attachment" id="attachment" class="form-control">
                    </div>
                </div>
                
  
          </div>
          <div class="modal-footer">
            <input name="_token" value="{{ csrf_token() }}" type="hidden"/>
            <input name="report_id" id="report_id" value="" type="hidden" />
            <input name="flock_id" id="flock_id" value="{{$flock->flock_id}}" type="hidden" />
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
  $("body").on('focus','.datepicker',function(){
    $(this).datepicker({'format':'yyyy-mm-dd','viewMode':'2',autoclose: true, startDate: '-1d'}).on('changeDate', function(e){
        $(this).datepicker('hide');
    });
  });
  $('#report_list').DataTable({
                responsive: true
        });
     // funciton handles new boards when dialog box submit a new request to create new board. 
     $('.modal form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
          type: "POST",
          url: "{{ action('PeriodicalreportController@store') }}",
          processData: false,
          contentType: false,
          data: new FormData($("#project_form")[0]),//$("#project_form").serialize(),
          beforeSend: function() {
            
            $(".modal-footer").append('<span class="loading">Processing...</span>');
            $("#project_form").find("input[type=text], textarea, input[type=submit]").attr("disabled", true);
          }
        })
        .done(function( msg ) {
            //check if response from server is success or not . because json object will be returned if there are validation errors.
            $("#project_form").find("input[type=text], textarea, input[type=submit]").removeAttr("disabled");
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
                var projectTitle = $( "#report_id" ).val();
                var specialistName = '';//$("#specialist_name").val();
    /*            var strHtml = '<tr class="disease_id_'+msg+'"><td>'+msg+'</td>';
                      strHtml += '<td><a href="">'+$("#disease_name").val()+'</a></td>';
                      strHtml += '<td>'+$("#common_name").val()+'</td>';
                      strHtml += '<td><button class="btn btn-default" onclick="editMortality(\''+msg+'\')">Edit</button><button class="btn btn-default" onclick="deleteMortality(\''+msg+'\')">Delete</button></td>';
                      strHtml +='</tr>';*/
                if($("#report_id").val() == '') {
//                  $("#disease_list tbody").find('tr:last-child').after(strHtml);
                  alertMsg = "New Report Has been Saved";
                } else{
                  alertMsg = "Report Content has been updated";
  //                $("#disease_list tbody").find("tr.disease_id_"+$("#disease_id").val()).replaceWith(strHtml);
                  //$("#team_form_"+msg+" .panel-heading a").text($("#project_title").val())
                }

               $("#myModal").hide();
               $("button.close").trigger('click');
               $("#project_form").find("input[type=text], textarea").val("");
               $("#disease_id").val("");

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
      $("#project_form")[0].reset();
    });

});


//function used to remove project from database.
function deleteMortality(diseaseId){
  if(confirm("Are you Sure to delete This Report?")) {
    var url = getvalidUrl('PeriodicalreportController@destroy', diseaseId);
    $.ajax({
      type: "post",
      url: url,
      data:{'_token': "{{ csrf_token() }}"}
      
    })
    .done(function( msg ) {
        //check if response from server is success or not . because json object will be returned if there are validation errors.

      $("#report_list tbody").find("tr.report_id_"+diseaseId).remove();
        
     
      //$(".panel_container_top").isotope();
      if(msg == 1 ) {
        new PNotify({
          title: 'Success',
          text: 'Report has been removed.',
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
function editMortality(diseaseID){
  var url = getvalidUrl('PeriodicalreportController@edit', diseaseID);
   $.ajax({
          type: "get",
          url: url,
          
        })
        .done(function( msg ) {
            //check if response from server is success or not . because json object will be returned if there are validation errors.
            var response=jQuery.parseJSON(msg);
            console.log(response);
            if(typeof response =='object'){
                
                var fields = jQuery.parseJSON(msg);
               //console.log(fields);
                if(fields.length > 0){

                    $.each(fields[0], function(key, value) {
                      
                      if(key !='attachment'){
                        $("#"+key).val(value);
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