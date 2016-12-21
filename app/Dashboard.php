<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use \App\Flock;
use \App\User;
use \App\Dailyfeeding;
use \App\Flockstandards;
use \App\Disease;
use \App\Mortalityreasons;
use \App\Titer;
use Validator, DB,Session;
use Sentry;


class Dashboard extends Model {
	private $flocks, $user, $dailyFeeding, $standards,$titers;

	public function getFlocksData(){
		$this->flocks = New Flock;
		$this->user = New User;
		$this->dailyFeeding = New Dailyfeeding;
		$this->standards = New Flockstandards;
		$this->titers = New Titer;

		$flocks = $returnArray = array();
		if(!Sentry::getUser()->hasAccess('manage_flocks') ) {
			$flocks= $this->flocks->where('flocks.status','=','1')->join('users','users.id','=','flocks.user_id')->get(); //->where('flocks.user_id','=',Session::get('userId'))
		} else {
			$flocks= $this->flocks->where('flocks.status','=','1')->join('users','users.id','=','flocks.user_id')->get();
		}
		$returnArray['flocks'] = $flocks;

		//call for get data for each flocks
		if($flocks){
			foreach($flocks as $flock){
					$flockId = $flock->flock_id;
					$array['flock'] = $flockId;
					$array['dateFrom'] = date('Y-m-d', strtotime('-30 days'));
					$array['dateTo'] = date('Y-m-d', time());
					$array['options']= array(0=>'feed_per_bird', 1=>'feed_egg_production', 2=>'feed_temprature',3=>'feed_humidity',4=>'feed_mortality',5=>'feed_egg_weight',6=>'feed_water_consumption');
					//dateTo
					$dailyConsolidated = $this->getConsolidatedDailyReport($array);
					$weeklyConsolidated = $this->getConsolidatedWeeklyReport($array);
					/*$feed_per_bird= $this->dailyFeeding->where('entry_date','>=',date('Y-m-d', strtotime('-30 days')))->where('entry_date','<=',date('Y-m-d', time()))->where('status','=','1')->where('flock_id','=',$flockId)->where('field_name','=','feed_per_bird')->get();
		
					$water_consumption = $this->dailyFeeding->where('entry_date','>=',date('Y-m-d', strtotime('-30 days')))->where('entry_date','<=',date('Y-m-d', time()))->where('status','=','1')->where('flock_id','=',$flockId)->where('field_name','=','feed_water_consumption')->get();
					
					$mortality = $this->dailyFeeding->where('entry_date','>=',date('Y-m-d', strtotime('-30 days')))->where('entry_date','<=',date('Y-m-d', time()))->where('status','=','1')->where('flock_id','=',$flockId)->where('field_name','=','feed_mortality')->get();

					$humidity = $this->dailyFeeding->where('entry_date','>=',date('Y-m-d', strtotime('-30 days')))->where('entry_date','<=',date('Y-m-d', time()))->where('status','=','1')->where('dailyfeeding.flock_id','=',$flockId)->where('field_name','=','feed_humidity')->join('humidity_details','humidity_details.feed_id','=','dailyfeeding.feed_id')->get();

					$egg_weight = $this->dailyFeeding->where('entry_date','>=',date('Y-m-d', strtotime('-30 days')))->where('entry_date','<=',date('Y-m-d', time()))->where('status','=','1')->where('flock_id','=',$flockId)->where('field_name','=','feed_egg_weight')->get();
					
					$egg_production = $this->dailyFeeding->where('entry_date','>=',date('Y-m-d', strtotime('-30 days')))->where('entry_date','<=',date('Y-m-d', time()))->where('status','=','1')->where('flock_id','=',$flockId)->where('field_name','=','feed_egg_production')->get();
					
					$feed_temprature = $this->dailyFeeding->where('entry_date','>=',date('Y-m-d', strtotime('-30 days')))->where('entry_date','<=',date('Y-m-d', time()))->where('status','=','1')->where('dailyfeeding.flock_id','=',$flockId)->where('field_name','=','feed_temprature')->join('temperature_details', 'temperature_details.feed_id','=','dailyfeeding.feed_id')->get();

					$mortality_details=DB::table('mortality_details')
													->where('mortality_details.flock_id','=',$flockId)
													->join('mortality_reasons','mortality_reasons.id','=','mortality_details.reason_id')
													->get(); */
					//$mortality_details = $this->arrangeResultSet($mortality_details);
					
					/*$diseasesObj = New Mortalityreasons;
					$reasons = $diseasesObj->where('status','=',1)->get();

					// weekly Data fetch
					$bodyWeight= $this->dailyFeeding->where('entry_date','>=','NOW() - INTERVAL 30 DAY')->where('entry_date','<=','NOW()')->where('flock_id','=',$flockId)->where('field_name','=','body_weight')->get();
					$uniformity = $this->dailyFeeding->where('flock_id','=',$flockId)->where('field_name','=','uniformity')->get();
					$manureRemoval = $this->dailyFeeding->where('entry_date','>=','NOW() - INTERVAL 30 DAY')->where('entry_date','<=','NOW()')->where('flock_id','=',$flockId)->where('field_name','=','manure_removal')->get();
					$LightIntensity = $this->dailyFeeding->where('entry_date','>=','NOW() - INTERVAL 30 DAY')->where('entry_date','<=','NOW()')->where('flock_id','=',$flockId)->where('field_name','=','light_intensity')->get();
					$windVelocity = $this->dailyFeeding->where('entry_date','>=',date('Y-m-d', strtotime('-30 days')))->where('entry_date','<=',date('Y-m-d', time()))->where('flock_id','=',$flockId)->where('field_name','=','wind_velocity')->get();

					$flock = $this->flocks->where('flock_id','=',$flockId)->first();
					//calculate flock age
					$age_of_week = DB::table('flocks')->where('flock_id','=',$flockId)->select(DB::raw('CEIL(DATEDIFF(DATE(NOW()),DATE(arrival_date))/7) as bird_age'))->first();
					//Titers*/
					$titers = $this->titers->where('date','>=',date('Y-m-d', strtotime('-30 days')))
								->where('date','<=',date('Y-m-d', time()))->where('flock_id','=',$flockId)
								->join('diseases','diseases.disease_id','=','titers.disease_id')
								->select('titers.*','diseases.disease_name')
								->get();
								
					// preparing data for return 
					$flockData = array(
								// 'feed_per_bird'=>$feed_per_bird,
								// 'water_consumption' => $water_consumption,
								// 'egg_weight' =>$egg_weight,
								// 'egg_production'=>$egg_production,
								// 'feed_temprature'=>$feed_temprature,
								// 'age_of_week' =>$age_of_week,
								// 'mortality'=>$mortality,
								// 'humidity' => $humidity,
								// 'reasons' => $reasons,
								//'standards' =>$standards,
								// 'body_weight'=>$bodyWeight,
								// 'uniformity' => $uniformity,
								// 'manure_removal' =>$manureRemoval,
								// 'light_intensity'=>$LightIntensity,
								// 'wind_velocity'=>$windVelocity,
								// 'age_of_week' =>$age_of_week,
								'dailyConsolidated' => $dailyConsolidated,
								'weeklyConsolidated'=> $weeklyConsolidated,
								'titers' => $titers

							);
					$returnArray['flock_ids'][$flockId] = $flockData;
			}
			return $returnArray;
		} //endif flocks


	}

