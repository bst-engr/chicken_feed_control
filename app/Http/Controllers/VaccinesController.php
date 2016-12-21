<?php namespace App\Http\Controllers;

use \App\Vaccine;
use \App\Flock;
use \App\Vaccinehistory;

use Request;
// pagination
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

//response and view 
use Response;
use View, DB, Input, Mail;

// custom helper functions

class VaccinesController extends Controller {

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
	private $vaccines;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{	
		$this->vaccines = New Vaccine;
		$this->middleware('ssg.auth');
		//only admin can access this controller
       // $this->middleware('ssg.admin');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{	
		$vaccines = array();
		$vaccines= $this->vaccines->where('vaccines.status','=','1')->get();

		return view('vaccines.vaccines', array('vaccines'=>$vaccines));
	}

	public function store(){
		// Form Processing

		$this->vaccines->fill(Input::all());
		
		//$id = empty(Input::get('id')) ? false : Input::get('id');
		
        if ($this->vaccines->isValid() ) {
        	if(!$this->vaccines->vaccine_id || empty($this->vaccines->vaccine_id) ){
        		$this->vaccines->save();
        	} else { //update Flock Information.
        		$this->vaccines->where('vaccine_id','=',$this->vaccines->vaccine_id)
        					->update(array(
        							'vaccine_age'=>$this->vaccines->vaccine_age,
        							'vaccine_name' => $this->vaccines->vaccine_name,
        							'route'=> $this->vaccines->route,
        							'source'=> $this->vaccines->source,
        							'comments' => $this->vaccines->comments        							
        						));
        	}

            // Success!
        	
            if(empty(Input::get('vaccine_id')) ) {
	        	return $this->vaccines->vaccine_id;
	        }else{
	        	return Input::get('vaccine_id');
	        }
        } else {

            return json_encode($this->vaccines->errors);
            
        }
	}

	public function edit($id){
		$flock = $this->vaccines->where('vaccines.vaccine_id','=',$id)
					->select('vaccines.*')
					->get();

		return json_encode($flock);
	}

	public function destroy($id){
		if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }
        $res = $this->vaccines->where('vaccine_id','=',$id)->update(array('status'=>'0'));
        if ( $res ) {
            
            return 1;

        } else {
            return 0;
        }
	}

	public function vaccinationHistory($flockId){
		$flockObj= New Flock;
		$historyObj = New Vaccinehistory;
		$flock = $flockObj->where('flock_id','=',$flockId)->first();
		$vaccinationHistory= $historyObj->where('vaccination_history.flock_id','=',$flockId)
								->join('vaccines','vaccines.vaccine_id','=','vaccination_history.vaccine_id')
								->select('vaccination_history.*', 'vaccines.vaccine_name')
								->get();
		$vaccines=$this->vaccines->get();
		return view('vaccines.history', array('flock'=>$flock,'vaccines'=>$vaccines, 'vaccination_history'=>$vaccinationHistory));
	}

	public function saveHistory(){
		// Form Processing
		$historyObj = New Vaccinehistory;
		$historyObj->fill(Input::all());
		
		//$id = empty(Input::get('id')) ? false : Input::get('id');
		
        if ($historyObj->isValid() ) {
        	if(!$historyObj->history_id || empty($historyObj->history_id) ){
        		$historyObj->save();
        	} else { //update Flock Information.
        		$historyObj->where('history_id','=',$historyObj->history_id)
        					->update(array(
        							'flock_id'=>$historyObj->flock_id,
        							'vaccine_id' => $historyObj->vaccine_id,
        							'route'=> $historyObj->route,
        							'start_date'=> $historyObj->start_date,
        							'finish_date'=> $historyObj->finish_date,
        							'age_in_days'=> $historyObj->age_in_days
        						));
        	}

            // Success!
        	
            if(empty(Input::get('history_id')) ) {
	        	return $historyObj->history_id;
	        }else{
	        	return Input::get('history_id');
	        }
        } else {

            return json_encode($historyObj->errors);
            
        }
	}

	public function editHistory($id){
		$historyObj = New Vaccinehistory;
		$flock = $historyObj->where('vaccination_history.history_id','=',$id)
					->get();

		return json_encode($flock);
	}

	public function deleteHistory($id){
		$historyObj = New Vaccinehistory;
		if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }
        $res = $historyObj->where('history_id','=',$id)->update(array('status'=>'0'));
        if ( $res ) {
            
            return 1;

        } else {
            return 0;
        }
	}
	
}
