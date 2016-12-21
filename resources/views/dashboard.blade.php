@extends('layouts.default')

@section('title')
Dashboard
@stop

@section('page_title')
Dashboard
@stop

@section('content')
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
// Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);
      google.setOnLoadCallback(drawTraineeChart);
      google.setOnLoadCallback(drawSkillChart);
      google.setOnLoadCallback(drawTraineeSkillChart);
      google.setOnLoadCallback(drawSpecialistSkillChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'EmployeeType');
        data.addColumn('number', 'number');
        var employeesStat = [];
        @if($employees)
          @foreach($employees as $employee)
            employeesStat.push(['{{ $employee->is_specialist == 0 ? "Trainees" : "Specialist"}}', Number("{{$employee->count}}")]);
          @endforeach
        @endif

        data.addRows(employeesStat);

        // Set chart options
        var options = {'title':'Total Number of Employees',
                       'width':500,
                       'height':350};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawTraineeChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'IsAssigned');
        data.addColumn('number', 'number');
        var traineeStat = [];
        @if($trainees)
          @foreach($trainees as $trainee)
            traineeStat.push(['{{ $trainee->is_assigned_derived == 0 ? "Not Assigned" : "Assigned"}}', Number("{{$trainee->count}}")]);
          @endforeach
        @endif

        data.addRows(traineeStat);

        // Set chart options
        var options = {'title':'Trainees Assignment',
                       'width':500,
                       'height':350};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_trainee_div'));
        chart.draw(data, options);
      }

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawSkillChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Skill');
        data.addColumn('number', 'number');
        var skillStat = [];
        @if($skills)
          @foreach($skills as $skill)
            skillStat.push(['{{ $skill->skill_title }}', Number("{{$skill->count}}")]);
          @endforeach
        @endif

        data.addRows(skillStat);

        // Set chart options
        var options = {'title':'Skill Concentration',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_skill_div'));
        chart.draw(data, options);
      }

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawSpecialistSkillChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Skill');
        data.addColumn('number', 'number');
        var skillStat = [];
        @if($specialistSkills)
          @foreach($specialistSkills as $skill)
            skillStat.push(['{{ $skill->skill_title }}', Number("{{$skill->count}}")]);
          @endforeach
        @endif

        data.addRows(skillStat);

        // Set chart options
        var options = {'title':'Specialists Skill Concentration',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_specialist_skill_div'));
        chart.draw(data, options);
      }

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawTraineeSkillChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Skill');
        data.addColumn('number', 'number');
        var skillStat = [];
        @if($traineeSkills)
          @foreach($traineeSkills as $skill)
            skillStat.push(['{{ $skill->skill_title }}', Number("{{$skill->count}}")]);
          @endforeach
        @endif

        data.addRows(skillStat);

        // Set chart options
        var options = {'title':'Trainees Skill Concentration',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_trainee_skill_div'));
        chart.draw(data, options);
      }


</script>  
 
<div class="row">
  <div class="col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Employees Stats</h3>
      </div>
      <div class="panel-body">
        <div class="col-sm-6">
          <div id="chart_div"></div>  
        </div>
        <div class="col-sm-6">
          <div id="chart_trainee_div"></div>  
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Skills Concentration</h3>
      </div>
      <div class="panel-body">
        <div class="col-sm-4">
          <div id="chart_skill_div"></div>  
        </div>
        <div class="col-sm-4">
          <div id="chart_trainee_skill_div"></div>  
        </div>
        <div class="col-sm-4">
          <div id="chart_specialist_skill_div"></div>  
        </div>
        
      </div>
    </div>
  </div>
</div>


@stop