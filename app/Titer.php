<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator, DB;


class Titer extends Model {

	//use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'titers';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['titer_id','flock_id','date','lab_name','disease_id','range','average','flock_age', 'titer_cv'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = ['password', 'remember_token'];
	protected $primaryKey = 'titer_id';

	public $errors;

	public $timestamps = false;
	
	public static $rules = array('flock_id'=>'required','date'=>'required','lab_name'=>'required','disease_id'=>'required','average'=>'required', 'titer_cv'=>'required');

	 /* The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	

	/*
	*	Funciton is responsibile to validate the form Data
	*/

	public function isValid(){

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
	}

	public function saveTiterDetails($formData,$isUpdate = false){
		
		$titerDetail=array();
			//$data = $formData;
			for ($i=1; $i <=count($formData['marking']) ; $i++) { 
				// echo ">>>$key";
				//var_dump((array)$formData['individual_titers'][$i]);
				$titerDetail[] = array('titer_id'=>$this->titer_id,'sample_tested'=>$formData['sample_tested'][$i],'individual_value'=>isset($formData['individual_titers'][$i]) ? implode(",", (array)$formData['individual_titers'][$i]) : '');
				
			}
			DB::table('titer_details')->insert($titerDetail);
		
		return true;
	}

}
