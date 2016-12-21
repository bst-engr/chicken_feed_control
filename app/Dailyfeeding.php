<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use DB;


class Dailyfeeding extends Model {

	//use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'dailyfeeding';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['feed_id','flock_id', 'entry_date','field_name','field_value','bird_age_week','comment','reasons','standard_value','status'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = ['password', 'remember_token'];
	protected $primaryKey = 'feed_id';

	public $errors;

	public $timestamps = false;
	
	public static $rules = array('flock_id'=>'required', 'entry_date'=>'required','field_name'=>'required','field_value'=>'required|numeric','bird_age_week'=>'required');

	public static $messages = [
				'regex' => 'Only numbers are allowed in this field',
			];
	 /* The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	

	/*
	*	Funciton is responsibile to validate the form Data
	*/

	public function isValid($entryType='daily'){

		//check last Day Entry
		$lastDayC = false;//$this->checkLastDayEntry($this->field_name,$this->entry_date,$entryType);
		$uniqueC = $this->checkDateEntry($this->entry_date,$this->field_name, $this->flock_id, $this->feed_id);
		if(!$lastDayC && !$uniqueC){
			// mkaing validations
			$validator = Validator::make($this->attributes, static::$rules);
			
			// check if validation passes
			if($validator->passes()){

				return true;

			} else {

				// setting up error messages.
				$this->errors = $validator->messages();
				return false;
			}
		} else{
			if($lastDayC){
				$this->errors = $lastDayC;
			} else if($uniqueC) {
				$this->errors = $uniqueC;
			}
		}
	}

	public function checkDateEntry($entry_date,$field_name, $flock_id, $entry_id=false){
		$check = $this->where('field_name','=',$field_name)
						->where('entry_date','=',$entry_date)
						->where('flock_id','=',$flock_id);
		if($entry_id!=null){
			$check = $check->where('feed_id','!=',$entry_id);
		}
		
		$check = $check->first();

		if($check == null){
			return false;
		} else {
			return array('entry_date'=>array('Data Already exists for '.$entry_date.''));
		}
	}

	public function addMortalityDetails($formData, $feed_id, $isUpdate=false){
		$disease= $formData['reason'];
		$reasons = json_encode($disease);

    	$diseaseIds= $formData['reason_id'];
		if($isUpdate == false){
			$mortalityDetail= array();
	    	foreach ($diseaseIds as $key=>$value) {
	    		if($diseaseIds)
	        	$mortalityDetail[]=array('flock_id'=>$formData['flock_id'],'feed_id'=>$feed_id,'reason_id'=>$value,'no_of_birds'=>(int)$disease[$key]);
	        }

	        DB::table('mortality_details')->insert($mortalityDetail);
		} else {
			$mortalityDetail= array();
	    	foreach ($diseaseIds as $key=>$value) {
	    		if($diseaseIds)
	        	$mortalityDetail=array('flock_id'=>$formData['flock_id'],'feed_id'=>$feed_id,'reason_id'=>$value,'no_of_birds'=>(int)$disease[$key]);
	        	DB::table('mortality_details')->where('feed_id','=',$feed_id)->where('flock_id','=',$formData['flock_id'])->where('reason_id','=',$value)->update($mortalityDetail);
	        }
		}

		return true;

	}

	public function checkLastDayEntry($fieldName, $entryDate, $entryType = 'daily'){

		$entryDate = strtotime($entryDate);
		if($entryType == 'daily'){
			$lastDay = $entryDate - (60*60*24);
			$flockId = $this->flock_id;
			$flock = DB::table('flocks')->where('flock_id','=',$flockId)->first();
			$fDate = $flock->arrival_date;

			$row = $this->where('field_name','=',$fieldName)->where('entry_date','=',date("Y-m-d",$lastDay))->first();
			if($row!=null){
				return false;
			} else {
				if(strtotime($fDate) == $entryDate ){
					return false;
				} else if (strtotime($fDate) > $entryDate){
					return array('entry_date'=>array('can not add data before flock arrival Date'));
				} else {
					return array('entry_date'=>array('Entry for '.date("Y-m-d",$lastDay).' is missing'));
				}
			}
		} else if ($entryType == 'weekly'){
			$lastDay = $entryDate - (60*60*24*7);
			$flockId = $this->flock_id;
			$flock = DB::table('flocks')->where('flock_id','=',$flockId)->first();
			$fDate = $flock->arrival_date;

			$row = $this->where('field_name','=',$fieldName)->where('entry_date','=',date("Y-m-d",$lastDay))->first();
			if($row!=null){
				
			} else {
				if(strtotime($fDate) == $entryDate ){
					return false;
				} else if (strtotime($fDate) > $entryDate){
					return array('entry_date'=>array('can not add data before flock arrival Date'));
				} else {
					return array('entry_date'=>array('Entry for '.date("Y-m-d",$lastDay).' is missing'));
				}
				
			}
		}
	}

	public function addTempratureDetails($formData, $feed_id, $isUpdate=false){
		$tempratureDetails=array('flock_id'=>$formData['flock_id'],
									'feed_id'=>$feed_id,
									'inner_max'=>$formData['inner_max'],
									'inner_min'=>$formData['inner_min'],
									'outter_max'=>$formData['outter_max'],
									'outter_min'=>$formData['outter_min'],
									'avg'=>$formData['field_value'],
									'feeling'=>$formData['feeling']
									);

		if($isUpdate == false){
			DB::table('temperature_details')->insert($tempratureDetails);
		} else {
			DB::table('temperature_details')->where('feed_id','=', $feed_id)->update($tempratureDetails);
		}
		return true;
	}

	public function addHumidityDetails($formData, $feed_id, $isUpdate=false){
		$tempratureDetails=array('flock_id'=>$formData['flock_id'],'feed_id'=>$feed_id,'inner_humidity'=>$formData['inner_humidity'],'outter_humidity'=>$formData['outter_humidity']);

		if($isUpdate == false){
			DB::table('humidity_details')->insert($tempratureDetails);
		} else {
			DB::table('humidity_details')->where('feed_id','=', $feed_id)->update($tempratureDetails);
		}
		return true;
	}

}
