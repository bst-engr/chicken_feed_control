@extends('layouts.default')

@section('title')
 Titers - {{$flock->display_id}}
@stop

@section('page_title')
  Titers - {{$flock->display_id}}
  <button type="button" class="btn btn-primary modal_button pull-right" data-toggle="modal" data-target=".bs-example-modal">Add New</button>
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
            <table class="table table-bordered table-striped table-hover" id="titer_list">
                <thead>
                    <tr>
                      <th>Id</th>
                      <th>Date</th>
                      <th>Lab</th>
                      <th>Titer</th>
                      <th>Range</th>
                      <th>Avg.</th>
                      <th>CV</th>
                      <th>Action</th>
                  </tr>
                </thead>
                 <tbody>
                    
        @if($titers)
        
          @foreach($titers as $titer)
          
              <tr class="titer_id_{{$titer->titer_id}}">
                <td>{{$titer->titer_id}}</td>
                <td>{{$titer->date}}</td>
                <td>{{$titer->lab_name}}</td>
                <td>{{$titer->disease_name}}</td>
                <td>{{$titer->range}}</td>
                <td>{{number_format($titer->average,'2','.','')}}</td>
                <td>{{$titer->titer_cv}}</td>
                      
                <td>
                  <button class="btn btn-default" onclick="editTiter('{{$titer->titer_id}}')">Edit</button>
                  <button class="btn btn-default" onclick="deleteTiter('{{$titer->titer_id}}')">Delete</button>
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
        <h4 class="modal-title">Titer</h4>
      </div>
      <form method="POST" class="form-horizontal" action="#" accept-charset="UTF-8" id="project_form">
          <div class="modal-body">       
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Lab Name</label>
                    <div class="col-sm-9">
                    <input type="text" name="lab_name" id="lab_name" class="form-control" placeholder="Lab Name" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Date</label>
                    <div class="col-sm-9">
                      <input type="text" name="date" id="date" class="form-control datepicker" placeholder="Date" />
                    </div>
                </div>
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Titer</label>
                    <div class="col-sm-9">
                    <select name="disease_id" id="disease_id" class="form-control " placeholder="Titer">
                        @foreach($diseases as $disease)
                          <option value="{{$disease->disease_id}}">{{$disease->disease_name}}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Titer CV</label>
                    <div class="col-sm-9">
                    <input type="text" name="titer_cv" id="titer_cv" class="form-control" placeholder="CV" />
                    </div>
                </div>
                <div class="form-group">
                  <label>Marking</label>

                </div>
                <div class="form-group">
                  <table class="table table-stripped marking_table">
                    <tr>
                      <th>Marking</th>
                      <th>Sample Tested</th>
                      <th>Individual Titers</th>
                      <th>Mean</th>
                    </tr>
                    <tr class="marking_row">
                      <td>
                        <input type="text" name="marking[1]" id="marking_1" value="1" readonly="readonly" class="form-control" />
                      </td>
                      <td>
                        <input type="text" name="sample_tested[1]" class="form-control sample_tested" />
                      </td>
                      <td>
                        <input type="text" name="individual_titers[1]" class="individual_titers form-control" />
                      </td>
                      <td>
                        <input type="text" name="mean[1]" class="titers_mean form-control" readonly="readonly" />
                      </td>
                    </tr>
                    <tr class="marking_row">
                      <td>
                        <input type="text" name="marking[2]" id="marking_2" value="2" readonly="readonly" class="form-control" />
                      </td>
                      <td>
                        <input type="text" name="sample_tested[2]" class="form-control sample_tested" />
                      </td>
                      <td>
                        <input type="text" name="individual_titers[2]" class="individual_titers form-control" />
                      </td>
                      <td>
                        <input type="text" name="mean[2]" class="titers_mean form-control" readonly="readonly" />
                      </td>
                    </tr>
                    <tr class="marking_row">
                      <td>
                        <input type="text" name="marking[3]" id="marking_3" value="3" readonly="readonly" class="form-control" />
                      </td>
                      <td>
                        <input type="text" name="sample_tested[3]" class="form-control sample_tested" />
                      </td>
                      <td>
                        <input type="text" name="individual_titers[3]" class="individual_titers form-control" />
                      </td>
                      <td>
                        <input type="text" name="mean[3]" class="titers_mean form-control" readonly="readonly" />
                      </td>
                    </tr>
                    <tr class="marking_row">
                      <td>
                        <input type="text" name="marking[4]" id="marking_4" value="4" readonly="readonly" class="form-control" />
                      </td>
                      <td>
                        <input type="text" name="sample_tested[4]" class="form-control sample_tested" />
                      </td>
                      <td>
                        <input type="text" name="individual_titers[4]" class="individual_titers form-control" />
                      </td>
                      <td>
                        <input type="text" name="mean[4]" class="titers_mean form-control" readonly="readonly" />
                      </td>
                    </tr>
                    <tr class="marking_row">
                      <td>
                        <input type="text" name="marking[5]" id="marking_5" value="5" readonly="readonly" class="form-control" />
                      </td>
                      <td>
                        <input type="text" name="sample_tested[5]" class="form-control sample_tested" />
                      </td>
                      <td>  
                        <input type="text" name="individual_titers[5]" class="individual_titers form-control" />
                      </td>
                      <td>
                        <input type="text" name="mean[5]" class="titers_mean form-control" readonly="readonly" />
                      </td>
                    </tr>
                  </table>
                </div>

          </div>
          <div class="modal-footer">
            <input name="_token" value="{{ csrf_token() }}" type="hidden"/>
            <input name="titer_id" id="titer_id" value="" type="hidden" />
            <input name="flock_id" id="flock_id" value="{{$flock->flock_id}}" type="hidden" />
            <input name="average" id="average" value="" type="hidden" />
            <input name="range" id="range" value="" type="hidden" />
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
  $(".add_marking").click(function(){
    var markingV = Number($(document).find('.marking_row').length);
        markingV = markingV+1;
      var html='<tr class="marking_row">';
          html +='  <td>';
          html +='  <input type="text" name="marking[]" id="marking_1" value="'+markingV+'" readonly="readonly" class="form-control" />';
          html +='  </td>';
          html +='  <td>';
          html +='    <input type="text" name="sample_tested[]" class="form-control sample_tested" />';
          html +='  </td>';
          html +='  <td>';
          html +='    <input type="text" name="individual_titers[]" class="individual_titers form-control" />';
          html +='  </td>';
          html +='  <td>';
          html +='    <input type="text" name="mean[]" class="titers_mean form-control" readonly="readonly" />';
          html +='  </td>';
          html +='</tr>';

          $(".marking_table").find('tr:last-child').after(html);
  });


  $(document.body).on('blur',".individual_titers",function(){
      
    //over all average of individual titers.
    var range = minMaxValue(".individual_titers");
    var t=len=0;
    $(document).find(".individual_titers").each(function(){
      t = t+ Number($(this).val());
      len++;
    });
    var avg=t/len;
    var parent = $(this).parent();

    var total=length=0;
    parent.children('.individual_titers').each(function(){
      length++;
      total=total+Number($(this).val());
    });
    var mean=total/length;
    console.log(">>>>"+mean.toFixed(2));

    parent.parent().children('td:last-child').children('.titers_mean').val(mean.toFixed(2));//.titers_mean').val(mean.toFixed(2));
    $("#average").val(avg);
    $("#range").val(range);
  });

  $('.sample_tested').on('blur',function(){
    var parentTr = $(this).parent().parent();
    var markingVal=parentTr.children('td:first-child').children('input').val();
    var parent = $(this).parent().next();
      parent.children().remove();
      var samples = $(this).val();
      var fields='';
      for(i=1;i<=samples;i++){
        fields +='<input type="text" name="individual_titers['+markingVal+'][]" class="individual_titers form-control" />';
      }
      parent.children().remove();
      parent.append(fields);
  });

  $('#titer_list').DataTable({
                responsive: true
        });
     // funciton handles new boards when dialog box submit a new request to create new board. 
     $('.modal form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
          type: "POST",
          url: "{{ action('TiterController@titerStore') }}",
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
                var strHtml = '<tr class="disease_id_'+msg+'"><td>'+msg+'</td>';
                      strHtml += '<td><a href="">'+$("#disease_name").val()+'</a></td>';
                      strHtml += '<td>'+$("#common_name").val()+'</td>';
                      strHtml += '<td>'+$("#titer_cv").val()+'</td>';
                      strHtml += '<td><button class="btn btn-default" onclick="editTiter(\''+msg+'\')">Edit</button><button class="btn btn-default" onclick="deleteTiter(\''+msg+'\')">Delete</button></td>';
                      strHtml +='</tr>';
                if($("#disease_id").val() == '') {
                  $("#titer_list tbody").find('tr:last-child').after(strHtml);
                  alertMsg = "New Titer Record Has been Saved";
                } else{
                  alertMsg = "Titer Content has been updated";
                  $("#titer_list tbody").find("tr.disease_id_"+$("#disease_id").val()).replaceWith(strHtml);
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
            window.location='';
        });


    });

    $('#myModal').on('hidden.bs.modal', function (e) {
      $("#project_form")[0].reset();
    });

});


