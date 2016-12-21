<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator, DB;


class Report extends Model {

	//use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = '';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = ['password', 'remember_token'];
	protected $primaryKey = '';

	public $errors;

	public $timestamps = false;
	
	public static $rules = array();

	 /* The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	

	/*
	*	Funciton is responsibile to validate the form Data
	*/

	public function fetchDailyReportData($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();

		$options = $postData;
		$reportObj = DB::table('dailyfeeding')->orderBy('Entry_date','asc')->where('field_name','=',$postData['options'][0])->where('flock_id','=',$postData['flock']);

		// if(!$options['fetchAll']){
		// 	$reportObj->where("Entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("Entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    } else if ($postData['recordType'] =='date_range'){
	    	
				$reportObj->where("entry_date",'>=',$postData['dateFrom']);
				$reportObj->where("entry_date",'<=',$postData['dateTo']);
			
	    }
		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		if($results) {
			foreach($results as $result){
				$datetime1 = date_create($flock->arrival_date);
                $datetime2 = date_create($result->entry_date);
                $interval = date_diff($datetime1, $datetime2);

				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = $result->bird_age_week;
				$returnRow['bird_age_day'] = $interval->format('%a')+1;
				$returnRow[$result->field_name] = $result->field_value;
				$returnRow['standard_'.$result->field_name] = $result->standard_value;
				// $dailyEntries = explode(",",$result->Name_exp_5);
				// $rowEntries=array();
				// if($dailyEntries){
				// 	foreach($dailyEntries as $entry){
				// 		$chunks=!empty($entry) ? explode(":",$entry) : array();
				// 		if(isset($chunks[0]) && !empty($chunks[0])) {
				// 			$rowEntries[$chunks[0]] = isset($chunks[1]) ? $chunks[1] : '__';
				// 		}
				// 	}
				// }
				// //now dumping vlaues for the fields sent from front end.
				// foreach($postData['options'] as $option){
				// 	$tempVar = isset($rowEntries[$option]) && !empty($rowEntries[$option]) ?  explode("__", $rowEntries[$option]) : array("N/A","N/A");
				// 	$returnRow['standard_'.$option] = $tempVar[1];
				// 	$returnRow[$option] = $tempVar[0];
				// }
				$returnRow_comp['data'][] = $returnRow;
			}	
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;
	}

	public function fetchFeedEggData($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();
		$options = $postData;
		$reportObj = DB::table('dailyfeeding')->orderBy('entry_date','asc')->where('field_name','=',$postData['options'][0])->where('flock_id','=',$postData['flock']);

		// if(!$options['fetchAll']){
		// 	$reportObj->where("Entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("Entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
				$reportObj->where("entry_date",'>=',$postData['dateFrom']);
				$reportObj->where("entry_date",'<=',$postData['dateTo']);
			
	    }

		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		$count=1;
		$standardValue=$actualValue=0;
		if($results) {
			foreach($results as $result){
				$datetime1 = date_create($flock->arrival_date);
                $datetime2 = date_create($result->entry_date);
                $interval = date_diff($datetime1, $datetime2);
                
				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = ceil($count/7);
				$returnRow['bird_age_day'] = $interval->format('%a')+1;
				$eggProduction = DB::table("dailyfeeding")->where('flock_id','=',$postData['flock'])
															->where('field_name','=',$postData['options'][0])
															->where('entry_date','=',$result->entry_date)
															->first();
				if($eggProduction){
					$returnRow['standard_feed_per_bird'] = $eggProduction->standard_value != 0 ? number_format($result->standard_value/$eggProduction->standard_value,2,'.',',') : 0;
					$returnRow['feed_per_bird'] = $eggProduction->field_value != 0 ? number_format($result->field_value/$eggProduction->field_value,2,'.',',') : 0;
				} else{
					$returnRow['standard_feed_per_bird'] = 0;
					$returnRow['feed_per_bird'] = 0;
				}		
				$returnRow_comp['data'][] = $returnRow;
				$count++;
			}	
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;
	}

	/***************************/
	public function fetchCommulativeMortalityData($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();
		$options = $postData;
		$reportObj = DB::table('dailyfeeding')->orderBy('entry_date','asc')->where('field_name','=','feed_mortality')->where('flock_id','=',$postData['flock']);

		// if(!$options['fetchAll']){
		// 	$reportObj->where("entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
				$reportObj->where("entry_date",'>=',$postData['dateFrom']);
				$reportObj->where("entry_date",'<=',$postData['dateTo']);
			
	    }
		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		$count=1;
		$standardValue=$actualValue=0;
		$standardValueCom=$actualValueCom=0;
		if($results) {
			foreach($results as $result){
				$datetime1 = date_create($flock->arrival_date);
                $datetime2 = date_create($result->entry_date);
                $interval = date_diff($datetime1, $datetime2);

				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = ceil($count/7);
				$returnRow['bird_age_day'] = $interval->format('%a')+1;
				$standardValueCom = $standardValueCom+$result->standard_value;
				$actualValueCom = $actualValueCom+$result->field_value;
				if($count%7 == 1 ){
					$standardValue = $result->standard_value;
					$actualValue = $result->field_value;					
				} else{
					$standardValue 	= $standardValue+$result->standard_value;
					$actualValue	= $actualValue + $result->field_value;
				}
				$returnRow['standard_feed_mortality'] = $standardValue;
				$returnRow['feed_mortality'] = $actualValue;
				$returnRow['standard_feed_mortality_com'] = $standardValueCom;
				$returnRow['feed_mortality_com'] = $actualValueCom;
				
				$returnRow_comp['data'][] = $returnRow;
				$count++;
			}	
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;
	}


	/***************************/
	public function fetchCommulativeWeekReportData($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();
		$options = $postData;
		$reportObj = DB::table('dailyfeeding')->orderBy('entry_date','asc')->where('field_name','=','feed_per_bird')->where('flock_id','=',$postData['flock']);

		// if(!$options['fetchAll']){
		// 	$reportObj->where("entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
			$reportObj->where("entry_date",'>=',$postData['dateFrom']);
			$reportObj->where("entry_date",'<=',$postData['dateTo']);
			
	    }
		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		$count=1;
		$standardValue=$actualValue=0;
		if($results) {
			foreach($results as $result){
				$datetime1 = date_create($flock->arrival_date);
                $datetime2 = date_create($result->entry_date);
                $interval = date_diff($datetime1, $datetime2);

				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = ceil($count/7);
				$returnRow['bird_age_day'] = $interval->format('%a')+1;
				if($count%7 == 1 ){
					$standardValue = $result->standard_value;
					$actualValue = $result->field_value;					
				} else{
					$standardValue 	= $standardValue+$result->standard_value;
					$actualValue	= $actualValue + $result->field_value;
				}
				$returnRow['standard_feed_per_bird'] = $standardValue;
				$returnRow['feed_per_bird'] = $actualValue;
				
				$returnRow_comp['data'][] = $returnRow;
				$count++;
			}	
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;
	}

