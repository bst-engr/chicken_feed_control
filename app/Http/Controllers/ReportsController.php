<?php namespace App\Http\Controllers;

use \App\Flock;
use \App\User;
use \App\Dailyfeeding;
use \App\Flockstandards;
use \App\Disease;
use \App\Mortalityreasons;
use \App\Report;

use Request;
// pagination
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

//response and view 
use Response;
use View, DB, Input, Mail;

// custom helper functions

class ReportsController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/
	private $flocks, $user, $dailyFeeding, $standards;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{	
		$this->middleware('ssg.auth');
		//only admin can access this controller
        //$this->middleware('ssg.admin');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{	
		
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.reports',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}
	public function dailyFeedReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.dailyFeedReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}

	public function dailyWaterConsumptionReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.dailyWaterConsumptionReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}

	public function getDailyMortalityReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.mortalityReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}

	public function getDailyTempratureReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.dailyTempratureReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}

	public function getDailyHumidityReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.dailyHumidityReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}

	public function getEggWeightReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.dailyEggWeightReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}

	public function getEggProductionReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.dailyEggProduction',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}
	//-----------------------------------//
	public function getBodyWeightReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.weeklyBodyWeightReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}
	
	public function getUniformityReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.weeklyUniformityReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}
	
	public function getManureRemovalReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.weeklyManureRemoval',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}
	
	public function getLightIntensityReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.weeklyLightIntensityReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}

	public function getWindVelocityReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.weeklyWindVelocityReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}
	//*------------------------------------*/
	public function getDailyConsolidatedReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.dailyConsolidatedReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}

	public function getWeeklyConsolidatedReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.weeklyConsolidatedReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}
	/***************/
	public function getTitersReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.monthlyTitersReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));
	}

	public function getFlockComparisonRerport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.comparativeReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));		
	}

	public function eggsPerHenHousedReport(){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$titers = DB::table('diseases')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		return view('reports.eggsPerHenHousedReport',array('existingFlocks'=>$existingFlocks, 'titers'=>$titers, 'reasons'=>$reasons));		
	}

	public function periodicalReports($type){
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		$reasons = DB::table('mortality_reasons')->where('status','=','1')->get();
		$reportType ='';
		if($type == 1){
			$reportType = 'Day one shed disinfection';
		} else if ($type == 2) {
			$reportType = 'Disease Attack';
		} else if ($type == 3) {
			$reportType = 'Others';
		}
		return view('reports.periodicalReports',array('existingFlocks'=>$existingFlocks,'reportType'=> $reportType, 'typeN'=>$type, 'reasons'=>$reasons) );
	}
	/***************/
	public function dailyReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->fetchDailyReportData(Input::all());
		return json_encode($dailyReport);
	}

	public function commulativeWeeklyReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->fetchCommulativeWeekReportData(Input::all());
		return json_encode($dailyReport);
	}

	public function commulativeFlockReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->fetchCommulativeFlockReportData(Input::all());
		return json_encode($dailyReport);	
	}
	public function feedPerBird(){
		$reportObj = new Report;
		$dailyReport = $reportObj->fetchFeedPerBirdData(Input::all());
		return json_encode($dailyReport);	
	}

	public function feedPerEggReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->fetchFeedEggData(Input::all());
		return json_encode($dailyReport);		
	}

	public function dailyMortalityReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->fetchDailyMortalityData(Input::all());
		return json_encode($dailyReport);		
	}

	public function dailyTempratureReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->getTemprateReport(Input::all());
		return json_encode($dailyReport);		
	}

	public function dailyHumidityReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->getHumidityReport(Input::all());
		return json_encode($dailyReport);			
	}

	public function WeeklyBodyWeightReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->getBodyWeightReport(Input::all());
		return json_encode($dailyReport);				
	}

	public function getWeightGainPerDay(){
		$reportObj = new Report;
		$dailyReport = $reportObj->getBodyWeightGainPerDayReport(Input::all());
		return json_encode($dailyReport);				
	}

	public function weeklyReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->getWeeklyReport(Input::all());
		return json_encode($dailyReport);	
	}

	public function weeklyWindVelocityReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->getWeeklyWindVelocityReport(Input::all());
		return json_encode($dailyReport);	
	}

	public function consolidatedDailyReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->getConsolidatedDailyReport(Input::all());
		return json_encode($dailyReport);		
	}

	public function titerReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->getTitersReport(Input::all());
		return json_encode($dailyReport);			
	}

	public function consolidatedWeeklyReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->getConsolidatedWeeklyReport(Input::all());
		return json_encode($dailyReport);			
	}

	public function flockComparisonReporting(){
		$reportObj = new Report;
		$dailyReport = $reportObj->getComparativeReport(Input::all());
		return json_encode($dailyReport);				
	}

	public function titerComparisonReporting(){
		$reportObj = new Report;
		$dailyReport = $reportObj->getComparativeTiterReport(Input::all());
		return json_encode($dailyReport);					
	}
	public function getEggsPerHenHousedReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->getEggsPerHenHousedReport(Input::all());
		return json_encode($dailyReport);						
	}

	public function commulativeMortalityReport(){
		$reportObj = new Report;
		$dailyReport = $reportObj->fetchCommulativeMortalityData(Input::all());
		return json_encode($dailyReport);							
	}

	public function getPeriodicalReportsData(){
		$reportObj = new Report;
		$dailyReport = $reportObj->fetchPeriodicalReportsData(Input::all());
		return json_encode($dailyReport);								
	}

	public function commulativeWeeklyFeedComp() {
		$reportObj = new Report;
		$dailyReport = $reportObj->commulativeWeeklyFeedComp(Input::all());
		return json_encode($dailyReport);									
	}

	public function commulativeFeedCompFlock () {
		$reportObj = new Report;
		$dailyReport = $reportObj->commulativeFeedCompFlock(Input::all());
		return json_encode($dailyReport);									
	}

	public function comparisonFeedPerEgg () {
		$reportObj = new Report;
		$dailyReport = $reportObj->comparisonFeedPerEgg(Input::all());
		return json_encode($dailyReport);									
	}

	public function compCommulativeDailyMortality () {
		$reportObj = new Report;
		$dailyReport = $reportObj->compCommulativeDailyMortality(Input::all());
		return json_encode($dailyReport);									
	}

	public function compEggPerHenHoused () {
		$reportObj = new Report;
		$dailyReport = $reportObj->compEggPerHenHoused(Input::all());
		return json_encode($dailyReport);									
	}

	public function compBodyWeight () {
		$reportObj = new Report;
		$dailyReport = $reportObj->compBodyWeight(Input::all());
		return json_encode($dailyReport);									
	}

}
