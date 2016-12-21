<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', array('as'=>'home','uses'=>'DashboardController@index'));

/**/
//Route::resource('pms', 'PmsController');
Route::group(['prefix' => 'flocks'], function() {
	Route::get('/',array('as'=>'flocks','uses'=>'FlocksController@index'));
	Route::post('save',array('as'=>'save_flock','uses'=>'FlocksController@store'));
	Route::post('standard',array('as'=>'standards','uses'=>'FlocksController@storeStandards'));
	Route::post('delete/{flock_id}',array('as'=>'delete_flock','uses'=>'FlocksController@destroy'));
	Route::get('edit/{flock_id}',array('as'=>'edit_flock','uses'=>'FlocksController@edit'));
	Route::get('doctors',array('as'=>'doctors','uses'=>'FlocksController@doctors'));
	Route::get('view/{flock_id}', array('as'=>'flock_view','uses'=>'FlocksController@view'));
	Route::get('daily_feed/{flock_id}', array('as'=>'daily_feed','uses'=>'FlocksController@dailyFeed'));
	Route::post('daily_feed/{flock_id}', array('as'=>'store_daily_feed','uses'=>'FlocksController@storeDailyFeed'));
	Route::get('edit_daily_feed/{flock_id}',array('as'=>'edit_daily_feed','uses'=>'FlocksController@editDailyFeed'));
	Route::post('delete_daily_feed/{flock_id}',array('as'=>'delete_daily_feed','uses'=>'FlocksController@deleteDailyFeed'));

	Route::get('weekly_feed/{flock_id}', array('as'=>'weekly_feed','uses'=>'FlocksController@weeklyFeed'));
	Route::post('weekly_feed/{flock_id}', array('as'=>'store_weekly_feed','uses'=>'FlocksController@storeWeeklyFeed'));
	Route::get('edit_weekly_feed/{flock_id}',array('as'=>'edit_weekly_feed','uses'=>'FlocksController@editWeeklyFeed'));
	Route::post('delete_weekly_feed/{flock_id}',array('as'=>'delete_weekly_feed','uses'=>'FlocksController@deleteWeeklyFeed'));
	Route::post('close_flock/{flokc_id}',array('as'=>'closed_flock', 'uses'=>'FlocksController@closeFlock'));
	
});

/* Manage Diseases*/
Route::group(['prefix' => 'disease'], function() {
	Route::get('/',array('as'=>'disease','uses'=>'DiseasesController@index'));
	Route::post('save',array('as'=>'save_disease','uses'=>'DiseasesController@store'));
	Route::post('delete/{flock_id}',array('as'=>'delete_disease','uses'=>'DiseasesController@destroy'));
	Route::get('edit/{flock_id}',array('as'=>'edit_disease','uses'=>'DiseasesController@edit'));
});

/* Manage Diseases*/
Route::group(['prefix' => 'mortality'], function() {
	Route::get('/',array('as'=>'mortality','uses'=>'MortalityController@index'));
	Route::post('save',array('as'=>'save_mortality','uses'=>'MortalityController@store'));
	Route::post('delete/{mortality_id}',array('as'=>'delete_mortality','uses'=>'MortalityController@destroy'));
	Route::get('edit/{mortality_id}',array('as'=>'edit_mortality','uses'=>'MortalityController@edit'));
});

/* Manage Vaccines*/
Route::group(['prefix' => 'vaccine'], function() {
	Route::get('/',array('as'=>'vaccine','uses'=>'VaccinesController@index'));
	Route::post('save',array('as'=>'save_vaccine','uses'=>'VaccinesController@store'));
	Route::post('delete/{flock_id}',array('as'=>'delete_vaccine','uses'=>'VaccinesController@destroy'));
	Route::get('edit/{flock_id}',array('as'=>'edit_vaccine','uses'=>'VaccinesController@edit'));
	Route::get('history/{flock_id}', array('as' => 'flock_history','uses'=>'VaccinesController@vaccinationHistory' ));
	Route::post('history', array('as' => 'save_flock_history','uses'=>'VaccinesController@saveHistory' ));
	Route::get('edit_vaccination/{history_id}', array('as' => 'edit_flock_history','uses'=>'VaccinesController@editHistory' ));
	Route::post('delete_vaccination/{history_id}', array('as' => 'delete_flock_history','uses'=>'VaccinesController@deleteHistory' ));
	Route::get('administration',array('as'=>'titer_comparison','uses'=>'TiterController@vacComparison'));
});

/*titers*/
Route::group(['prefix' => 'titers'], function() {
	Route::get('/{flock_id}',array('as'=>'all_titers','uses'=>'TiterController@titers'));
	Route::post('/',array('as'=>'add_titer','uses'=>'TiterController@titerStore'));
	Route::get('edit_titer/{titer_id}',array('as'=>'edit_titer','uses'=>'TiterController@editTiter'));
	Route::post('delete_titer/{titer_id}',array('as'=>'delete_titer','uses'=>'TiterController@deleteTiter'));
	
});

