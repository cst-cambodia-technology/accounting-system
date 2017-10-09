<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'title'      	=> 	'System Administrator',
        	'givenName'		=> 	'System',
        	'familyName'   	=> 	'Admin',
        	'displayName'  	=> 	'System Admin',
        	'email'      	=> 	'system.admin@system.com',
        	'password'      => 	bcrypt('123456'),
        	'status'		=>	'Active'
        ]);
    }
}
