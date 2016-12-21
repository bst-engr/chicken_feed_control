<?php namespace App\Http\Controllers;

use \App\Mortalityreasons;
use Request;
// pagination
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

//response and view 
use Response;
use View, DB, Input, Mail;

// custom helper functions

class MortalityController extends Controller {

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
	private $mortalities;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{	
		$this->mortalities = New Mortalityreasons;
		$this->middleware('ssg.auth');
		//only admin can access this controller
        $this->middleware('ssg.admin');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{	
		$mortalities = array();
		$mortalities= $this->mortalities->where('status','=','1')->get();

		return view('mortalities.mortalities', array('mortalities'=>$mortalities));;
	}

	public function store(){
		// Form Processing

		$this->mortalities->fill(Input::all());
		
		//$id = empty(Input::get('id')) ? false : Input::get('id');
		
        if ($this->mortalities->isValid() ) {
        	if(!$this->mortalities->id || empty($this->mortalities->id) ){
        		$this->mortalities->save();
        	} else { //update Flock Information.
        		$this->mortalities->where('id','=',$this->mortalities->id)
        					->update(array(
        							'reason_name'=>$this->mortalities->reason_name
        						));
        	}

            // Success!
        	
            if(empty(Input::get('id')) ) {
	        	return $this->mortalities->id;
	        }else{
	        	return Input::get('id');
	        }
        } else {

            return json_encode($this->mortalities->errors);
            
        }
	}

	public function edit($id){
		$flock = $this->mortalities->where('id','=',$id)
					->select('mortality_reasons.*')
					->get();

		return json_encode($flock);
	}

	public function destroy($id){
		if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }
        $res = $this->mortalities->where('id','=',$id)->update(array('status'=>'0'));
        if ( $res ) {
            
            return 1;

        } else {
            return 0;
        }
	}
	
}
