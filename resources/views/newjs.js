    $(function(){
        $("#skill_alert").hide();
        //ssgHistory
        $.ajax({
            type: "GET",
            url: '{{ action("UserController@ssgHistory", array($user["id"])) }}',
        })
        .done(function( msg ) {
            if(msg != null) {
                var histroy = jQuery.parseJSON( msg )
                console.log(histroy);
                for(var i =0 ; i < histroy.length; i++ ){
                    $("#histroy").append('<tr><td>'+histroy[i].joining_date+'</td><td>'+histroy[i].release_date+'</td><td>'+histroy[i].training_area+'</td><td>'+histroy[i].specialist+'</td></tr>');    
                }
            }

        });

        // fetch skills of employee added so far to display in edit mode.
        $.ajax({
            type: "GET",
            url: '{{ action("SkillsController@getSkills", array($user["id"])) }}',
        })
        .done(function( msg ) {
            if(msg != null) {
                var skills = jQuery.parseJSON( msg )
                for(var i =0 ; i < skills.length; i++ ){
                    $("#current_skills").append('<li role="presentation" class="active"><a href="#">'+skills[i].skill_title+'</a><span class="glyphicon glyphicon-remove delete" id="'+skills[i].skill_id+'"> </span></li>');    
                }
            }
            // } else{
            //     $("#current_skills").append('<li role="presentation" class="active"><a href="#">No Skills Added Yet!!</a></li>');
            // }

        });

        $( "#skill_title" ).autocomplete({
            source: "{{action('SkillsController@findSkill')}}",
            minLength: 2,
            select: function( event, ui ) {
                if( ui.item) {
                    
                    UserSkill(ui.item.id,"{{ $user['id'] }}", 1);

                    var tag_span = '<li role="presentation" class="active"><a href="#">'+ui.item.label+'</a><span class="glyphicon glyphicon-remove delete" id="'+ui.item.id+'"> </span></li>';

                    $("#current_skills").append(tag_span);

                    if($("#tag_ids").val() !== '') {

                        $("#tag_ids").val($("#tag_ids").val()+","+ui.item.id);

                    } else {

                        $("#tag_ids").val(ui.item.id);
                    }

                    $("#tags").val('');
                    return false;
                }

            }
        });

        $("#current_skills").on('click','span.delete',function(){
            
            var id = $(this).attr('id');

            UserSkill(id,"{{ $user['id'] }}", 0);
            
            $(this).parent().remove();
            
        });

    });

function UserSkill(skillId,UserId,Action) {
    $.ajax({
            type: "POST",
            url: '{{ action("SkillsController@userSkills") }}',
            data: { skill_id: skillId, UserId: UserId, action: Action, _token: '{{ csrf_token() }}' }
        })
        .done(function( msg ) {
            if(msg == 1 && Action == 1) {

                $("#skill_alert").show().removeClass('alert-danger').addClass('alert-success').text('Success: skill has been saved!!').hide('slow');

            } else if(msg == 1 && Action == 0) {

                $("#skill_alert").show().removeClass('alert-danger').addClass('alert-success').text('Success: skill has been Removed!!').hide('slow');

            } else{

                $("#skill_alert").show().removeClass('alert-success').addClass('alert-danger').text('Oppsss: something Going Wrong Please Try Again!!').hide('slow');
            }

        });

}