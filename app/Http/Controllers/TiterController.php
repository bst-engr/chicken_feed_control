<?php namespace App\Http\Controllers;

use \App\Flock;
use \App\User;
use \App\Vaccine;
use \App\Vaccinehistory;
use \App\Titer;

use Request;
// pagination
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

//response and view 
use Response;
use View, DB, Input, Mail;

// custom helper functions

class TiterController extends Controller {

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
	private $flocks, $user, $titers, $vaccines, $vaccinehistory;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{	
		$this->middleware('ssg.auth');
		$this->titers = New Titer;
		//only admin can access this controller
        //$this->middleware('ssg.admin');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	
	public function titers($flockId){
		// $this->vaccines = New Vaccine;
		// $vaccines = $this->vaccines->get();
		// $flocks = $this->getFlocks();
		$titers = $this->titers->where('flock_id','=',$flockId)
								->join('diseases','diseases.disease_id','=','titers.disease_id')
								->select('titers.*','diseases.disease_name')
								->get();
		$diseases = DB::table('diseases')->get();
		$this->flocks=New Flock;
		$flocks = $this->flocks->where('flock_id','=',$flockId)->where('status','=','1')->first();
		
		return view('titer.titers', array('flock'=>$flocks,'titers'=>$titers,'diseases'=>$diseases));
	}

	public function titerStore(){
		// Form Processing

		$this->titers->fill(Input::all());
		
		//$id = empty(Input::get('id')) ? false : Input::get('id');
		$this->titers->flock_age='';
		if ($this->titers->isValid() ) {
        	if(!$this->titers->titer_id || empty($this->titers->titer_id) ){
        		$this->titers->save();
        		$this->titers->saveTiterDetails(Input::all(),$this->titers->titer_id);
        		
        	} else { //update Flock Information.
        		$this->titers->where('titer_id','=',$this->titers->titer_id)
        					->update(array(
        							'flock_id'=>$this->titers->flock_id,
        							'date' => $this->titers->date,
        							'lab_name' => $this->titers->lab_name,
        							'disease_id'=> $this->titers->disease_id,
        							'average'=>$this->titers->average,
        							'flock_age' => $this->titers->flock_age,
        							'range' =>$this->titers->range
        						));
        		$this->titers->saveTiterDetails(Input::all(),$this->titers->titer_id);
        	}

            // Success!
        	
            if(empty(Input::get('titer_id')) ) {
            	//$this->informSectionHead(Input::all());
	        	return $this->titers->titer_id;
	        }else{
	        	return Input::get('titer_id');
	        }
        } else {

            return json_encode($this->titers->errors);
            
        }
	}

	public function editTiter($titer){
		$titerd = $this->titers->where('titer_id','=',$titer)->first();
		$titer_detail = DB::table('titer_details')->where('titer_id','=',$titer)->get();
		$returnData[] = array('titer'=>$titerd,'titerDetail'=>$titer_detail);
		return json_encode($returnData);
	}

	public function deleteTiter($id){
		if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }
        $res = $this->titers->where('titer_id','=',$id)->update(array('status'=>'0'));
        if ( $res ) {
            
            return 1;

        } else {
            return 0;
        }
	}
	
	public function vacComparison()
	{	
		$this->vaccines = New Vaccine;
		$vaccines = $this->vaccines->get();
		$flocks = $this->getFlocks();
		$this->flocks=New Flock;
		$existingFlocks = $this->flocks->where('status','=','1')->get();
		
		return view('titer.comparison', array('vaccines'=>$vaccines,'flocks'=>$flocks, 'existingFlocks'=>$existingFlocks));;
	}

	protected function getFlocks(){
		$this->flocks=New Flock;
		$flocks = $this->flocks->where('status','=','1')->get();
		$returnFlock=array();
		foreach($flocks as $flock){
			$returnFlock[$flock->display_id] = $this->vaccineHistory($flock->flock_id);
		}
		return $returnFlock;
	}

	protected function vaccineHistory($flockId){
		$this->vaccinehistory = New Vaccinehistory;
		$history = $this->vaccinehistory->where('flock_id','=',$flockId)->get();
		
		$returnHistory=array();
		foreach($history as $row){
			$returnHistory[$row->vaccine_id] = array('start_date'=>$row->start_date,'finish_date'=>$row->finish_date,'age_in_days'=>$row->age_in_days);
		}
		return $returnHistory;
	}

	
	
}
