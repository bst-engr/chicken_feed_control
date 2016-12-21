<?php namespace App\Http\Controllers;

use \App\Disease;
use Request;
// pagination
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

//response and view 
use Response;
use View, DB, Input, Mail;

// custom helper functions

class DiseasesController extends Controller {

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
	private $diseases;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{	
		$this->diseases = New Disease;
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
		$diseases = array();
		$diseases= $this->diseases->where('diseases.status','=','1')->get();

		return view('diseases.diseases', array('diseases'=>$diseases));;
	}

	public function store(){
		// Form Processing

		$this->diseases->fill(Input::all());
		
		//$id = empty(Input::get('id')) ? false : Input::get('id');
		
        if ($this->diseases->isValid() ) {
        	if(!$this->diseases->disease_id || empty($this->diseases->disease_id) ){
        		$this->diseases->save();
        	} else { //update Flock Information.
        		$this->diseases->where('disease_id','=',$this->diseases->disease_id)
        					->update(array(
        							'disease_name'=>$this->diseases->disease_name,
        							'common_name' => $this->diseases->common_name,
        							'description'=> $this->diseases->description,
        							'lower_limit'=> $this->diseases->lower_limit,
        							'upper_limit'=> $this->diseases->upper_limit,
        							
        						));
        	}

            // Success!
        	
            if(empty(Input::get('disease_id')) ) {
	        	return $this->diseases->disease_id;
	        }else{
	        	return Input::get('disease_id');
	        }
        } else {

            return json_encode($this->diseases->errors);
            
        }
	}

	public function edit($id){
		$flock = $this->diseases->where('diseases.disease_id','=',$id)
					->select('diseases.*')
					->get();

		return json_encode($flock);
	}

	public function destroy($id){
		if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }
        $res = $this->diseases->where('disease_id','=',$id)->update(array('status'=>'0'));
        if ( $res ) {
            
            return 1;

        } else {
            return 0;
        }
	}
	
}