	public function getEggsPerHenHousedReport($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();
		$options = $postData;
		$arrival_date = strtotime($flock->arrival_date);
		$week19Daye =strtotime("+19 week", $arrival_date);
		$diedBird = DB::table('dailyfeeding')->where('flock_id','=',$postData['flock'])->where('field_name','=','feed_mortality')->where('entry_date','<',date("Y-m-d",$week19Daye))->sum('field_value');
		$standardDiedBird = DB::table('dailyfeeding')->where('flock_id','=',$postData['flock'])->where('field_name','=','feed_mortality')->where('entry_date','<',date("Y-m-d",$week19Daye))->sum('standard_value');
		$birdsAt19Week = $flock->batch_size-$diedBird;
		$standard19Week=$flock->batch_size-$standardDiedBird;
		$reportObj = DB::table('dailyfeeding')->orderBy('entry_date','asc')->where('entry_date','>=',date("y-m-d",$week19Daye))->where('flock_id','=',$postData['flock'])->where('field_name','=','feed_egg_production');

		// if(!$options['fetchAll']){
		// 	$reportObj->where("Entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("Entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
				$reportObj->where("entry_date",'>=',$postData['dateFrom']);
				$reportObj->where("entry_date",'<=',$postData['dateTo']);
			
	    }
		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		$count=1;
		$standardValue=$actualValue=0;
		if($results) {
			foreach($results as $result){
				$datetime1 = date_create($flock->arrival_date);
                $datetime2 = date_create($result->entry_date);
                $interval = date_diff($datetime1, $datetime2);

				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = ceil($count/7);
				
				if($count%7 == 0 ){
					$standardValue 	= $standardValue+$result->standard_value;
					$actualValue	= $actualValue + $result->field_value;
					$returnRow['standard_feed_per_bird'] = $standardValue/$standard19Week;
					$returnRow['feed_per_bird'] = $actualValue/$birdsAt19Week;
					$standardValue=$actualValue=0;					
					
					$returnRow_comp['data'][] = $returnRow;
				} else if ($count%7 == 1 ){
					$standardValue = $result->standard_value;
					$actualValue = $result->field_value;
				} else{
					$standardValue 	= $standardValue+$result->standard_value;
					$actualValue	= $actualValue + $result->field_value;
				}
				$count++;
			}	
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRow_comp['data']);
		$returnRow_comp['recordsTotal'] = count($returnRow_comp['data']);
		return $returnRow_comp;
	}
	
	public function fetchCommulativeFlockReportData($postData){
		$options = $postData;
		//fetch Flock Record to calculate week and age of flock
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();

		$reportObj = DB::table('dailyfeeding')->orderBy('entry_date','asc')->where('flock_id','=',$postData['flock'])->where('field_name','=','feed_per_bird');

		// if(!$options['fetchAll']){
		// 	$reportObj->where("entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
			$reportObj->where("entry_date",'>=',$postData['dateFrom']);
			$reportObj->where("entry_date",'<=',$postData['dateTo']);
			
	    }
		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		if($results) {
			$standardSum=$valueSum=0;
			foreach($results as $result){
				$datetime1 = date_create($flock->arrival_date);
                $datetime2 = date_create($result->entry_date);
                $interval = date_diff($datetime1, $datetime2);
                $valueSum = $valueSum+$result->field_value;
                $standardSum = $standardSum+$result->standard_value;
				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = $result->bird_age_week;
				$returnRow['bird_age_day'] = $interval->format('%a')+1;
				$returnRow['standard_feed_per_bird'] = number_format($standardSum/1000,'2','.',',');
				$returnRow['feed_per_bird'] = number_format($valueSum/1000,'2','.',',');
				//assigning values to parent array
				$returnRow_comp['data'][] = $returnRow;
			}	
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;
	}

	public function fetchFeedPerBirdData($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();

		$options = $postData;
		$reportObj = DB::table('dailyfeeding')->orderBy('entry_date','asc')->where('field_name','=',$postData['options'][0])->where('flock_id','=',$postData['flock']);

		// if(!$options['fetchAll']){
		// 	$reportObj->where("Entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("Entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
			$reportObj->where("entry_date",'>=',$postData['dateFrom']);
			$reportObj->where("entry_date",'<=',$postData['dateTo']);
		
	    }
		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		if($results) {
			foreach($results as $result){
				$datetime1 = date_create($flock->arrival_date);
                $datetime2 = date_create($result->entry_date);
                $interval = date_diff($datetime1, $datetime2);

				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = $result->bird_age_week;
				$returnRow['bird_age_day'] = $interval->format('%a')+1;
				$returnRow[$result->field_name] = $result->field_value;
				$resurnRow['standard_'.$result->field_name] = $result->standard_value;

				// $dailyEntries = explode(",",$result->Name_exp_5);
				// $rowEntries=array();
				// if($dailyEntries){
				// 	foreach($dailyEntries as $entry){
				// 		$chunks=!empty($entry) ? explode(":",$entry) : array();
				// 		if(isset($chunks[0]) && !empty($chunks[0])) {
				// 			$rowEntries[$chunks[0]] = isset($chunks[1]) ? $chunks[1] : '__';
				// 		}
				// 	}
				// }
				// //now dumping vlaues for the fields sent from front end.
				// foreach($postData['options'] as $option){
				// 	$tempVar = isset($rowEntries[$option]) && !empty($rowEntries[$option]) ?  explode("__", $rowEntries[$option]) : array("N/A","N/A");
				// 	$returnRow['standard_'.$option] = $tempVar[1];
				// 	$returnRow[$option] = $tempVar[0];
				// }
				$returnRow_comp['data'][] = $returnRow;
			}	
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;	
	}

	public function fetchDailyMortalityData($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();
		$options = $postData;
		$reportObj = DB::table('dailyfeeding')->orderBy('entry_date','asc')->where('flock_id','=',$postData['flock'])->where('field_name','=','feed_mortality');

		// if(!$options['fetchAll']){
		// 	$reportObj->where("entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
			$reportObj->where("entry_date",'>=',$postData['dateFrom']);
			$reportObj->where("entry_date",'<=',$postData['dateTo']);
		
	    }
		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		if($results) {
			foreach($results as $result){
				$datetime1 = date_create($flock->arrival_date);
                $datetime2 = date_create($result->entry_date);
                $interval = date_diff($datetime1, $datetime2);
                
				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = $result->bird_age_week;
				$returnRow['bird_age_day'] = $interval->format('%a')+1;
				$returnRow['standard_feed_mortality'] = $result->standard_value;
				$returnRow['feed_mortality'] = $result->field_value;
				$mortality_details=DB::table('mortality_reasons')
								->where('mortality_details.flock_id','=',$result->flock_id)
								->where('mortality_details.feed_id','=',$result->feed_id)
								->where('mortality_reasons.status','=','1')
								->leftJoin('mortality_details','mortality_reasons.id','=','mortality_details.reason_id')
								->select('mortality_details.no_of_birds',"mortality_reasons.id as reason_id")
								->get();
				foreach($mortality_details as $row){
					$returnRow['reason_'.$row->reason_id] = $row->no_of_birds;
				}
				//assigning values to parent array
				$returnRow_comp['data'][] = $returnRow;
			}	
		} else{
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;

	}

	public function getTemprateReport($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();
		$options = $postData;
		$reportObj = DB::table('dailyfeeding')->orderBy('entry_date','asc')->where('dailyfeeding.flock_id','=',$postData['flock'])->where('field_name','=','feed_temprature');

		// if(!$options['fetchAll']){
		// 	$reportObj->where("entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
			$reportObj->where("entry_date",'>=',$postData['dateFrom']);
			$reportObj->where("entry_date",'<=',$postData['dateTo']);
		
	    }
		$reportObj->leftjoin('temperature_details','temperature_details.feed_id','=','dailyfeeding.feed_id');
		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		if($results) {
			foreach($results as $result){
				$datetime1 = date_create($flock->arrival_date);
                $datetime2 = date_create($result->entry_date);
                $interval = date_diff($datetime1, $datetime2);
                
				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = $result->bird_age_week;
				$returnRow['bird_age_day'] = $interval->format('%a')+1;
				$returnRow['standard_feed_temprature'] = $result->standard_value;
				$returnRow['feed_temprature'] = $result->field_value;
				$returnRow['feeling'] = $result->feeling;
				$returnRow['lowest_inner'] = $result->inner_min;
				$returnRow['highest_inner'] = $result->inner_max;
				$returnRow['highest_outter'] = $result->outter_max;
				$returnRow['lowest_outter'] = $result->outter_min;
				
				//assigning values to parent array
				$returnRow_comp['data'][] = $returnRow;
			}	
		} else{
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;

	}

	public function getHumidityReport($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();
		$options = $postData;
		$reportObj = DB::table('dailyfeeding')->orderBy('entry_date','asc')->where('dailyfeeding.flock_id','=',$postData['flock'])->where('field_name','=','feed_humidity');

		// if(!$options['fetchAll']){
		// 	$reportObj->where("entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
			$reportObj->where("entry_date",'>=',$postData['dateFrom']);
			$reportObj->where("entry_date",'<=',$postData['dateTo']);
		
	    }
		$reportObj->leftjoin('humidity_details','humidity_details.feed_id','=','dailyfeeding.feed_id');
		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		if($results) {
			foreach($results as $result){
				$datetime1 = date_create($flock->arrival_date);
                $datetime2 = date_create($result->entry_date);
                $interval = date_diff($datetime1, $datetime2);
                
				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = $result->bird_age_week;
				$returnRow['bird_age_day'] = $interval->format('%a')+1;
				$returnRow['standard_feed_humidity'] = $result->standard_value;
				$returnRow['feed_humidity'] = $result->inner_humidity;
				$returnRow['outter_humidity'] = $result->outter_humidity;
				
				//assigning values to parent array
				$returnRow_comp['data'][] = $returnRow;
			}	
		} else{
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;
	}

	public function getBodyWeightReport($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();
		$options = $postData;
		$reportObj = DB::table('dailyfeeding')->orderBy('entry_date','asc')->where('dailyfeeding.flock_id','=',$postData['flock'])->where('field_name','=','body_weight');

		// if(!$options['fetchAll']){
		// 	$reportObj->where("entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
			$reportObj->where("entry_date",'>=',$postData['dateFrom']);
			$reportObj->where("entry_date",'<=',$postData['dateTo']);
		
	    }

		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		if($results) {
			foreach($results as $result){
				$datetime1 = date_create($flock->arrival_date);
                $datetime2 = date_create($result->entry_date);
                $interval = date_diff($datetime1, $datetime2);
                
				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = $result->bird_age_week;
				$returnRow['standard_body_weight'] = $result->standard_value;
				$returnRow['body_weight'] = $result->field_value;
				$uniformity = DB::table('dailyfeeding')->where('dailyfeeding.flock_id','=',$postData['flock'])
														->where('field_name','=','uniformity')
														->where('entry_date','=',$result->entry_date)
														->first();
				$standardUniformity = $actualUniformity = 'N/A';
				if($uniformity){
					$standardUniformity =$uniformity->standard_value ;
					$actualUniformity = $uniformity->field_value;
				}
				$returnRow['standard_uniformity'] = $standardUniformity;
				$returnRow['uniformity'] = $actualUniformity;
				
				//assigning values to parent array
				$returnRow_comp['data'][] = $returnRow;
			}	
		} else{
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;
	}

	public function getBodyWeightGainPerDayReport($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();
		$options = $postData;
		$reportObj = DB::table('dailyfeeding')->orderBy('entry_date','asc')->where('dailyfeeding.flock_id','=',$postData['flock'])->where('field_name','=','body_weight');

		// if(!$options['fetchAll']){
		// 	$reportObj->where("entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
			$reportObj->where("entry_date",'>=',$postData['dateFrom']);
			$reportObj->where("entry_date",'<=',$postData['dateTo']);
		
	    }

		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		if($results) {
			$previousWeek = $standardPrev = 0;
			foreach($results as $result){
				
				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = $result->bird_age_week;
				$standardV = $result->standard_value - $standardPrev;
				$weightV =  $result->field_value - $previousWeek;
				$returnRow['standard_body_weight'] = number_format($standardV/7, '2','.',',');
				$returnRow['body_weight'] = number_format($weightV/7, '2','.',',');
				//assigning values to parent array
				$returnRow_comp['data'][] = $returnRow;
				$previousWeek = $result->field_value;
				$standardPrev = $result->standard_value;
			}	
		} else{
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;
	}

	public function getWeeklyReport($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();

		$options = $postData;
		$reportObj = DB::table('dailyfeeding')->orderBy('entry_date','asc')
											  ->where('flock_id','=',$postData['flock'])
											  ->where('field_name','=',$postData['options'][0]);

		// if(!$options['fetchAll']){
		// 	$reportObj->where("entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("entry_date",'<=',$postData['dateTo']);
		// }
											  /*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
				$reportObj->where("entry_date",'>=',$postData['dateFrom']);
				$reportObj->where("entry_date",'<=',$postData['dateTo']);
			
	    }
		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		if($results) {
			foreach($results as $result){
				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = $result->bird_age_week;
				$returnRow['standard_'.$options['options'][0]]=$result->standard_value;
				$returnRow[$options['options'][0]]=$result->field_value;
				$returnRow_comp['data'][] = $returnRow;
			}	
		} else{
			$returnRow_comp['data']=array();
		}

		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;
	}

	public function getWeeklyWindVelocityReport($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();

		$options = $postData;
		$reportObj = DB::table('dailyfeeding')->orderBy('entry_date','asc')->where('dailyfeeding.flock_id','=',$postData['flock'])->where('field_name','=','wind_velocity');

		// if(!$options['fetchAll']){
		// 	$reportObj->where("entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
			$reportObj->where("entry_date",'>=',$postData['dateFrom']);
			$reportObj->where("entry_date",'<=',$postData['dateTo']);
			
	    }

		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		if($results) {
			
			foreach($results as $result){
				$previousWeek = $standardPrev = 0;
				$birdWeight = DB::table('dailyfeeding')->where('flock_id','=',$postData['flock'])
														->where('field_name','=','body_weight')
														->where('entry_date','=',$result->entry_date)
														->first();
				$expiredBirds = DB::table('dailyfeeding')->where('flock_id','=',$postData['flock'])
														->where('field_name','=','feed_mortality')
														->where('entry_date','<=',$result->entry_date)
														->select(DB::raw("sum(field_value) as birds"))
														->first();
				$standardWind = ($flock->batch_size - $expiredBirds->birds) * $result->standard_value * $birdWeight->field_value;
				$actualWind = ($flock->batch_size - $expiredBirds->birds) * $result->field_value * $birdWeight->field_value;
				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['bird_age_week'] = $result->bird_age_week;
				$returnRow['standard_wind_velocity'] = number_format($standardWind,"2",'.',',');
				$returnRow['wind_velocity'] = number_format($actualWind,"2",'.',',');
				$standardV = $standardWind;
				$weightV =  $actualWind;
				
				//assigning values to parent array
				$returnRow_comp['data'][] = $returnRow;
			}	
		} else{
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;
	}

	public function getConsolidatedDailyReport($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();

		$options = $postData;
		$reportObj = DB::table('dailyfeedreport')->orderBy('Entry_date','asc')->where('flock_id','=',$postData['flock']);
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("Entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("Entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("Entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("Entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
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
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;
	}

	/*--------Titers Section ------- */

	public function getTitersReport($postData){
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();

		$options = $postData;
		$reportObj = DB::table('titers')->orderBy('date','asc')->where('flock_id','=',$postData['flock'])->where('disease_id','=',$postData['options']);

		// if(!$options['fetchAll']){
		// 	$reportObj->where("date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
				$reportObj->where("date",'>=',$postData['dateFrom']);
				$reportObj->where("date",'<=',$postData['dateTo']);
			
	    }
		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		if($results) {
			foreach($results as $result){
				$datetime1 = date_create($flock->arrival_date);
                $datetime2 = date_create($result->date);
                $interval = date_diff($datetime1, $datetime2);

				$returnRow=array();
				$returnRow['entry_date'] = $result->date;
				$returnRow['bird_age_week'] = ceil( ($interval->format('%a')+1) / 7 );
				$returnRow['lab_name'] = $result->lab_name;
				$returnRow['range'] = $result->range;
				$returnRow['average'] = number_format($result->average, '2','.',',');
				
				$returnRow_comp['data'][] = $returnRow;
			}	
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;

	}

	public function getConsolidatedWeeklyReport($postData){

		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();

		$options = $postData;
		$flockArrival = strtotime($flock->arrival_date);
		$curr=0;
		$startDate = strtotime($flock->arrival_date);
		$limitDate = strtotime(date("Y-m-d"));
		$returnRows=array();
		while($limitDate > $flockArrival){
			$returnRow = array();		
			$next = $curr+7;	 
			$weekStart = $curr != 0 ? strtotime("+$curr day", $startDate) : strtotime($startDate);
			$weekEnd = strtotime("+$next day", $startDate);

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
			$flockArrival = strtotime('+'.$curr.' day', $startDate);
		}
		
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}

	public function getComparativeReport($postData){
		/*
			"parameter":parameter, 
			"recordType":recordType,
			"compareDayFrom":compareDayFrom,
			"compareDayTo":compareDayTo, 
			"compareWeekFrom":compareWeekFrom, 
			"compareWeekEnd":compareWeekEnd,
			"dateFrom":dateFrom, 
			"dateTo":dateTo, 
			"flocks":flocks
		*/
		$returnData = '';
		if($postData['recordType'] == ""){
			$returnData = $this->getAllComparison($postData);
		} else if ($postData['recordType'] == 'days'){
			$returnData = $this->getSpecificDaysComparison($postData);
		} else if ($postData['recordType'] == 'weeks'){
			$returnData = $this->getSpecificWeeksComparisons($postData);
		} else if ($postData['recordType'] == 'date_range'){
			$returnData = $this->getDateRangesComparisons($postData);
		}

		return $returnData;
	}

	public function getAllComparison($postData){
		/*
			_token:"{{ csrf_token() }}",
			"parameter":parameter, 
			"flocks":flocks
		*/	
		$minDate = DB::table('dailyfeeding')->min('entry_date');
		//getting flock basic data
		// $flocksArray=array();
		// foreach($flocks as $flock){
		// 	$flocksArray[] = DB::table('flocks')->where('flock_id')->first();
		// }
		//end-----------
		$curDate = strtotime($minDate);
		$returnRows=array();
		$limitDate = strtotime(date("Y-m-d",time()));

		while($curDate <= $limitDate) {
			$today = date("Y-m-d", $curDate);

			$returnRow['entry_date'] = $today;
			foreach($postData['flocks'] as $flock){
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',$today)
													->where('flock_id','=',$flock)
													->where('field_name','=',$postData['parameter'])
													->first();
				if($flockData){
					$returnRow['standard_flock_'.$flock] = $flockData->standard_value;
					$returnRow['flock_'.$flock] = $flockData->field_value;
				} else{
					$returnRow['standard_flock_'.$flock] = '-';
					$returnRow['flock_'.$flock] = "-";
				}
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate = strtotime('+1 day', $curDate);
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;

	}

	public function getSpecificDaysComparison($postData){
		/*
			_token:"{{ csrf_token() }}",
			"parameter":parameter, 
			"compareDayFrom":compareDayFrom,
			"compareDayTo":compareDayTo, 
			"flocks":flocks
		*/

		//getting flock basic data
		$flocksArray=array();
		for($i=0; $i< count($postData['flocks']) ; $i++){
			$flockId = $postData['flocks'][$i];
			$flocksArray[] = DB::table('flocks')->where('flock_id','=',$flockId)->first();
		}

		//end-----------
		$curDate = $postData['compareDayFrom'];
		$returnRows=array();
		$limit = $postData['compareDayTo'];//strtotime(date("Y-m-d",time()));

		while($curDate <= $limit) {
			

			$returnRow['bird_age_day'] = $curDate;
			foreach($flocksArray as $flock){
				
				$addUp=$curDate-1;

				$today=strtotime("+$addUp day",strtotime($flock->arrival_date));
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',date("Y-m-d",$today))
													->where('flock_id','=',$flock->flock_id)
													->where('field_name','=',$postData['parameter'])
													->first();


				if($flockData){
					$returnRow['standard_flock_'.$flock->flock_id] = $flockData->standard_value;
					$returnRow['flock_'.$flock->flock_id] = $flockData->field_value;
				} else{
					$returnRow['standard_flock_'.$flock->flock_id] = '-';
					$returnRow['flock_'.$flock->flock_id] = "-";
				}
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate++;
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;


	}

	public function getSpecificWeeksComparisons($postData){
		/*
			"parameter":parameter, 
			"compareWeekFrom":compareWeekFrom, 
			"compareWeekEnd":compareWeekEnd,
			"flocks":flocks
		*/
		//getting flock basic data
		$flocksArray=array();
		foreach($postData['flocks'] as $flockId){
			$flocksArray[] = DB::table('flocks')->where('flock_id','=',$flockId)->first();
		}
		//end-----------
		$curDate = ($postData['compareWeekFrom']*7)-7;
		$returnRows=array();
		$limit = ($postData['compareWeekEnd']*7)-7;//strtotime(date("Y-m-d",time()));

		while($curDate <= $limit) {
			

			$returnRow['bird_age_week'] = floor(($curDate/7)+1);
			foreach($flocksArray as $flock){
				
				$addUp=$curDate+1;
				$today=strtotime("+$addUp day",strtotime($flock->arrival_date));
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',date("Y-m-d",$today))
													->where('flock_id','=',$flock->flock_id)
													->where('field_name','=',$postData['parameter'])
													->first();
				if($flockData){
					$returnRow['standard_flock_'.$flock->flock_id] = $flockData->standard_value;
					$returnRow['flock_'.$flock->flock_id] = $flockData->field_value;
				} else{
					$returnRow['standard_flock_'.$flock->flock_id] = '-';
					$returnRow['flock_'.$flock->flock_id] = "-";
				}
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate++;
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}

	public function getDateRangesComparisons($postData){
		/*
			
			"parameter":parameter, 
			"dateFrom":dateFrom, 
			"dateTo":dateTo, 
			"flocks":flocks
		*/
		$minDate = DB::table('dailyfeeding')->min('entry_date');
		//getting flock basic data
		// $flocksArray=array();
		// foreach($flocks as $flock){
		// 	$flocksArray[] = DB::table('flocks')->where('flock_id')->first();
		// }
		//end-----------
		
		$returnRows=array();
		$limitDate = strtotime($postData['dateTo']);
		$curDate = strtotime($postData['dateFrom']);
		while($curDate <= $limitDate) {
			$today = date("Y-m-d", $curDate);

			$returnRow['entry_date'] = $today;
			foreach($postData['flocks'] as $flock){
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',$today)
													->where('flock_id','=',$flock)
													->where('field_name','=',$postData['parameter'])
													->first();
				if($flockData){
					$returnRow['standard_flock_'.$flock] = $flockData->standard_value;
					$returnRow['flock_'.$flock] = $flockData->field_value;
				} else{
					$returnRow['standard_flock_'.$flock] = '-';
					$returnRow['flock_'.$flock] = "-";
				}
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate = strtotime('+1 day', $curDate);
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}

	public function getComparativeTiterReport($postData){
		//fetch very first record of 
		$obj = DB::table('titersreport')->where('disease_id','=',$postData['titer'])
						->selectRaw('distinct flockAge_weeks');
		if($postData['recordType'] != ''){
			if($postData['recordType'] == 'days'){
				$obj=$obj->where('birdAge_days','>=',$postData['compareDayFrom'])->where('birdAge_days','<=',$postData['compareDayTo']);
			} else if($postData['recordType'] == 'weeks'){
				$obj=$obj->where('flockAge_weeks','>=',$postData['compareWeekFrom'])->where('flockAge_weeks','<=',$postData['compareWeekEnd']);
			} else if($postData['recordType'] == 'date_range'){
				$obj=$obj->where('date','>=',$postData['dateFrom'])->where('date','<=',$postData['dateTo']);
			}
		}
		$daysTreated = $obj->get();
		$returnRows=array();
		foreach($daysTreated as $week){
			$returnRow=array();
			$returnRow['bird_age_week'] = $week;
			foreach($postData['flocks'] as $flockId){
				$titerReport = DB::table('titersreport')->where('flock_id','=',$flockId)
									 ->where('flockAge_weeks','=',$week->flockAge_weeks)
									 ->first();	
				if($titerReport){
					$returnRow['titer_range_'.$flockId]= $titerReport->range;
					$returnRow['titer_avg_'.$flockId] = number_format($titerReport->average,'2','.',',');
				} else{
					$returnRow['titer_range_'.$flockId]= '';
					$returnRow['titer_avg_'.$flockId] = '';	
				}
				
			}
			$returnRows[] = $returnRow;
			
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}

	public function fetchPeriodicalReportsData($postData){
		//fetch very first record of 
		$flock = DB::table('flocks')->where('flock_id','=',$postData['flock'])->first();
		$options = $postData;
		$reportObj = DB::table('periodical_reports')->orderBy('entry_date','asc')->where('periodical_reports.flock_id','=',$postData['flock'])->where('type','=',$postData['report_type']);

		// if(!$options['fetchAll']){
		// 	$reportObj->where("entry_date",'>=',$postData['dateFrom']);
		// 	$reportObj->where("entry_date",'<=',$postData['dateTo']);
		// }
		/*
			"recordType":recordType,
	        "compareDayFrom":compareDayFrom,
	        compareDayTo":compareDayTo, 
	        "compareWeekFrom":compareWeekFrom, 
	        "compareWeekEnd":compareWeekEnd,
	        "dateFrom":dateFrom, 
	        "dateTo":dateTo
		*/
	    if($postData['recordType'] == 'days'){
	    	$dayFrom = strtotime("+".($postData['compareDayFrom']-1)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareDayTo']-1)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));

	    }else if($postData['recordType'] =='weeks'){
	    	$dayFrom = strtotime("+".(($postData['compareWeekFrom']*7)-7)." days", strtotime($flock->arrival_date));
	    	$dayTo = strtotime("+".($postData['compareWeekFrom']*7)." days", strtotime($flock->arrival_date));
	    	$reportObj->where("entry_date",'>=',date("Y-m-d",$dayFrom));
			$reportObj->where("entry_date",'<=',date("Y-m-d",$dayTo));
			
	    } else if ($postData['recordType'] =='date_range'){
	    	
			$reportObj->where("entry_date",'>=',$postData['dateFrom']);
			$reportObj->where("entry_date",'<=',$postData['dateTo']);
		
	    }
		$results = $reportObj->get();
		$returnRow_comp=array();
		//echo $reportObj->count();
		if($results) {
			foreach($results as $result){
				
				$returnRow=array();
				$returnRow['entry_date'] = $result->entry_date;
				$returnRow['title'] = $result->title;
				$returnRow['description'] = substr($result->description, 0, 60);
				$returnRow['attachment'] = $result->attachment != null ? 'Yes' : 'no';
				
				
				//assigning values to parent array
				$returnRow_comp['data'][] = $returnRow;
			}	
		} else{
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = $reportObj->count();
		$returnRow_comp['recordsTotal'] = $reportObj->count();
		return $returnRow_comp;
	}

	
	public function commulativeWeeklyFeedComp($postData) {
		
		if ($postData['recordType'] == 'weeks'){
			$returnData = $this->getSpecificWeeksCommulativeFeedComparisons($postData);
		} else if ($postData['recordType'] == 'date_range'){
			$returnData = $this->getDateRangesCommulativeFeedComparisons($postData);
		}
		return $returnData;
	}

	public function commulativeFeedCompFlock($postData) {
		if ($postData['recordType'] == 'weeks'){
			$returnData = $this->getSpecificFlockCommulativeFeedComparisons($postData);
		} else if ($postData['recordType'] == 'date_range'){
			$returnData = $this->getDateRangesFlockCommulativeFeedComparisons($postData);
		}
		return $returnData;
	}

	public function comparisonFeedPerEgg($postData) {
		
		if ($postData['recordType'] == 'weeks'){
			$returnData = $this->getSpecificFlockFeedPerEggComparisons($postData);
		} else if ($postData['recordType'] == 'date_range'){
			$returnData = $this->getDateRangeFlockFeedPerEggComparisons($postData);
		}
		return $returnData;

	}

	public function compCommulativeDailyMortality ($postData) {

		if ($postData['recordType'] == 'weeks'){
			$returnData = $this->getMortalityWeekComparisons($postData);
		} else if ($postData['recordType'] == 'date_range'){
			$returnData = $this->getDateRangesMortalityComparisons($postData);
		}
		return $returnData;
	}

	public function compEggPerHenHoused($postData) {

	}

	public function compBodyWeight($postData) {
		
		if ($postData['recordType'] == 'weeks'){
			$returnData = $this->getBodyWeightWeekComparisons($postData);
		} else if ($postData['recordType'] == 'date_range'){
			$returnData = $this->getDateRangesBodyWeightComparisons($postData);
		}
		return $returnData;
		
	}

	/******/
	public function getSpecificWeeksCommulativeFeedComparisons($postData){
		/*
			"parameter":parameter, 
			"compareWeekFrom":compareWeekFrom, 
			"compareWeekEnd":compareWeekEnd,
			"flocks":flocks
		*/
		//getting flock basic data
		$flocksArray=array();
		$count = $standardValue= $actualValue = array();
		foreach($postData['flocks'] as $flockId){
			$flocksArray[] = DB::table('flocks')->where('flock_id','=',$flockId)->first();
			$count[$flockId] = 1;
			$standardValue[$flockId] = $actualValue[$flockId] = '';
		}
		//end-----------
		$curDate = ($postData['compareWeekFrom']*7)-7;
		$returnRows=array();
		$limit = ($postData['compareWeekEnd']*7)-7;//strtotime(date("Y-m-d",time()));
		
		

		while($curDate <= $limit) {
			

			$returnRow['bird_age_week'] = floor(($curDate/7)+1);
			foreach($flocksArray as $flock){
				
				$addUp=$curDate+1;
				$today=strtotime("+$addUp day",strtotime($flock->arrival_date));
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',date("Y-m-d",$today))
													->where('flock_id','=',$flock->flock_id)
													->where('field_name','=','feed_per_bird')
													->first();
				if($flockData){
					if($count[$flock->flock_id]%7 == 1 ){
						$standardValue[$flock->flock_id] = $flockData->standard_value;
						$actualValue[$flock->flock_id] = $flockData->field_value;					
					} else{
						$standardValue[$flock->flock_id] 	= $standardValue[$flock->flock_id]+$flockData->standard_value;
						$actualValue[$flock->flock_id]	= $actualValue[$flock->flock_id] + $flockData->field_value;
					}
					$returnRow['standard_flock_'.$flock->flock_id] = $standardValue[$flock->flock_id];//$flockData->standard_value;
					$returnRow['flock_'.$flock->flock_id] = $actualValue[$flock->flock_id];//$flockData->field_value;
				} else{
					$returnRow['standard_flock_'.$flock->flock_id] = '-';
					$returnRow['flock_'.$flock->flock_id] = "-";
				}
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate++;
			$count[$flock->flock_id]++;
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}

	public function getDateRangesCommulativeFeedComparisons($postData){
		/*
			
			"parameter":parameter, 
			"dateFrom":dateFrom, 
			"dateTo":dateTo, 
			"flocks":flocks
		*/
		$flocksArray=array();
		$count = $standardValue= $actualValue = array();
		foreach($postData['flocks'] as $flockId){
			$flocksArray[] = DB::table('flocks')->where('flock_id','=',$flockId)->first();
			$count[$flockId] = 1;
			$standardValue[$flockId] = $actualValue[$flockId] = '';
		}
		//getting flock basic data
		// $flocksArray=array();
		// foreach($flocks as $flock){
		// 	$flocksArray[] = DB::table('flocks')->where('flock_id')->first();
		// }
		//end-----------
		
		$returnRows=array();
		$limitDate = strtotime($postData['dateTo']);
		$curDate = strtotime($postData['dateFrom']);
		
		while($curDate <= $limitDate) {
			$today = date("Y-m-d", $curDate);

			$returnRow['entry_date'] = $today;
			foreach ($flocksArray as $flock) {
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',$today)
													->where('flock_id','=',$flock->flock_id)
													->where('field_name','=','feed_per_bird')
													->first();
				if($flockData){
					if($count[$flock->flock_id]%7 == 1 ){
						$standardValue[$flock->flock_id] = $flockData->standard_value;
						$actualValue[$flock->flock_id] = $flockData->field_value;					
					} else{
						$standardValue[$flock->flock_id] 	= $standardValue[$flock->flock_id] + $flockData->standard_value;
						$actualValue[$flock->flock_id]	= $actualValue[$flock->flock_id] + $flockData->field_value;
					}
					$returnRow['standard_flock_'.$flock->flock_id] = $standardValue[$flock->flock_id];//$flockData->standard_value;
					$returnRow['flock_'.$flock->flock_id] = $actualValue[$flock->flock_id];//$flockData->field_value;
				} else{
					$returnRow['standard_flock_'.$flock->flock_id] = '-';
					$returnRow['flock_'.$flock->flock_id] = "-";
				}

				$count[$flock->flock_id]++;
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate = strtotime('+1 day', $curDate);
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}

	/******/
	public function getSpecificFlockCommulativeFeedComparisons($postData){
		/*
			"parameter":parameter, 
			"compareWeekFrom":compareWeekFrom, 
			"compareWeekEnd":compareWeekEnd,
			"flocks":flocks
		*/
		//getting flock basic data
		$flocksArray=array();
		$count = $standardValue= $actualValue = array();
		foreach($postData['flocks'] as $flockId){
			$flocksArray[] = DB::table('flocks')->where('flock_id','=',$flockId)->first();
			$count[$flockId] = 1;
			$standardValue[$flockId] = $actualValue[$flockId] = '';
		}
		//end-----------
		$curDate = ($postData['compareWeekFrom']*7)-7;
		$returnRows=array();
		$limit = ($postData['compareWeekEnd']*7)-7;//strtotime(date("Y-m-d",time()));
		
		while($curDate <= $limit) {
			

			$returnRow['bird_age_week'] = floor(($curDate/7)+1);
			foreach($flocksArray as $flock){
				
				$addUp=$curDate+1;
				$today=strtotime("+$addUp day",strtotime($flock->arrival_date));
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',date("Y-m-d",$today))
													->where('flock_id','=',$flock->flock_id)
													->where('field_name','=','feed_per_bird')
													->first();
				if($flockData){
					
					$standardValue[$flock->flock_id] 	= $standardValue[$flock->flock_id] + $flockData->standard_value;
					$actualValue[$flock->flock_id]	= $actualValue[$flock->flock_id] + $flockData->field_value;
					
					$returnRow['standard_flock_'.$flock->flock_id] = $standardValue[$flock->flock_id];//$flockData->standard_value;
					$returnRow['flock_'.$flock->flock_id] = $actualValue[$flock->flock_id];//$flockData->field_value;
				} else{
					$returnRow['standard_flock_'.$flock->flock_id] = '-';
					$returnRow['flock_'.$flock->flock_id] = "-";
				}
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate++;
			$count[$flock->flock_id]++;
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}

	public function getDateRangesFlockCommulativeFeedComparisons($postData){
		/*
			
			"parameter":parameter, 
			"dateFrom":dateFrom, 
			"dateTo":dateTo, 
			"flocks":flocks
		*/
		$flocksArray=array();
		$count = $standardValue= $actualValue = array();
		foreach($postData['flocks'] as $flockId){
			$flocksArray[] = DB::table('flocks')->where('flock_id','=',$flockId)->first();
			$count[$flockId] = 1;
			$standardValue[$flockId] = $actualValue[$flockId] = '';
		}
		//getting flock basic data
		// $flocksArray=array();
		// foreach($flocks as $flock){
		// 	$flocksArray[] = DB::table('flocks')->where('flock_id')->first();
		// }
		//end-----------
		
		$returnRows=array();
		$limitDate = strtotime($postData['dateTo']);
		$curDate = strtotime($postData['dateFrom']);
		
		while($curDate <= $limitDate) {
			$today = date("Y-m-d", $curDate);

			$returnRow['entry_date'] = $today;
			foreach ($flocksArray as $flock) {
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',$today)
													->where('flock_id','=',$flock->flock_id)
													->where('field_name','=','feed_per_bird')
													->first();
				if($flockData){
					
					
					$standardValue[$flock->flock_id] 	= $standardValue[$flock->flock_id] + $flockData->standard_value;
					$actualValue[$flock->flock_id]	= $actualValue[$flock->flock_id] + $flockData->field_value;
					
					$returnRow['standard_flock_'.$flock->flock_id] = $standardValue[$flock->flock_id];//$flockData->standard_value;
					$returnRow['flock_'.$flock->flock_id] = $actualValue[$flock->flock_id];//$flockData->field_value;
				} else{
					$returnRow['standard_flock_'.$flock->flock_id] = '-';
					$returnRow['flock_'.$flock->flock_id] = "-";
				}
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate = strtotime('+1 day', $curDate);
			$count[$flock->flock_id]++;
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}

	/******/
	public function getSpecificFlockFeedPerEggComparisons($postData){
		/*
			"parameter":parameter, 
			"compareWeekFrom":compareWeekFrom, 
			"compareWeekEnd":compareWeekEnd,
			"flocks":flocks
		*/
		//getting flock basic data
		$flocksArray=array();
		$count = $standardValue= $actualValue = array();
		foreach($postData['flocks'] as $flockId){
			$flocksArray[] = DB::table('flocks')->where('flock_id','=',$flockId)->first();
			$count[$flockId] = 1;
			$standardValue[$flockId] = $actualValue[$flockId] = '';
		}
		//end-----------
		$curDate = ($postData['compareWeekFrom']*7)-7;
		$returnRows=array();
		$limit = ($postData['compareWeekEnd']*7)-7;//strtotime(date("Y-m-d",time()));
		
		while($curDate <= $limit) {
			

			$returnRow['bird_age_week'] = floor(($curDate/7)+1);
			foreach($flocksArray as $flock){
				
				$addUp=$curDate+1;
				$today=strtotime("+$addUp day",strtotime($flock->arrival_date));
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',date("Y-m-d",$today))
													->where('flock_id','=',$flock->flock_id)
													->where('field_name','=','feed_per_bird')
													->first();

				$eggProduction = DB::table("dailyfeeding")->where('flock_id','=',$flock->flock_id)
															->where('field_name','=','feed_egg_production')
															->where('entry_date','=',date("Y-m-d",$today))
															->first();

				if($flockData){
					
					$standardValueG= $eggProduction->standard_value != 0 ? number_format($flockData->standard_value/$eggProduction->standard_value,2,'.',',') : 0;

					 $fieldValueG = $eggProduction->field_value != 0 ? number_format($flockData->field_value/$eggProduction->field_value,2,'.',',') : 0;

					$standardValue[$flock->flock_id] 	= $standardValueG;
					$actualValue[$flock->flock_id]	=  $fieldValueG;
					
					$returnRow['standard_flock_'.$flock->flock_id] = $standardValue[$flock->flock_id];//$flockData->standard_value;
					$returnRow['flock_'.$flock->flock_id] = $actualValue[$flock->flock_id];//$flockData->field_value;
				} else{
					$returnRow['standard_flock_'.$flock->flock_id] = '-';
					$returnRow['flock_'.$flock->flock_id] = "-";
				}
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate++;
			$count[$flock->flock_id]++;
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}

	public function getDateRangeFlockFeedPerEggComparisons($postData){
		/*
			
			"parameter":parameter, 
			"dateFrom":dateFrom, 
			"dateTo":dateTo, 
			"flocks":flocks
		*/
		$flocksArray=array();
		$count = $standardValue= $actualValue = array();
		foreach($postData['flocks'] as $flockId){
			$flocksArray[] = DB::table('flocks')->where('flock_id','=',$flockId)->first();
			$count[$flockId] = 1;
			$standardValue[$flockId] = $actualValue[$flockId] = '';
		}
		//getting flock basic data
		// $flocksArray=array();
		// foreach($flocks as $flock){
		// 	$flocksArray[] = DB::table('flocks')->where('flock_id')->first();
		// }
		//end-----------
		
		$returnRows=array();
		$limitDate = strtotime($postData['dateTo']);
		$curDate = strtotime($postData['dateFrom']);
		
		while($curDate <= $limitDate) {
			$today = date("Y-m-d", $curDate);

			$returnRow['entry_date'] = $today;
			foreach ($flocksArray as $flock) {
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',$today)
													->where('flock_id','=',$flock->flock_id)
													->where('field_name','=','feed_per_bird')
													->first();
				if($flockData){
					
					
					$standardValueG= $eggProduction->standard_value != 0 ? number_format($flockData->standard_value/$eggProduction->standard_value,2,'.',',') : 0;

					 $fieldValueG = $eggProduction->field_value != 0 ? number_format($flockData->field_value/$eggProduction->field_value,2,'.',',') : 0;

					$standardValue[$flock->flock_id] 	=  $standardValueG;
					$actualValue[$flock->flock_id]	=  $fieldValueG;
					
					
					$returnRow['standard_flock_'.$flock->flock_id] = $standardValue[$flock->flock_id];//$flockData->standard_value;
					$returnRow['flock_'.$flock->flock_id] = $actualValue[$flock->flock_id];//$flockData->field_value;
				} else{
					$returnRow['standard_flock_'.$flock->flock_id] = '-';
					$returnRow['flock_'.$flock->flock_id] = "-";
				}
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate = strtotime('+1 day', $curDate);
			$count[$flock->flock_id]++;
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}

	/******/
	public function getMortalityWeekComparisons($postData){
		/*
			"parameter":parameter, 
			"compareWeekFrom":compareWeekFrom, 
			"compareWeekEnd":compareWeekEnd,
			"flocks":flocks
		*/
		//getting flock basic data
		$flocksArray=array();
		$count = $standardValue= $actualValue = array();
		foreach($postData['flocks'] as $flockId){
			$flocksArray[] = DB::table('flocks')->where('flock_id','=',$flockId)->first();
			$count[$flockId] = 1;
			$standardValue[$flockId] = $actualValue[$flockId] = 0;
		}
		//end-----------
		$curDate = ($postData['compareWeekFrom']*7)-7;
		$returnRows=array();
		$limit = ($postData['compareWeekEnd']*7)-7;//strtotime(date("Y-m-d",time()));
		
		while($curDate <= $limit) {
			

			$returnRow['bird_age_week'] = floor(($curDate/7)+1);
			foreach($flocksArray as $flock){
				
				$addUp=$curDate+1;
				$today=strtotime("+$addUp day",strtotime($flock->arrival_date));
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',date("Y-m-d",$today))
													->where('flock_id','=',$flock->flock_id)
													->where('field_name','=','feed_mortality')
													->first();
				if($flockData){
					
					if($count[$flock->flock_id]%7 == 1 ){
						$standardValue[$flock->flock_id] = $flockData->standard_value;
						$actualValue[$flock->flock_id] = $flockData->field_value;					
					} else{
						$standardValue[$flock->flock_id] 	= $standardValue[$flock->flock_id]+$flockData->standard_value;
						$actualValue[$flock->flock_id]	= $actualValue[$flock->flock_id] + $flockData->field_value;
					}
					$returnRow['standard_flock_'.$flock->flock_id] = $standardValue[$flock->flock_id];//$flockData->standard_value;
					$returnRow['flock_'.$flock->flock_id] = $actualValue[$flock->flock_id];//$flockData->field_value;
				} else{
					$returnRow['standard_flock_'.$flock->flock_id] = '-';
					$returnRow['flock_'.$flock->flock_id] = "-";
				}
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate++;
			$count[$flock->flock_id]++;
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}

	public function getDateRangesMortalityComparisons($postData){
		/*
			
			"parameter":parameter, 
			"dateFrom":dateFrom, 
			"dateTo":dateTo, 
			"flocks":flocks
		*/
		$flocksArray=array();
		$count = $standardValue= $actualValue = array();
		foreach($postData['flocks'] as $flockId){
			$flocksArray[] = DB::table('flocks')->where('flock_id','=',$flockId)->first();
			$count[$flockId] = 1;
			$standardValue[$flockId] = $actualValue[$flockId] = 0;
		}
		//getting flock basic data
		// $flocksArray=array();
		// foreach($flocks as $flock){
		// 	$flocksArray[] = DB::table('flocks')->where('flock_id')->first();
		// }
		//end-----------
		
		$returnRows=array();
		$limitDate = strtotime($postData['dateTo']);
		$curDate = strtotime($postData['dateFrom']);
		
		while($curDate <= $limitDate) {
			$today = date("Y-m-d", $curDate);

			$returnRow['entry_date'] = $today;
			foreach ($flocksArray as $flock) {
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',$today)
													->where('flock_id','=',$flock->flock_id)
													->where('field_name','=','feed_mortality')
													->first();
				if($flockData){
					
					if($count[$flock->flock_id]%7 == 1 ){
						$standardValue[$flock->flock_id] = $flockData->standard_value;
						$actualValue[$flock->flock_id] = $flockData->field_value;					
					} else{
						$standardValue[$flock->flock_id] 	= $standardValue[$flock->flock_id]+$flockData->standard_value;
						$actualValue[$flock->flock_id]	= $actualValue[$flock->flock_id] + $flockData->field_value;
					}
					$returnRow['standard_flock_'.$flock->flock_id] = $standardValue[$flock->flock_id];//$flockData->standard_value;
					$returnRow['flock_'.$flock->flock_id] = $actualValue[$flock->flock_id];//$flockData->field_value;
				} else{
					$returnRow['standard_flock_'.$flock->flock_id] = '-';
					$returnRow['flock_'.$flock->flock_id] = "-";
				}
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate = strtotime('+1 day', $curDate);
			$count[$flock->flock_id]++;
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}

	/******/
	public function getBodyWeightWeekComparisons($postData){
		/*
			"parameter":parameter, 
			"compareWeekFrom":compareWeekFrom, 
			"compareWeekEnd":compareWeekEnd,
			"flocks":flocks
		*/
		//getting flock basic data
		$flocksArray=array();
		$count = $standardValue= $actualValue = $previousWeek = $standardPrev = array();
		foreach($postData['flocks'] as $flockId){
			$flocksArray[] = DB::table('flocks')->where('flock_id','=',$flockId)->first();
			$count[$flockId] = 1;
			$standardValue[$flockId] = $actualValue[$flockId] = $previousWeek[$flockId] = $standardPrev[$flockId] = 0;
		}
		//end-----------
		$curDate = ($postData['compareWeekFrom']*7)-7;
		$returnRows=array();
		$limit = ($postData['compareWeekEnd']*7)-7;//strtotime(date("Y-m-d",time()));
		
		while($curDate <= $limit) {
			

			$returnRow['bird_age_week'] = floor(($curDate/7)+1);
			foreach($flocksArray as $flock){
				
				$addUp=$curDate+1;
				$today=strtotime("+$addUp day",strtotime($flock->arrival_date));
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',date("Y-m-d",$today))
													->where('flock_id','=',$flock->flock_id)
													->where('field_name','=','body_weight')
													->first();

				

				if ($flockData) {
					$standardV = $flockData->standard_value - $standardPrev[$flock->flock_id];
					$weightV =  $flockData->field_value - $previousWeek[$flock->flock_id];
					$standardValueG = number_format($standardV/7, '2','.',',');
					$fieldValueG = number_format($weightV/7, '2','.',',');
					//assigning values to parent array
				
					$previousWeek = $flockData->field_value;
					$standardPrev = $flockData->standard_value;
					
					$standardValue[$flock->flock_id] 	= $standardValueG;
					$actualValue[$flock->flock_id]	=  $fieldValueG;
					
					$returnRow['standard_flock_'.$flock->flock_id] = $standardValue[$flock->flock_id];//$flockData->standard_value;
					$returnRow['flock_'.$flock->flock_id] = $actualValue[$flock->flock_id];//$flockData->field_value;

				} else {
					$returnRow['standard_flock_'.$flock->flock_id] = '-';
					$returnRow['flock_'.$flock->flock_id] = "-";
				}
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate++;
			$count[$flock->flock_id]++;
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}

	public function getDateRangesBodyWeightComparisons($postData){
		/*
			
			"parameter":parameter, 
			"dateFrom":dateFrom, 
			"dateTo":dateTo, 
			"flocks":flocks
		*/
		$flocksArray=array();
		$count = $standardValue= $actualValue = $previousWeek = $standardPrev = array();
		foreach($postData['flocks'] as $flockId){
			$flocksArray[] = DB::table('flocks')->where('flock_id','=',$flockId)->first();
			$count[$flockId] = 1;
			$standardValue[$flockId] = $actualValue[$flockId] = $previousWeek[$flockId] = $standardPrev[$flockId] = 0;
		}
		//getting flock basic data
		// $flocksArray=array();
		// foreach($flocks as $flock){
		// 	$flocksArray[] = DB::table('flocks')->where('flock_id')->first();
		// }
		//end-----------
		
		$returnRows=array();
		$limitDate = strtotime($postData['dateTo']);
		$curDate = strtotime($postData['dateFrom']);
		
		while($curDate <= $limitDate) {
			$today = date("Y-m-d", $curDate);

			$returnRow['entry_date'] = $today;
			foreach ($flocksArray as $flock) {
				$flockData = DB::table('dailyfeeding')->where('entry_date','=',$today)
													->where('flock_id','=',$flock->flock_id)
													->where('field_name','=','body_weight')
													->first();
				if($flockData){
					
					$standardV = $flockData->standard_value - $standardPrev[$flock->flock_id];
					$weightV =  $flockData->field_value - $previousWeek[$flock->flock_id];
					$standardValueG = number_format($standardV/7, '2','.',',');
					$fieldValueG = number_format($weightV/7, '2','.',',');
					//assigning values to parent array
				
					$previousWeek[$flock->flock_id] = $flockData->field_value;
					$standardPrev[$flock->flock_id] = $flockData->standard_value;
					
					$standardValue[$flock->flock_id] 	= $standardValueG;
					$actualValue[$flock->flock_id]	=  $fieldValueG;
					
					$returnRow['standard_flock_'.$flock->flock_id] = $standardValue[$flock->flock_id];//$flockData->standard_value;
					$returnRow['flock_'.$flock->flock_id] = $actualValue[$flock->flock_id];//$flockData->field_value;
				} else{
					$returnRow['standard_flock_'.$flock->flock_id] = '-';
					$returnRow['flock_'.$flock->flock_id] = "-";
				}
			}
			$returnRows[] = $returnRow;
			//add one more day;
			$curDate = strtotime('+1 day', $curDate);
			$count[$flock->flock_id]++;
		}
		$returnRow_comp = array();
		if(count($returnRows) > 0 ) {
			$returnRow_comp['data'] = $returnRows;
		} else {
			$returnRow_comp['data']=array();
		}
		$returnRow_comp["draw"]= 1;
    	$returnRow_comp["recordsFiltered"] = count($returnRows);
		$returnRow_comp['recordsTotal'] = count($returnRows);
		return $returnRow_comp;
	}


}