/*Reports*/
Route::group(['prefix' => 'reports'], function() {
	Route::get('/',array('as'=>'reports','uses'=>'ReportsController@index'));	
	Route::get('daily_feed',array('as'=>'dailyReports','uses'=>'ReportsController@dailyFeedReport'));
	Route::get('daily_water_consumption',array('as'=>'dailyWaterReports','uses'=>'ReportsController@dailyWaterConsumptionReport'));
	Route::get('daily_mortality',array('as'=>'dailyMortalityReports','uses'=>'ReportsController@getDailyMortalityReport'));	
	Route::get('daily_temprature',array('as'=>'dailyTempratureReports','uses'=>'ReportsController@getDailyTempratureReport'));	
	Route::get('daily_humidity',array('as'=>'dailyHumidityReports','uses'=>'ReportsController@getDailyHumidityReport'));	
	Route::get('daily_egg_weight',array('as'=>'dailyEggWeightReports','uses'=>'ReportsController@getEggWeightReport'));	
	Route::get('daily_egg_production',array('as'=>'dailyEggProductionReports','uses'=>'ReportsController@getEggProductionReport'));	
	//Weekly Reports
	Route::get('body_weight',array('as'=>'weeklyBodyWeightReports','uses'=>'ReportsController@getBodyWeightReport'));	
	Route::get('uniformity',array('as'=>'weeklyUniformityReports','uses'=>'ReportsController@getUniformityReport'));	
	Route::get('manure_removal',array('as'=>'weeklyManureRemovalReports','uses'=>'ReportsController@getManureRemovalReport'));	
	Route::get('light_intensity',array('as'=>'weeklyLightIntensityReports','uses'=>'ReportsController@getLightIntensityReport'));	
	Route::get('windVelocity',array('as'=>'weeklyWindVelocityReports','uses'=>'ReportsController@getWindVelocityReport'));	
	Route::get('eggs_per_hen_housed',array('as'=>'eggsPerHenHousedReports','uses'=>'ReportsController@eggsPerHenHousedReport'));
	//End Weekly Reports
	//Consolidated Report
	Route::get('daily_consolidated',array('as'=>'dailyConsolidatedReport','uses'=>'ReportsController@getDailyConsolidatedReport'));	
	Route::get('weekly_consolidated',array('as'=>'weeklyConsolidatedReport','uses'=>'ReportsController@getWeeklyConsolidatedReport'));	
	//End Consolidated
	Route::get('titers', array('as'=>'titersReport','uses'=>'ReportsController@getTitersReport'));
	//
	Route::post('daily_report',array('as'=>'dailyReports','uses'=>'ReportsController@dailyReport'));	
	Route::post('commulative_weekly_report',array('as'=>'dailyReports','uses'=>'ReportsController@commulativeWeeklyReport'));	
	Route::post('commulative_flock_report',array('as'=>'dailyReports','uses'=>'ReportsController@commulativeFlockReport'));	
	Route::post('feed_per_egg',array('as'=>'feedPerEgg','uses'=>'ReportsController@feedPerEggReport'));	
	Route::post('mortality_report',array('as'=>'mortalityReports','uses'=>'ReportsController@dailyMortalityReport'));	
	Route::post('commulative_mortality_report',array('as'=>'commulative_mortality_report','uses'=>'ReportsController@commulativeMortalityReport'));	
	Route::post('temprature_report',array('as'=>'tempratureReports','uses'=>'ReportsController@dailyTempratureReport'));	
	Route::post('humidity_report',array('as'=>'HumidityReports','uses'=>'ReportsController@dailyHumidityReport'));
	Route::post('bodyweight_report',array('as'=>'bodyWeightReports','uses'=>'ReportsController@WeeklyBodyWeightReport'));
	Route::post('bodyweight_gain_perday_report',array('as'=>'bodyWeightGainPerDayReports','uses'=>'ReportsController@getWeightGainPerDay'));
	Route::post('weekly_report',array('as'=>'weeklyReport','uses'=>'ReportsController@weeklyReport'));
	Route::post('wind_velocity_report',array('as'=>'weeklyWindVelocityReport','uses'=>'ReportsController@weeklyWindVelocityReport'));
	Route::post('cosolidated_daily_report',array('as'=>'consolidated_daily_report','uses'=>'ReportsController@consolidatedDailyReport'));
	Route::post('consolidated_weekly_report',array('as'=>'consolidated_weekly_report','uses'=>'ReportsController@consolidatedWeeklyReport'));
	Route::post('titers_report',array('as'=>'titers_report','uses'=>'ReportsController@titerReport'));
	Route::post('eggs_per_hen_housed',array('as'=>'eggsPerHenHoused','uses'=>'ReportsController@getEggsPerHenHousedReport'));
	//compare Reports
	Route::get('compare_flocks',array('as'=>'flock_comparison','uses'=>'ReportsController@getFlockComparisonRerport'));
	Route::post('compare_flocks',array('as'=>'flockComparison','uses'=>'ReportsController@flockComparisonReporting'));
	Route::post('compare_titer',array('as'=>'titerComparison','uses'=>'ReportsController@titerComparisonReporting'));
});
/**/
Route::get('home', 'DashboardController@index');
Route::post('home', 'DashboardController@checkTodayRecord');

Route::post('getUrl', array('as'=>'getUrl', function(){
	echo action(Input::get('action'), array(Input::get('param')));
}));

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
