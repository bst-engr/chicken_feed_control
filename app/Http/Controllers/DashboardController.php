<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
// pagination
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use \App\Dashboard;
//response and view 
use Response;
use View, DB, Input, Mail;
use Sentry;


class DashboardController extends Controller {

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
	private $board, $employee;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{	

		//checking for authentication
        $this->middleware('ssg.auth');
        //only admin can access this controller
        //$this->middleware('ssg.admin');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{	
		$dashboard = new Dashboard;
		$data = $dashboard->getFlocksData();
		return view('dashboard.index', $data);
	}

	public function checkTodayRecord(){
		$dashboard = new Dashboard;
		$data = $dashboard->getTodayRecord(Input::get('field'));
		echo json_encode($data);
	}

	
}
