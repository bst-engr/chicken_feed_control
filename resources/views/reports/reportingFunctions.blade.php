<script type="text/javascript">
$(function(){
$("#record_type").change(function(){
    $(".filters").hide();
    
    $("#compare_"+$(this).val()).show();
    
  });
});
function consolidatedReportings(reportParam){
  var isAll = $(".checkAll").is(":checked") ? true : false;
  var fromDate =  $("#dateFrom").val();
  var endDate =  $("#dateTo").val();
  var report_type = $("#report_type").val();

  var recordType = $("#record_type").val();
  var compareDayFrom=$("#compare_day_from").val();
  var compareDayTo = $("#compare_day_end").val();
  var compareWeekFrom = $("#compare_week_from").val();
  var compareWeekEnd = $("#compare_week_end").val();
  var dateFrom = $("#dateFrom").val();
  var dateTo = $("#dateTo").val();

  var fields=['feed_per_bird','feed_water_consumption', 'feed_egg_production', 'feed_egg_weight', 'feed_mortality', 'feed_temprature','feed_humidity'];
  var columns=[];
  fields.push(reportParam);
  columns.push({'data': 'entry_date'});
  columns.push({'data': 'bird_age_week'});

  $(".section_reports").hide();
  $("#section_"+reportParam).show();
  if(reportParam == 'daily_consolidated'){
    columns.push({'data': 'bird_age_day'});
    columns.push({'data': 'standard_feed_per_bird'});
    columns.push({'data': 'feed_per_bird'});
    columns.push({'data': 'standard_feed_water_consumption'});
    columns.push({'data': 'feed_water_consumption'});
    columns.push({'data': 'standard_feed_egg_production'});
    columns.push({'data': 'feed_egg_production'});
    columns.push({'data': 'standard_feed_egg_weight'});
    columns.push({'data': 'feed_egg_weight'});
    columns.push({'data': 'standard_feed_mortality'});
    columns.push({'data': 'feed_mortality'});
    columns.push({'data': 'standard_feed_temprature'});
    columns.push({'data': 'feed_temprature'});
    columns.push({'data': 'standard_feed_humidity'});
    columns.push({'data': 'feed_humidity'});

    $('#daily_consolidated_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@consolidatedDailyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
              "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });  

  } else if (reportParam == 'weekly_consolidated'){
    columns.push({'data': 'standard_feed_per_bird'});
    columns.push({'data': 'feed_per_bird'});
    columns.push({'data': 'standard_feed_water_consumption'});
    columns.push({'data': 'feed_water_consumption'});
    columns.push({'data': 'standard_feed_mortality'});
    columns.push({'data': 'feed_mortality'});
    columns.push({'data': 'standard_feed_egg_production'});
    columns.push({'data': 'feed_egg_production'});
    columns.push({'data': 'standard_feed_egg_weight'});
    columns.push({'data': 'feed_egg_weight'});
    columns.push({'data': 'standard_feed_egg_housed'});
    columns.push({'data': 'feed_egg_housed'});

    //--
    columns.push({'data': 'standard_body_weight'});
    columns.push({'data': 'body_weight'});
    columns.push({'data': 'standard_manure_removal'});
    columns.push({'data': 'manure_removal'});
    columns.push({'data': 'standard_light_intensity'});
    columns.push({'data': 'light_intensity'});
    columns.push({'data': 'standard_wind_velocity'});
    columns.push({'data': 'wind_velocity'});

    $('#weekly_consolidated_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@consolidatedWeeklyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
               "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });  
  }
}
function generateReportData(reportParam){
  var isAll = $(".checkAll").is(":checked") ? true : false;
  var fromDate =  $("#dateFrom").val();
  var endDate =  $("#dateTo").val();
  var report_type = $("#report_type").val();

  var recordType = $("#record_type").val();
  var compareDayFrom=$("#compare_day_from").val();
  var compareDayTo = $("#compare_day_end").val();
  var compareWeekFrom = $("#compare_week_from").val();
  var compareWeekEnd = $("#compare_week_end").val();
  var dateFrom = $("#dateFrom").val();
  var dateTo = $("#dateTo").val();


  var fields=[];
  var columns=[];
  fields.push(reportParam);
  columns.push({'data': 'entry_date'});
  columns.push({'data': 'bird_age_week'});
  columns.push({'data': 'bird_age_day'});
  columns.push({'data': 'standard_'+reportParam});
  columns.push({'data': reportParam});
  $(".section_reports").hide();
  $("#section_"+reportParam).show();
  if(reportParam == 'feed_per_bird'){
    // daily record
    //
    $('#daily_feed_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@dailyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
              "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });  
    //commulative weekly Report
    $('#comulative_weekly_feed_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@commulativeWeeklyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
              "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });  
    //commulative flock Report
    $('#comulative_flock_feed_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@commulativeFlockReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
              "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });  
    //commulative flock Report
    $('#daily_feed_per_egg').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@feedPerEggReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
              "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    }); 
    //feed per egg
    //daily_feed_per_egg
  } else if (reportParam == 'feed_mortality'){
    $.fn.dataTable.ext.errMode = 'none';
    //var columns1 = columns;
    columns.push({'data': 'standard_feed_mortality_com'});
    columns.push({'data': 'feed_mortality_com'});
    $('#daily_feed_mortality_commulative').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@commulativeMortalityReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
              "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });
    columns.pop();
    columns.pop();
    <?php
      foreach($reasons as $reason){
        ?>
        columns.push({'data': '<?php echo "reason_".$reason->id ?>'});
        <?php
      }
    ?>
    console.log(columns);
    $('#daily_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@dailyMortalityReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
              "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });
  } else if (reportParam == 'feed_temprature'){

    $('#daily_feed_feeling_temprature').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@dailyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
              "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });  

    columns.push({'data': 'feeling'});
    columns.push({'data': 'lowest_inner'});
    columns.push({'data': 'highest_inner'});
    columns.push({'data': 'highest_outter'});
    columns.push({'data': 'lowest_outter'});


    $('#daily_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@dailyTempratureReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
              "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });
  } else if(reportParam == 'feed_humidity'){
    //daily_feed_humidity_table
    columns.push({'data': 'outter_humidity'});
    $('#daily_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@dailyHumidityReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
              "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });  
  } else {
    $('#daily_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@dailyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
              "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });  
  }
  
}

function WeeklyReportings(reportParam){
  var isAll = $(".checkAll").is(":checked") ? true : false;
  var fromDate =  $("#dateFrom").val();
  var endDate =  $("#dateTo").val();
  var report_type = $("#report_type").val();

  var recordType = $("#record_type").val();
  var compareDayFrom=$("#compare_day_from").val();
  var compareDayTo = $("#compare_day_end").val();
  var compareWeekFrom = $("#compare_week_from").val();
  var compareWeekEnd = $("#compare_week_end").val();
  var dateFrom = $("#dateFrom").val();
  var dateTo = $("#dateTo").val();

  var fields=[];
  var columns=[];
  fields.push(reportParam);
  columns.push({'data': 'entry_date'});
  columns.push({'data': 'bird_age_week'});
  columns.push({'data': 'standard_'+reportParam});
  columns.push({'data': reportParam});
  $(".section_reports").hide();
  $("#section_"+reportParam).show();
  if(reportParam == 'eggs_per_hen_housed'){
    $.fn.dataTable.ext.errMode = 'none';
    $('#eggs_per_hen_housed_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@getEggsPerHenHousedReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
               "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });
  } else if (reportParam == 'body_weight'){
    $('#weekly_body_weight_gain_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@getWeightGainPerDay')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
               "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });
    columns.push({'data': 'standard_uniformity'});
    columns.push({'data': 'uniformity'});
    console.log("there");
    $('#weekly_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@WeeklyBodyWeightReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
               "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });
  } else if (reportParam == 'wind_velocity'){
    $.fn.dataTable.ext.errMode = 'none';
    $('#weekly_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@weeklyWindVelocityReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
               "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });  
  } else {
    $('#weekly_'+reportParam+'_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@weeklyReport')}}",
            "type": "POST",
            "data" : {
              options:fields,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
               "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });  
  }
}

function titersReporting(reportParam){
  var isAll = $(".checkAll").is(":checked") ? true : false;
  var fromDate =  $("#dateFrom").val();
  var endDate =  $("#dateTo").val();
  var report_type = $("#report_type").val();

  var recordType = $("#record_type").val();
  var compareDayFrom=$("#compare_day_from").val();
  var compareDayTo = $("#compare_day_end").val();
  var compareWeekFrom = $("#compare_week_from").val();
  var compareWeekEnd = $("#compare_week_end").val();
  var dateFrom = $("#dateFrom").val();
  var dateTo = $("#dateTo").val();

  var fields=[];
  var columns=[];
  fields.push(reportParam);
  columns.push({'data': 'entry_date'});
  columns.push({'data': 'bird_age_week'});
  columns.push({'data': 'lab_name'});
  columns.push({'data': 'range'});
  columns.push({'data': 'average'});
  $(".section_reports").hide();
  $("#section_titers").show();
  
    $('#titer_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@titerReport')}}",
            "type": "POST",
            "data" : {
              options:reportParam,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              flock: $("#flocks").val(),
              report_type: report_type,
              _token:"{{ csrf_token() }}",
               "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });  
    //commulative weekly Report
}

function generatePeriodicalReport(reportType){
  
  var isAll = $(".checkAll").is(":checked") ? true : false;
  var fromDate =  $("#dateFrom").val();
  var endDate =  $("#dateTo").val();
  var report_type = $("#report_type").val();

  var recordType = $("#record_type").val();
  var compareDayFrom=$("#compare_day_from").val();
  var compareDayTo = $("#compare_day_end").val();
  var compareWeekFrom = $("#compare_week_from").val();
  var compareWeekEnd = $("#compare_week_end").val();
  var dateFrom = $("#dateFrom").val();
  var dateTo = $("#dateTo").val();

  var fields=[];
  var columns=[];
  fields.push(reportType);
  columns.push({'data': 'entry_date'});
  columns.push({'data': 'title'});
  columns.push({'data': 'description'});
  columns.push({'data': 'attachment'});
  $("#section_periodical_reports").show();
    $('#periodical_reports_table').DataTable( {
        "processing": true,
        "responsive": true,
        "serverSide": false,
         destroy: true,
        "ajax": {
            "url": "{{action('ReportsController@getPeriodicalReportsData')}}",
            "type": "POST",
            "data" : {
              options:reportType,
              fetchAll: isAll,
              "dateFrom": fromDate,
              "dateTo": endDate,
              "report_type": reportType,
              flock: $("#flocks").val(),
              _token:"{{ csrf_token() }}",
               "recordType":recordType,
              "compareDayFrom":compareDayFrom,
              "compareDayTo":compareDayTo, 
              "compareWeekFrom":compareWeekFrom, 
              "compareWeekEnd":compareWeekEnd,
              "dateFrom":dateFrom, 
              "dateTo":dateTo
            }
        },
        "columns": columns
    });  
}
</script>