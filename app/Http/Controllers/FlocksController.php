<?php namespace App\Http\Controllers;

use \App\Flock;
use \App\User;
use \App\Dailyfeeding;
use \App\Flockstandards;
use \App\Disease;
use \App\Mortalityreasons;

use Request;
// pagination
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
//response and view 
use Response;
use View, DB, Input, Mail, Session, Sentry;

// custom helper functions

class FlocksController extends Controller {

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
		$this->flocks = New Flock;
		$this->user = New User;
		$this->dailyFeeding = New Dailyfeeding;
		$this->standards = New Flockstandards;
		$this->middleware('ssg.auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{	
		
		$flocks = array();
		if(!Sentry::getUser()->hasAccess('manage_flocks') ) {
			$flocks= $this->flocks->where('flocks.status','=','1')->join('users','users.id','=','flocks.user_id')->where('flocks.user_id','=',Session::get('userId'))->get();
		} else {
			$flocks= $this->flocks->where('flocks.status','=','1')->join('users','users.id','=','flocks.user_id')->get();
		}
		$users = DB::table('users')->where('activated','=','1')->get();
		$bookstandards = DB::table('bookstandards')->get();
		return view('flocks.flocks', array('flocks'=>$flocks,'standards'=>$bookstandards,'users'=>$users));
	}

	public function store(){
		// Form Processing

		$this->flocks->fill(Input::all());
		
		//$id = empty(Input::get('id')) ? false : Input::get('id');
		$arrivalDate = $this->flocks->calculateAverageDate(Input::all());
		$this->flocks->arrival_date = $arrivalDate;
        if ($this->flocks->isValid() ) {
        	if(!$this->flocks->flock_id || empty($this->flocks->flock_id) ){
        		$this->flocks->save();
        		$this->flocks->saveToleranceRanges(Input::all(),$this->flocks->flock_id);
        		$this->flocks->saveBatchDetail(Input::all(),$this->flocks->flock_id);
        	} else { //update Flock Information.
        		$this->flocks->where('flock_id','=',$this->flocks->flock_id)
        					->update(array(
        							'user_id'=>$this->flocks->user_id,
        							'batch_size' => $this->flocks->batch_size,
        							'display_id' => $this->flocks->display_id,
        							'shed_no'=> $this->flocks->shed_no,
        							'breed_name'=>$this->flocks->breed_name,
        							'arrival_date' => $this->flocks->arrival_date
        						));
        		$this->flocks->saveToleranceRanges(Input::all(),$this->flocks->flock_id, true);
        		$this->flocks->saveBatchDetail(Input::all(),$this->flocks->flock_id,true);
        	}

            // Success!
        	
            if(empty(Input::get('flock_id')) ) {
            	$this->informSectionHead(Input::all());
	        	return $this->flocks->flock_id;
	        }else{
	        	return Input::get('flock_id');
	        }
        } else {

            return json_encode($this->flocks->errors);
            
        }
	}

	public function storeStandards(){
		$input =Input::all();
		$size= count($input['week']);
		
		$insertArray=array();
		
		DB::table('flock_standards')->where('flock_id','=',$input['standard_flock_id'])->delete();
		$count=0;
		while($count<$size){
			
			$insertArray[] = array('flock_id'=>$input['standard_flock_id'],
									'week'=>$input['week'][$count],
									'feed'=>$input['feed'][$count],
									'water_consumption'=>$input['water_consumption'][$count],
									'mortality'=>$input['mortality'][$count],
									'temprature'=>$input['temprature'][$count],
									'humidity'=>$input['humidity'][$count],
									'egg_weight'=>$input['egg_weight'][$count],
									'egg_production'=>$input['egg_production'][$count],
									'body_weight'=>$input['body_weight'][$count],
									'uniformity'=>$input['uniformity'][$count],
									'manure_removal'=>$input['manure_removal'][$count],
									'light_intensity'=>$input['light_intensity'][$count],
									'wind_velocity'=>$input['wind_velocity'][$count]
									);
			$count++;
		}
		DB::table('flock_standards')->insert($insertArray);
		return 1;
	}

