<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;


class Weeklyfeeding extends Model {

	//use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'weekly_flock_data';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['wk_id','flock_id', 'entry_date','field_name','field_value','bird_age_week','comment','status'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = ['password', 'remember_token'];
	protected $primaryKey = 'feed_id';

	public $errors;

	public $timestamps = false;
	
	public static $rules = array('flock_id'=>'required', 'entry_date'=>'required','field_name'=>'required','field_value'=>'required','bird_age_week'=>'required');

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
