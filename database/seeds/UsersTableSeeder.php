<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
        		'name' => 'Olakunle Odegbaro',
        		'email' => 'o.odegbaro@dreammesh.ng',
        		'password' => bcrypt('secret')
        ]);

        DB::table('users')->insert([
        		'name' => 'Admin Administrator',
        		'email' => 'admin@admin.com',
        		'password' => bcrypt('administrator')
        ]);
    }
}
