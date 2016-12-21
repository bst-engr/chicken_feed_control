@extends('layouts.default')

@section('title')
Blood Titers
@stop

@section('page_title')
  Manage Blood Titers
  @if(Sentry::getUser()->hasAccess('manage_titers'))
    <button type="button" class="btn btn-primary modal_button pull-right" data-toggle="modal" data-target=".bs-example-modal">Add New Titer</button>
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
		        <table class="table table-bordered table-striped table-hover" id="disease_list">
		            <thead>
		                <tr>
		                	<!-- <th>Id</th> -->
		                	<th>Blood Titer Name</th>
		                	<th>Common Name</th>
                      <th>Lower Limit</th>
                      <th>Upper Limit</th>
                      <th>Action</th>
		            	</tr>
		            </thead>
		             <tbody>
		             	  
        @if($diseases)
        
          @foreach($diseases as $disease)
          
           		<tr class="disease_id_{{$disease->disease_id}}">
           			<!-- <td>{$disease->disease_id}}</td> -->
           			<td>{{$disease->disease_name}}</td>
           			<td>{{$disease->common_name}}</td>
                <td>{{$disease->lower_limit}}</td>
                <td>{{$disease->upper_limit}}</td>
                <td>
                  <button class="btn btn-default" onclick="editDisease('{{$disease->disease_id}}')">Edit</button>
                  <button class="btn btn-default" onclick="deleteDisease('{{$disease->disease_id}}')">Delete</button>
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
        <h4 class="modal-title">Create New Disease</h4>
      </div>
      <form method="POST" class="form-horizontal" action="#" accept-charset="UTF-8" id="project_form">
          <div class="modal-body">       
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Scientific Name of Titer</label>
                    <div class="col-sm-9">
                    <input type="text" name="disease_name" id="disease_name" class="form-control" placeholder="Scientific Name of Disease" />
                    </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Common Name of Titer</label>
                    <div class="col-sm-9">
                      <input type="text" name="common_name" id="common_name" class="form-control" placeholder="Common Name of Disease" />
                    </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Lower Range</label>
                    <div class="col-sm-9">
                      <input type="text" name="lower_limit" id="lower_limit" class="form-control" placeholder="Lower Limit of Tolerance Range" />
                    </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Upper Range</label>
                    <div class="col-sm-9">
                      <input type="text" name="upper_limit" id="upper_limit" class="form-control" placeholder="Upper Limit of Tolerance Range" />
                    </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Few Words about Titer</label>
                    <div class="col-sm-9">
                      <input type="text" name="description" id="description" class="form-control " placeholder="Few Words about Flock" />                    
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
            <input name="disease_id" id="disease_id" value="" type="hidden" />
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

  $('#disease_list').DataTable({
                responsive: true
        });
     // funciton handles new boards when dialog box submit a new request to create new board. 
     $('.modal form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
          type: "POST",
          url: "{{ action('DiseasesController@store') }}",
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
                var strHtml = '<tr class="disease_id_'+msg+'">';
                    //strHtml += '<td>'+msg+'</td>';
                    strHtml += '<td>'+$("#disease_name").val()+'</td>';
                    strHtml += '<td>'+$("#common_name").val()+'</td>';
                    strHtml += '<td>'+$("#lower_limit").val()+'</td>';
                    strHtml += '<td>'+$("#upper_limit").val()+'</td>';
                    strHtml += '<td><button class="btn btn-default" onclick="editDisease(\''+msg+'\')">Edit</button><button class="btn btn-default" onclick="deleteDisease(\''+msg+'\')">Delete</button></td>';
                      strHtml +='</tr>';
                if($("#disease_id").val() == '') {
                  $("#disease_list tbody").find('tr:last-child').after(strHtml);
                  alertMsg = "New Titer Has been Saved";
                } else{
                  alertMsg = "Titer Content has been updated";
                  $("#disease_list tbody").find("tr.disease_id_"+$("#disease_id").val()).replaceWith(strHtml);
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
            }
            
        });


    });

    $('#myModal').on('hidden.bs.modal', function (e) {
      $("#project_form")[0].reset();
    });

});


//function used to remove project from database.
function deleteDisease(diseaseId){
  if(confirm("Are you Sure to delete This Disease?")) {
    var url = getvalidUrl('DiseasesController@destroy', diseaseId);
    $.ajax({
      type: "post",
      url: url,
      data:{'_token': "{{ csrf_token() }}"}
      
    })
    .done(function( msg ) {
        //check if response from server is success or not . because json object will be returned if there are validation errors.

      $("#disease_list tbody").find("tr.disease_id_"+diseaseId).remove();
        
     
      //$(".panel_container_top").isotope();
      if(msg == 1 ) {
        new PNotify({
          title: 'Success',
          text: 'Disease has been removed.',
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
function editDisease(diseaseID){

  var url = getvalidUrl('DiseasesController@edit', diseaseID);
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