	public function getTodayRecord($field){
		$fields = array(0=>'feed_per_bird', 1=>'feed_egg_production', 2=>'feed_temprature',3=>'feed_humidity',4=>'feed_mortality',5=>'feed_egg_weight',6=>'feed_water_consumption', 7=>'body_weight', 8=>'uniformity', 9=>'manure_removal', 10=>'light_intensity',11=>'wind_velocity');
		$standards = array(0=>'feed', 1=>'egg_production', 2=>'temprature',3=>'humidity',4=>'mortality',5=>'egg_weight',6=>'water_consumption', 7=>'body_weight', 8=>'uniformity', 9=>'manure_removal', 10=>'light_intensity',11=>'wind_velocity');

		$rows = DB::table('dailyfeeding')->where('entry_date','=', date("Y-m-d", time()))
										->where('field_name','=',$fields[$field])
										->where('key','=',$fields[$field])
										->join('flock_tolerance_ranges','flock_tolerance_ranges.flock_id','=','dailyfeeding.flock_id')
										->get();
		return $rows;	
	}

	public function getConsolidatedDailyReport($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();

		$options = $postData;
		$reportObj = DB::table('dailyfeedreport')->orderBy('Entry_date','asc')->where('flock_id','=',$postData['flock']);

		if(!isset($options['fetchAll'])){
			$reportObj->where("Entry_date",'>=',$postData['dateFrom']);
			$reportObj->where("Entry_date",'<=',$postData['dateTo']);
		}
		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		if($results) {
			foreach($results as $result){
				$datetime1 = date_create($flock->arrival_date);
                $datetime2 = date_create($result->Entry_date);
                $interval = date_diff($datetime1, $datetime2);

				$returnRow=array();
				$returnRow['entry_date'] = $result->Entry_date;
				$returnRow['bird_age_week'] = $result->bird_age_week;
				$returnRow['bird_age_day'] = $interval->format('%a')+1;
				$dailyEntries = explode(",",$result->Name_exp_5);
				$rowEntries=array();
				if($dailyEntries){
					foreach($dailyEntries as $entry){
						$chunks=!empty($entry) ? explode(":",$entry) : array();
						if(isset($chunks[0]) && !empty($chunks[0])) {
							$rowEntries[$chunks[0]] = isset($chunks[1]) ? $chunks[1] : '__';
						}
					}
				}
				//now dumping vlaues for the fields sent from front end.
				foreach($postData['options'] as $option){
					$tempVar = isset($rowEntries[$option]) && !empty($rowEntries[$option]) ?  explode("__", $rowEntries[$option]) : array("N/A","N/A");
					$returnRow['standard_'.$option] = $tempVar[1];
					$returnRow[$option] = $tempVar[0];
				}
				$returnRow_comp['data'][] = $returnRow;
			}	
		} else {
			$returnRow_comp['data']=array();
		}
		
		return $returnRow_comp;
	}

