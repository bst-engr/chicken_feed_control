<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;


class Flockstandards extends Model {

	//use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'flock_standards';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['flock_id','week','feed','water_consumption','mortality','temprature','humidity','egg_weight','egg_production','body_weight','uniformity','manure_removal','light_intensity','wind_velocity'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = ['password', 'remember_token'];
	protected $primaryKey = 'standard_id';

	public $errors;

	public $timestamps = false;
	
	public static $rules = array('flock_id'=>'required','week'=>'required','feed'=>'required','water_consumption'=>'required','mortality'=>'required','temprature'=>'required','humidity'=>'required','egg_weight'=>'required','egg_production'=>'required','body_weight'=>'required','uniformity'=>'required','manure_removal'=>'required','light_intensity'=>'required','wind_velocity'=>'required');

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