	public function edit($id){
		$flock = $this->flocks->where('flocks.flock_id','=',$id)
					->leftJoin('users', 'users.id','=', 'flocks.user_id')					
					->select('flocks.*', 'users.first_name as doctor_id', 'users.email')
					->get();
		$flockId = $flock[0];
		$tolerance_range = DB::table('flock_tolerance_ranges')->where('flock_id','=',$flockId->flock_id)->get();
		$flock[0]->tolerance_range = json_encode($tolerance_range);
		$batchDetails = DB::table('flock_batch_detail')->where('flock_id','=',$flockId->flock_id)->get();
		$flock[0]->batch_details = json_encode($batchDetails);
		return json_encode($flock);
	}

	public function destroy($id){
		if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }
        $res = $this->flocks->where('flock_id','=',$id)->update(array('status'=>'0'));
        if ( $res ) {
            
            return 1;

        } else {
            return 0;
        }
	}

	public function doctors(){
		$term =  Input::get("term") !== null ? Input::get("term") : false ;
		
		$specialist = $this->user->where('users.first_name','like', '%'.$term.'%')
							->select('users.id as id', 'users.first_name as label','users.email as email')
							->get();

		return json_encode($specialist);
	}

	public function view($flockId){
		$feeds = $flock= array();
		$feeds= $this->dailyFeeding->where('flock_id','=',$flockId)->get();
		$flock = $this->flocks->where('flock_id','=',$flockId)->first();

		return view('flocks.view', array('feeds'=>$feeds, 'flock'=>$flock));
	}

	public function dailyFeed($flockId){
		$feeds = $flock= array();

		$feed_per_bird= $this->dailyFeeding->where('status','=','1')->where('flock_id','=',$flockId)->where('field_name','=','feed_per_bird')->get();
		
		$water_consumption = $this->dailyFeeding->where('status','=','1')->where('flock_id','=',$flockId)->where('field_name','=','feed_water_consumption')->get();
		
		$mortality = $this->dailyFeeding->where('status','=','1')->where('flock_id','=',$flockId)->where('field_name','=','feed_mortality')->get();

		$humidity = $this->dailyFeeding->where('status','=','1')->where('dailyfeeding.flock_id','=',$flockId)->where('field_name','=','feed_humidity')->join('humidity_details','humidity_details.feed_id','=','dailyfeeding.feed_id')->get();

		$egg_weight = $this->dailyFeeding->where('status','=','1')->where('flock_id','=',$flockId)->where('field_name','=','feed_egg_weight')->get();
		
		$egg_production = $this->dailyFeeding->where('status','=','1')->where('flock_id','=',$flockId)->where('field_name','=','feed_egg_production')->get();
		
		$feed_temprature = $this->dailyFeeding->where('status','=','1')->where('dailyfeeding.flock_id','=',$flockId)->where('field_name','=','feed_temprature')->join('temperature_details', 'temperature_details.feed_id','=','dailyfeeding.feed_id')->get();

		$flock = $this->flocks->where('flock_id','=',$flockId)->first();
		//calculate flock age
		$age_of_week = DB::table('flocks')->where('flock_id','=',$flockId)->select(DB::raw('CEIL(DATEDIFF(DATE(NOW()),DATE(arrival_date))/7) as bird_age'))->first();
		//dd($feed_per_bird);
		$mortality_details=DB::table('mortality_details')
								->where('mortality_details.flock_id','=',$flockId)
								->join('mortality_reasons','mortality_reasons.id','=','mortality_details.reason_id')
								->get();
		//$mortality_details = $this->arrangeResultSet($mortality_details);
		$standards = DB::table('flock_standards')->where('flock_id','=',$flockId)->where('week','=',$age_of_week->bird_age)->first();
		$diseasesObj = New Mortalityreasons;
		$reasons = $diseasesObj->where('status','=',1)->get();

		return view('flocks.dailyfeed', array('feeds'=>$feeds, 
												'flock'=>$flock, 
												'feed_per_bird'=>$feed_per_bird,
												'water_consumption' => $water_consumption,
												'egg_weight' =>$egg_weight,
												'egg_production'=>$egg_production,
												'feed_temprature'=>$feed_temprature,
												'age_of_week' =>$age_of_week,
												'mortality'=>$mortality,
												'humidity' => $humidity,
												'reasons' => $reasons,
												'standards' =>$standards
											));	
	}
	
	public function storeDailyFeed($flockId){
		// Form Processing

		$disease= Input::get('reason');
		$reasons = json_encode($disease);
		//flock Data to calculate bird age.
		$flockData = $this->flocks->where('flocks.flock_id','=',$flockId)->first();

    	$this->dailyFeeding->fill(Input::all());
		
		$this->dailyFeeding->reasons=$reasons;
		$this->dailyFeeding->bird_age_week = datediffInWeeks(Input::get('entry_date'),$flockData->arrival_date);
		
		$standardValue = DB::table('flock_standards')->where('flock_id','=',$flockId)->where('week','=',$this->dailyFeeding->bird_age_week)->first();

		$this->dailyFeeding->standard_value = getStandardValue($standardValue,Input::get('field_name'));
		
        if ($this->dailyFeeding->isValid(Input::get('type_entry')) ) {
        	if(!$this->dailyFeeding->feed_id || empty($this->dailyFeeding->feed_id) ){
        		
        		if(Input::get('field_name')=='feed_egg_production'){
        			//check if today's mortality entry has been added or not.
        			$check = DB::table('dailyfeeding')->where('field_name','=','feed_mortality')->where('entry_date','=',Input::get('entry_date'))->first();
        			if(empty($check)){
        				echo json_encode( array("field_value" => array(
        															"This field is dependent on 'Mortality' please add that first" 
        															)
        										) 
        								);
        				exit;
        			}
        			//sum up all mortalities.
        			$sum = DB::table('dailyfeeding')->where('flock_id','=',$flockId)
        												->where('field_name','=','feed_mortality')
        												->select(DB::raw('sum(field_value) as totalMortality'))
        												->first();
        			//fetch total number of birds 
        			$this->dailyFeeding->reasons = Input::get('field_value');
        			$this->dailyFeeding->field_value = (Input::get('field_value')/($flockData->batch_size - $sum->totalMortality))*100;
        			
        		} else if (Input::get('field_name') == 'feed_water_consumption'){ //check for water consumption as water consumption is dependent field it need to be double of actual feed consumed.
					$check = DB::table('dailyfeeding')->where('field_name','=','feed_per_bird')->where('entry_date','=',Input::get('entry_date'))->first();
        			if(empty($check)){
        				echo json_encode( array("field_value" => array(
        															"This field is dependent on Mortality please add that first" 
        															)
        										) 
        								);
        				exit;
        			}
        			//sum up all mortalities.
        			$sum = DB::table('dailyfeeding')->where('flock_id','=',$flockId)
        												->where('field_name','=','feed_per_bird')
        												->where('entry_date','=',Input::get('field_value'))
        												->first();
        			//fetch total number of birds 
        			$this->dailyFeeding->standard_value = $sum->field_value*2;
        		} else if (Input::get('field_name') == 'feed_mortality'){
        			//sum up all mortalities.
        			$sum = DB::table('dailyfeeding')->where('flock_id','=',$flockId)
        												->where('field_name','=','feed_mortality')
        												->select(DB::raw('sum(field_value) as totalMortality'))
        												->first();
        			$this->dailyFeeding->standard_value = round( ((ceil($standardValue->mortality/7))/100)*($flockData->batch_size=$sum->totalMortality) );
        		}

        		$this->dailyFeeding->save();
        		
        		// insert mortality detail
        		if(Input::get('field_name') == 'feed_mortality') {
	        		$this->dailyFeeding->addMortalityDetails(Input::all(),$this->dailyFeeding->feed_id);
			    } else if (Input::get('field_name') == 'feed_temprature'){
			    	$this->dailyFeeding->addTempratureDetails(Input::all(),$this->dailyFeeding->feed_id);
			    } else if (Input::get('field_name') == 'feed_humidity'){
			    	$this->dailyFeeding->addHumidityDetails(Input::all(),$this->dailyFeeding->feed_id);
			    }

        	} else { //update Flock Information.
        		if(Input::get('field_name')=='feed_egg_production'){
        			//check if today's mortality entry has been added or not.
        			$check = DB::table('dailyfeeding')->where('field_name','=','feed_mortality')->where('entry_date','=',Input::get('entry_date'))->first();
        			if(empty($check)){
        				echo json_encode( array("field_value" => array(
        															"This field is dependent on 'Mortality' please add that first" 
        															)
        										) 
        								);
        				exit;
        			}
        			//sum up all mortalities.
        			$sum = DB::table('dailyfeeding')->where('flock_id','=',$flockId)
        												->where('field_name','=','feed_mortality')
        												->select(DB::raw('sum(field_value) as totalMortality'))
        												->first();
        			//fetch total number of birds 
        			$this->dailyFeeding->reasons = Input::get('field_value');
        			
        			$this->dailyFeeding->field_value = (Input::get('field_value')/($flockData->batch_size - $sum->totalMortality))*100;
        			
        		} else if (Input::get('field_name') == 'feed_water_consumption'){ //check for water consumption as water consumption is dependent field it need to be double of actual feed consumed.
					$check = DB::table('dailyfeeding')->where('field_name','=','feed_per_bird')->where('entry_date','=',Input::get('entry_date'))->first();
        			if(empty($check)){
        				echo json_encode( array("field_value" => array(
        															"This field is dependent on Mortality please add that first" 
        															)
        										) 
        								);
        				exit;
        			} 
        			//sum up all mortalities.
        			$sum = DB::table('dailyfeeding')->where('flock_id','=',$flockId)
        												->where('field_name','=','feed_per_bird')
        												->where('entry_date','=',Input::get('field_value'))
        												->first();
        			//fetch total number of birds 
        			$this->dailyFeeding->standard_value = $sum->field_value*2;
        		} else if (Input::get('field_name') == 'feed_mortality'){
        			//sum up all mortalities.
        			$sum = DB::table('dailyfeeding')->where('flock_id','=',$flockId)
        												->where('entry_date','<',$this->dailyFeeding->entry_date)
        												->where('field_name','=','feed_mortality')
        												->select(DB::raw('sum(field_value) as totalMortality'))
        												->first();
        			$this->dailyFeeding->standard_value = round( ((ceil($standardValue->mortality/7))/100)*($flockData->batch_size=$sum->totalMortality) );
        		}


        		$this->dailyFeeding->where('feed_id','=',$this->dailyFeeding->feed_id)
        					->update(array(
        							'flock_id'=>$this->dailyFeeding->flock_id,
        							'entry_date' => $this->dailyFeeding->entry_date,
        							'standard_value'=>$this->dailyFeeding->standard_value,
        							'field_name' => $this->dailyFeeding->field_name,
        							'field_value'=> $this->dailyFeeding->field_value,
        							'bird_age_week' => $this->dailyFeeding->bird_age_week,
        							'reasons' => $this->dailyFeeding->reasons,
        							'comment' => $this->dailyFeeding->comment,
        						));
        		// insert mortality detail
        		if(Input::get('field_name') == 'feed_mortality') {
	        		$this->dailyFeeding->addMortalityDetails(Input::all(),$this->dailyFeeding->feed_id, true);
			    } else if (Input::get('field_name') == 'feed_temprature'){
			    	$this->dailyFeeding->addTempratureDetails(Input::all(),$this->dailyFeeding->feed_id, true);
			    } else if (Input::get('field_name') == 'feed_humidity'){
			    	$this->dailyFeeding->addHumidityDetails(Input::all(),$this->dailyFeeding->feed_id, true);
			    }
		        
        	}  

        	//shoot alert email to section head/Admin/Supervisors about exceeding tolerance ranges.

            // Success!
            $formData = Input::all();
            $formData['field_value'] = $this->dailyFeeding->field_value;
            $this->toleranceRangeExceeded($formData, $this->dailyFeeding->bird_age_week,$this->dailyFeeding->standard_value);
        	
            if(empty(Input::get('feed_id')) ) {
	        	return $this->dailyFeeding->feed_id;
	        }else{
	        	return Input::get('feed_id');
	        }
        } else {

            return json_encode($this->dailyFeeding->errors);
            
        }	
	}

	public function editDailyFeed($feedId){
		if(Input::get('field') =='temprature') {
			$flock = $this->dailyFeeding->where('dailyfeeding.feed_id','=',$feedId)->join('temperature_details','temperature_details.feed_id','=','dailyfeeding.feed_id')->get();
		} else if(Input::get('field') =='humidity') {
			$flock = $this->dailyFeeding->where('dailyfeeding.feed_id','=',$feedId)->join('humidity_details','humidity_details.feed_id','=','dailyfeeding.feed_id')->get();
		} else if(Input::get('field') =='feed_mortality') {
			$flock = $this->dailyFeeding->where('dailyfeeding.feed_id','=',$feedId)->get();
			$flock[0]['reasons'] = json_decode($flock[0]['reasons'], true);
		} else {
			$flock = $this->dailyFeeding->where('feed_id','=',$feedId)->get();
		}

		return json_encode($flock);
	}

	public function deleteDailyFeed($feedId){
		if (!is_numeric($feedId)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }
        $res = $this->dailyFeeding->where('feed_id','=',$feedId)->update(array('status'=>'0'));
        if ( $res ) {
            
            return 1;

        } else {
            return 0;
        }
	}

	public function weeklyFeed($flockId){
		$feeds = $flock= array();
		$bodyWeight= $this->dailyFeeding->where('flock_id','=',$flockId)->where('field_name','=','body_weight')->get();
		$uniformity = $this->dailyFeeding->where('flock_id','=',$flockId)->where('field_name','=','uniformity')->get();
		$manureRemoval = $this->dailyFeeding->where('flock_id','=',$flockId)->where('field_name','=','manure_removal')->get();
		$LightIntensity = $this->dailyFeeding->where('flock_id','=',$flockId)->where('field_name','=','light_intensity')->get();
		$windVelocity = $this->dailyFeeding->where('flock_id','=',$flockId)->where('field_name','=','wind_velocity')->get();

		$flock = $this->flocks->where('flock_id','=',$flockId)->first();
		//calculate flock age
		$age_of_week = DB::table('flocks')->where('flock_id','=',$flockId)->select(DB::raw('CEIL(DATEDIFF(DATE(NOW()),DATE(arrival_date))/7) as bird_age'))->first();
		//

		return view('flocks.weeklyfeed', array('feeds'=>$feeds, 
												'flock'=>$flock, 
												'body_weight'=>$bodyWeight,
												'uniformity' => $uniformity,
												'manure_removal' =>$manureRemoval,
												'light_intensity'=>$LightIntensity,
												'wind_velocity'=>$windVelocity,
												'age_of_week' =>$age_of_week
											));	
	}

	public function storeWeeklyFeed($flockId){
		// Form Processing

		$this->dailyFeeding->fill(Input::all());
		
		$standardValue = DB::table('bookstandards')->where('week','=',$this->dailyFeeding->bird_age_week)->first();
		//flock Data to calculate bird age.
		$flockData = $this->flocks->where('flocks.flock_id','=',$flockId)->first();

		$this->dailyFeeding->bird_age_week = datediffInWeeks(Input::get('entry_date'),$flockData->arrival_date);

		$standardValue = DB::table('bookstandards')->where('week','=',$this->dailyFeeding->bird_age_week)->first();

		$this->dailyFeeding->standard_value = getStandardValue($standardValue,Input::get('field_name'));
		
        if ($this->dailyFeeding->isValid() ) {
        	if(!$this->dailyFeeding->feed_id || empty($this->dailyFeeding->feed_id) ){
        		$this->dailyFeeding->save();
        	} else { //update Flock Information.
        		$this->dailyFeeding->where('feed_id','=',$this->dailyFeeding->feed_id)
        					->update(array(
        							'flock_id'=>$this->dailyFeeding->flock_id,
        							'standard_value'=>$this->dailyFeeding->standard_value,
        							'entry_date' => $this->dailyFeeding->entry_date,
        							'field_name' => $this->dailyFeeding->field_name,
        							'field_value'=> $this->dailyFeeding->field_value,
        							'bird_age_week' => $this->dailyFeeding->bird_age_week,
        							'comment' => $this->dailyFeeding->comment,
        						));
        	}

            // Success!
        	  $this->toleranceRangeExceeded(Input::all(), $this->dailyFeeding->bird_age_week,$this->dailyFeeding->standard_value);
            if(empty(Input::get('feed_id')) ) {
	        	return $this->dailyFeeding->feed_id;
	        }else{
	        	return Input::get('feed_id');
	        }
        } else {

            return json_encode($this->dailyFeeding->errors);
            
        }	
	}

	public function editWeeklyFeed($feedId){
		$flock = $this->dailyFeeding->where('feed_id','=',$feedId)->get();

		return json_encode($flock);
	}

	public function deleteWeeklyFeed($feedId){
		if (!is_numeric($feedId)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }
        $res = $this->dailyFeeding->where('feed_id','=',$feedId)->update(array('status'=>'0'));
        if ( $res ) {
            
            return 1;

        } else {
            return 0;
        }
	}

	public function arrangeResultSet($result){
		$returnArray=array();
		foreach ($result as $row){

		}
	}

	public function informSectionHead($formData){
		Mail::send('emails.flock_assignment', $formData, function ($m) use ($formData) {
			
            $m->from('no-reply@roomifoods.com', 'Admin Roomi Foods');

            $m->to($formData['email'], $formData['doctor_id'])->subject('Flock '.$formData['display_id'].': assignment ');
        });

	}

	public function toleranceRangeExceeded($formData, $birdAge,$standardValue){
		//fetch range of tolerance for givent value.
		$range = DB::table('flock_tolerance_ranges')->where('flock_id','=',$formData['flock_id'])->where('key','=',$formData['field_name'])->first();

		//alert to managment
		if($formData['field_value'] > ($standardValue+$range->upper_limit) ||  $formData['field_value'] < ($standardValue-$range->lower_limit)){

			//get email addresses of all management
			$admins = DB::table('users')->where('users_groups.group_id','>=','2')->join('users_groups','users_groups.user_id','=','users.id')->get();
			//flock detailsed
			$flock = $this->flocks->where('flocks.flock_id','=',$formData['flock_id'])
					->leftJoin('users', 'users.id','=', 'flocks.user_id')					
					->select('flocks.*', 'users.first_name as doctor_id', 'users.email')
					->first();
			$formData['standard_value'] = $standardValue;
			// shoot Email
			Mail::send('emails.tolerance_exceed', $formData, function ($m) use ($flock,$admins) {
			
            $m->from('no-reply@roomifoods.com', 'Admin Roomi Foods');
            foreach($admins as $admin){
            	$m->cc($admin->email, $admin->first_name);
            }
            $m->to($flock->email, $flock->doctor_id)->subject('Flock '.$flock->display_id.': Passed Tolerance Range!');
        });
		}
		return true;

	}

	public function closeFlock($id){
		if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }
        $res = $this->flocks->where('flock_id','=',$id)->update(array('status'=>'2'));
        if ( $res ) {
            
            return 1;

        } else {
            return 0;
        }
	}

}
