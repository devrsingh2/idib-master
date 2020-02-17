<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'name'           => 'IDIB MASTER',
            'username'       => 'idibtool',
            'email'          => 'idibtool@gmail.com',
            'password'       => Hash::make('Pass@123'),
            'account_status' => 1,
            'email_verified' => '1',
            'isAdmin'        => 1,
            'user_type'      => '1',
        ]);

        DB::table('users')->insert([
            'name'           => 'Ramesh Singh',
            'username'       => 'rsingh2',
            'email'          => 'rsingh2@katalysttech.com',
            'password'       => Hash::make('Pass@123'),
            'account_status' => 1,
            'email_verified' => '1',
            'isAdmin'        => 1,
            'user_type'      => '1',
        ]);
    }
}
