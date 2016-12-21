<?php 
namespace database\seeds;

use Illuminate\Database\Seeder; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([['name' => 'owner', 'email'=>'owner@ssgfactory.com','password'=> Hash::make('owner123')],['name' => 'admin', 'email'=>'admin@ssgfactory.com','password'=> Hash::make('admin123')]]);
    }

}

?>