//function used to remove project from database.
function deleteTiter(titerId){
  if(confirm("Are you Sure to delete This Titer?")) {
    var url = getvalidUrl('TiterController@deleteTiter', titerId);
    $.ajax({
      type: "post",
      url: url,
      data:{'_token': "{{ csrf_token() }}"}
      
    })
    .done(function( msg ) {
        //check if response from server is success or not . because json object will be returned if there are validation errors.

      $("#titer_list tbody").find("tr.titer_id_"+titerId).remove();
        
     
      //$(".panel_container_top").isotope();
      if(msg == 1 ) {
        new PNotify({
          title: 'Success',
          text: 'Titer Record has been removed.',
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

function minMaxValue(selector) {
  var min=null, max=null;
  $(selector).each(function() {
    var id = parseInt(this.value, 10);
    if ((min===null) || (id < min)) { min = id; }
    if ((max===null) || (id > max)) { max = id; }
  });
  return min+"-"+max;
}

//function used to get project Detail from database to edit.
function editTiter(diseaseID){

  var url = getvalidUrl('TiterController@editTiter', diseaseID);
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

                    $.each(fields[0]['titer'], function(key, value) {
                        $("#"+key).val(value);
                    });
                    var child=2;
                    $.each(fields[0]['titerDetail'],function(key, value){
                      console.log("table tr:nth-child("+child+") .sample_tested"+value['sample_tested']);
                      $(document).find("table tr:nth-child("+child+") .sample_tested").val(Number(value['sample_tested'])).trigger('blur');
                      var indTiter = value['individual_value'].split(",");
                      for(var i=0; i <indTiter.length;i++){
                        $(document).find("table tr:nth-child("+child+") td:nth-child(3)").children('.individual_titers:nth-child('+(Number(i)+1)+')').val(indTiter[i]).trigger('blur');
                      }
                      child++;
                    });
                }
                //$("#doctor_id").attr('disabled', true);
                $(".modal_button").trigger('click');
            } 
            
        });
}


</script>

@stop