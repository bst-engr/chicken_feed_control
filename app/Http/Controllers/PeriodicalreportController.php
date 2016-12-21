<?php namespace App\Http\Controllers;

use \App\Periodicalreport;
use Request;
// pagination
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

//response and view 
use Response;
use View, DB, Input, Mail;

// custom helper functions

class PeriodicalreportController extends Controller {

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
	private $reports;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{	
		$this->reports = New Periodicalreport;
		$this->middleware('ssg.auth');
		//only admin can access this controller
        //$this->middleware('ssg.admin');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index($id)
	{	
		$reports = array();
		$reports= $this->reports->where('flock_id','=',$id)->where('periodical_reports.status','=','1')->get();
		$flock = DB::table('flocks')->where('flock_id','=',$id)->first();

		return view('periodicalReports.reports', array('reports'=>$reports,'flock'=>$flock));
	}

	public function store(){
		// Form Processing
				
		$this->reports->fill(Input::all());
		$this->reports->attachment = '';
		if(Input::hasFile('attachment')){
			$fileName = time().'.'.Input::file('attachment')->getClientOriginalExtension();
			$this->reports->attachment = $fileName;
		
			$this->reports->attachment = Input::file('attachment')->move(base_path() . '/public/images/catalog/', $fileName);
		} 
		//$id = empty(Input::get('id')) ? false : Input::get('id');
        if ($this->reports->isValid() ) {
        	if(!$this->reports->report_id || empty($this->reports->report_id) ){
        		$this->reports->save();
        	} else { //update Flock Information.
        		$this->reports->where('report_id','=',$this->reports->report_id)
        					->update(array(
        							'attachment'=>$this->reports->attachment,
        							'title' => $this->reports->title,
        							'description'=> $this->reports->description,
        							'type'=> $this->reports->type,
        							'entry_date'=> $this->reports->entry_date,
        							
        						));
        	}

            // Success!
        	
            if(empty(Input::get('report_id')) ) {
	        	return $this->reports->report_id;
	        }else{
	        	return Input::get('report_id');
	        }
        } else {

            return json_encode($this->reports->errors);
            
        }
	}

	public function edit($id){
		$flock = $this->reports->where('report_id','=',$id)
					->select('periodical_reports.*')
					->get();

		return json_encode($flock);
	}

	public function destroy($id){
		if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }
        $res = $this->reports->where('report_id','=',$id)->update(array('status'=>'0'));
        if ( $res ) {
            
            return 1;

        } else {
            return 0;
        }
	}
	
}
