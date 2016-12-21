<?php 
namespace database\seeds;

use Illuminate\Database\Seeder; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UserRoleTableSeeder extends Seeder {

    public function run()
    {
    	DB::table('role_user')->delete();

       	$owner = DB::table('users')->where('email', '=', 'owner@ssgfactory.com')->first();

		// role attach alias
		$owner->attachRole('1'); // parameter can be an Role object, array, or id

		// or eloquent's original technique
		$owner->roles()->attach('1'); // id only

		$admin = DB::table('users')->where('email', '=', 'admin@ssgfactory.com')->first();

		// role attach alias
		$admin->attachRole('2'); // parameter can be an Role object, array, or id

		// or eloquent's original technique
		$admin->roles()->attach('2'); // id only

		DB::table('permissions')->delete();

        $allPermission = new Permission();
		$allPermission->name         = 'all-permissions';
		$allPermission->display_name = 'Complete Access'; // optional
		// Allow a user to...
		$allPermission->description  = 'access to whole system'; // optional
		$allPermission->save();

		$owner = DB::table('users')->where('email','=','owner@ssgfactory.com')->first();
		$admin = DB::table('users')->where('email','=','admin@ssgfactory.com')->first();

		$admin->attachPermission($allPermission);
		// equivalent to $admin->perms()->sync(array($createPost->id));

		$owner->attachPermissions($allPermission);
		// equivalent to $owner->perms()->sync(array($createPost->id, $editUser->id));
    }

}

?>