<?php 
namespace database\seeds;

use Illuminate\Database\Seeder; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Role;

class RoleTableSeeder extends Seeder {

    public function run()
    {
        $owner = new Role();
		$owner->name         = 'owner';
		$owner->display_name = 'Project Owner'; // optional
		$owner->description  = 'User is the owner of the system can do anything'; // optional
		$owner->save();

		$admin = new Role();
		$admin->name         = 'admin';
		$admin->display_name = 'User Administrator'; // optional
		$admin->description  = 'User is allowed to manage and can perform all actions.'; // optional
		$admin->save();

		$employee = new Role();
		$employee->name         = 'employee';
		$employee->display_name = 'User Employee'; // optional
		$employee->description  = 'User is allowed to view Project management section and can only create tasks and comment on tasks.'; // optional
		$employee->save();
    }

}

?>