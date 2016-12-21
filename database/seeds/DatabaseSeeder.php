<?php
use database\seeds\UserTableSeeder;
use database\seeds\RoleTableSeeder;
use database\seeds\UserRolesTableSeeder;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		//$this->call('UserTableSeeder');
		//$this->call('RoleTableSeeder');
		//$this->call('UserRolesTableSeeder');
	}

}
