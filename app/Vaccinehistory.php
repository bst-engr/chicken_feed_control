<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;


class Vaccinehistory extends Model {

	//use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'vaccination_history';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['history_id','flock_id', 'vaccine_id','route','start_date','finish_date','age_in_days'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = ['password', 'remember_token'];
	protected $primaryKey = 'history_id';

	public $errors;

	public $timestamps = false;
	
	public static $rules = array('flock_id'=>'required', 'vaccine_id'=>'required','route'=>'required','start_date'=>'required','finish_date'=>'required','age_in_days'=>'required');

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

}
