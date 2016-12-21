<?php namespace App\Library;

class Ssg {
	//get all available roles
	public static function getAllRoles()
	{
		return \Sentinel\Models\Group::all();
	}

	//added new user
	public static function addNewUser($credentials, $role) {

		//check for email existense in users table
		$model = \App\User::where('email', $credentials['email'])->first();
		$user = false;
		if(is_null($model)) {
			$user = \Sentry::register($credentials); //register user

			//register user role
			$user_id = $user->id;
			\DB::table('users_groups')->insert([
				'user_id' => $user_id,
				'group_id' => $role
			]);
		}

		return $user;
	}

	//get information of employee by id
	public static function getEmpInfoById($id = 0) {
		$result = \App\Employee::find($id);
		return $result;
	}

	//get employee roles
	public static function getEmpRole($id = 0) {
		$result = \DB::table('employees')
				->join('users','users.email','=','employees.email')
				->join('users_groups','users_groups.user_id','=', 'users.id')
				->join('groups','groups.id','=', 'users_groups.group_id')
				->where('employees.id', $id)
				->select('groups.id', 'groups.name')
				->first();
		return $result;
	}

	//get related projects of user with provided id
	public static function getRelatedProjects($id) {
		$result = array();
		$info = self::getEmpInfoById($id);
		if(!is_null($info)) {
			if($info->is_specialist) {
				$result = \DB::table('projects')
						->join('employees','employees.id','=','projects.specialist_id')
						->where('projects.specialist_id', $id)
						->where('projects.status', 1)
						->get();
			} else {
				$result = \DB::table('projects')
						->join('employees','employees.id','=','projects.specialist_id')
						->join('project_team','project_team.project_id','=','projects.project_id')
						->where('project_team.employee_id', $id)
						->where('projects.status', 1)
						->get();
			}
		}
		return $result;
	}

	//check for the access rights of provided user for provided project
	public static function checkAccessRight($userid, $projectid) {
		if(\Sentry::getUser()->hasAccess('admin')) {
			return true;
		} else {
			$resultOne = \DB::table('projects')
						->where('project_id', $projectid)
						->where('specialist_id', $userid)
						->get();
			if(empty($resultOne)){

				$resultTwo = \DB::table('project_team')
							->where('project_id', $projectid)
							->where('employee_id', $userid)
							->get();
				if(empty($resultTwo)) {

					return false;
				} else {

					return true;
				}

			} else {

				return true;
			}
		}
	}

	//get project info by id
	public static function getProjectInfo($id) {
		$result = \DB::table('projects')
					->where('projects.project_id','=', $id)
					->join('employees', 'employees.id','=', 'projects.specialist_id')
					->first();
		return $result;
	}

	//get provided project's team
	public static function getProjectTeam($id) {
		$result = \DB::table('project_team')
					->where('project_team.project_id','=', $id)
					->join('employees', 'employees.id','=', 'project_team.employee_id')
					->select('employees.id', 'employees.emp_id','employees.resource_name', 'employees.location', 'employees.email', 'employees.skype')
					->get();
		return $result;
	}

	//get provided project's specialist
	public static function getProjectSpecialist($id) {
		$result = \DB::table('projects')
					->where('projects.project_id','=', $id)
					->join('employees', 'employees.id','=', 'projects.specialist_id')
					->first();
		return $result;
	}

	//get borad skill
	public static function getBoardSkill($id) {
		$result = \DB::table('specialist_boards')
					->join('skills', 'skills.skill_id','=', 'specialist_boards.skill_id')
					->where('specialist_boards.board_id','=', $id)
					->first();
		return $result;
	}

	//get provided board's trainees info
	public static function getBoardTeam($id) {
		$result = \DB::table('specialist_trainees')
					->join('employees', 'employees.id','=', 'specialist_trainees.trainee_id')
					->where('specialist_trainees.board_id','=', $id)
					->select('employees.id', 'employees.emp_id','employees.resource_name', 'employees.location', 'employees.email', 'employees.skype')
					->get();
		return $result;
	}

	//get all specialists
	public static function getAllSpecialists() {
		$result = \App\Employee::where('is_specialist', 1)->orderby('resource_name', 'asc')->get();
		return $result;
	}

	//get total number of hours and extra hours of given employee in given month
	public static function getTotalHours($empid, $date) {
		$countHour = 0;
		$countExtraHour = 0;
		$sql = "select * from `timelog` where `employee_id` = $empid AND MONTH(date) = MONTH('$date') AND YEAR(date) = YEAR('$date')";
		$result = \DB::select($sql);
		if(!empty($result)) {
			foreach($result as $entry) {
				$countHour = $countHour + $entry->hours;
				$countExtraHour = $countExtraHour + $entry->extra_hours;
			}
		}

		$return = array(
			'hours' => $countHour,
			'extra' => $countExtraHour
		);
		return $return;
	}


}//End of class