	public function getConsolidatedWeeklyReport($postData){

		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();

		$options = $postData;
		$flockArrival = strtotime($flock->arrival_date);
		$curr=0;
		$startDate = $postData['dateFrom'];//strtotime($flock->arrival_date);
		$limitDate = $postData['dateTo'];//strtotime(date("Y-m-d"));
		$returnRows=array();
		while($limitDate > $flockArrival){
			$returnRow = array();		
			$next = $curr+7;	 
			$weekStart = $curr != 0 ? strtotime("+".(int)$curr." day", strtotime($startDate)) : strtotime($startDate);

			$weekEnd = strtotime("+".(int)$next." day", strtotime($startDate));

			$datetime1 = date_create($flock->arrival_date);
            $datetime2 = date_create(date("Y-m-d",$weekEnd));
            $interval = date_diff($datetime1, $datetime2);
			
			$returnRow['entry_date'] = date("Y-m-d",$weekEnd);
			$returnRow['bird_age_week'] = ceil( ($interval->format('%a')+1) / 7 );
			//Weekly Feed
			$WeeklyFeed = DB::table('dailyfeeding')->where('flock_id','=',$postData['flock'])
									->where('entry_date','>=',$weekStart)
									->where('entry_date','<=', $weekEnd)
									->where('field_name','=','feed_per_bird')
									->selectRaw('dailyfeeding.*,sum(field_value)/7 as weekly_feed, sum(standard_value)/7 as standard_feed')
									->first();
			//Weekly Water Consumption
			$WeeklyWater = DB::table('dailyfeeding')->where('flock_id','=',$postData['flock'])
									->where('entry_date','>=',$weekStart)
									->where('entry_date','<=', $weekEnd)
									->where('field_name','=','feed_water_consumption')
									->selectRaw('dailyfeeding.*, sum(field_value)/7 as weekly_feed, sum(standard_value)/7 as standard_feed')
									->first();

			//Weekly Mortalities
			$WeeklyMortality = DB::table('dailyfeeding')->where('flock_id','=',$postData['flock'])
									->where('entry_date','>=',$weekStart)
									->where('entry_date','<=', $weekEnd)
									->where('field_name','=','feed_mortality')
									->selectRaw('dailyfeeding.*, sum(field_value) as weekly_feed, sum(standard_value) as standard_feed')
									->first();

			//weekly Egg Productions
			$WeeklyEggProduction = DB::table('dailyfeeding')->where('flock_id','=',$postData['flock'])
									->where('entry_date','>=',$weekStart)
									->where('entry_date','<=', $weekEnd)
									->where('field_name','=','feed_egg_production')
									->selectRaw('dailyfeeding.*, sum(field_value)/7 as weekly_feed, sum(standard_value)/7 as standard_feed')
									->first();
			//weekly Egg Weight
			$WeeklyEggWeight = DB::table('dailyfeeding')->where('flock_id','=',$postData['flock'])
									->where('entry_date','>=',$weekStart)
									->where('entry_date','<=', $weekEnd)
									->where('field_name','=','feed_egg_weight')
									->selectRaw('dailyfeeding.*, sum(field_value)/7 as weekly_feed, sum(standard_value)/7 as standard_feed')
									->first();
			//Egg hen Housed

			//Body Weight
			$WeeklyBodyWeight = DB::table('dailyfeeding')->where('flock_id','=',$postData['flock'])
						->where('entry_date','=', $weekEnd)
						->where('field_name','=','body_weight')
						->selectRaw('dailyfeeding.*, field_value as weekly_feed, standard_value as standard_feed')
						->first();	
						//var_dump($WeeklyBodyWeight);
			//Manure Removal
			$WeeklyManure = DB::table('dailyfeeding')->where('flock_id','=',$postData['flock'])
						->where('entry_date','=', $weekEnd)
						->where('field_name','=','manure_removal')
						->selectRaw('dailyfeeding.*,field_value as weekly_feed, standard_value as standard_feed')
						->first();
			//Light Intensity
			$WeeklyLight = DB::table('dailyfeeding')->where('flock_id','=',$postData['flock'])
						->where('entry_date','=', $weekEnd)
						->where('field_name','=','light_intensity')
						->selectRaw('dailyfeeding.*,field_value as weekly_feed, standard_value as standard_feed')
						->first();
			//Wind Velocity
			$WeeklyWind = DB::table('dailyfeeding')->where('flock_id','=',$postData['flock'])
						->where('entry_date','=', $weekEnd)
						->where('field_name','=','wind_velocity')
						->selectRaw('dailyfeeding.*,field_value as weekly_feed, standard_value as standard_feed')
						->first();
			//setting up return data
			$returnRow['standard_feed_per_bird'] = isset($WeeklyFeed->standard_feed) ? $WeeklyFeed->standard_feed : '-' ;
			$returnRow['feed_per_bird'] = isset($WeeklyFeed->weekly_feed) ? $WeeklyFeed->weekly_feed : '-' ;
			$returnRow['standard_feed_water_consumption'] = isset($WeeklyWater->standard_feed) ? $WeeklyWater->standard_feed : '-' ;
			$returnRow['feed_water_consumption'] = isset($WeeklyWater->weekly_feed) ? $WeeklyWater->weekly_feed : '-' ;
			$returnRow['standard_feed_mortality'] = isset($WeeklyMortality->standard_feed) ? $WeeklyMortality->standard_feed  : '-';
			$returnRow['feed_mortality'] = isset($WeeklyMortality->weekly_feed) ? $WeeklyMortality->weekly_feed : '-';
			$returnRow['standard_feed_egg_production'] = isset($WeeklyEggProduction->standard_feed) ? $WeeklyEggProduction->standard_feed : '-';
			$returnRow['feed_egg_production'] = isset($WeeklyEggProduction->weekly_feed) ? $WeeklyEggProduction->weekly_feed : '-';
			$returnRow['standard_feed_egg_housed']  = 'N/A' ;
			$returnRow['feed_egg_housed'] = 'N/A';
			$returnRow['standard_feed_egg_weight'] = isset($WeeklyEggWeight->standard_feed) ? $WeeklyEggWeight->standard_feed : '-' ;
			$returnRow['feed_egg_weight'] = isset($WeeklyEggWeight->weekly_feed) ? $WeeklyEggWeight->weekly_feed : '-';
			$returnRow['standard_body_weight'] = isset($WeeklyBodyWeight->standard_feed) ? $WeeklyBodyWeight->standard_feed :'-' ;
			$returnRow['body_weight'] = isset($WeeklyBodyWeight->weekly_feed) ? $WeeklyBodyWeight->weekly_feed : '-';
			$returnRow['standard_manure_removal'] = isset($WeeklyManure->standard_feed) ? $WeeklyManure->standard_feed : '-';
			$returnRow['manure_removal'] = isset($WeeklyManure->weekly_feed) ? $WeeklyManure->standard_feed : '-';
			$returnRow['standard_light_intensity'] = isset($WeeklyLight->standard_feed) ? $WeeklyLight->standard_feed : '-';
			$returnRow['light_intensity'] = isset($WeeklyLight->weekly_feed) ? $WeeklyLight->weekly_feed : '-';
			$returnRow['standard_wind_velocity'] = isset($WeeklyWind->standard_feed) ? $WeeklyWind->standard_feed : '-';
			$returnRow['wind_velocity'] = isset($WeeklyWind->weekly_feed) ? $WeeklyWind->weekly_feed : '-';

			$returnRows[] = $returnRow;
			$curr= $curr+7;
			$flockArrival = strtotime('+'.(int)$curr.' day', strtotime($startDate));
		}
		
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
	
		return $returnRow_comp;
	}

}
