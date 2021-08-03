<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
        ->insert([
            'fullname' => "Admin admin",
            'email' => "admin@gmail.com",
            'password' => Hash::make("admin123"),
            'password_confirmation' => Hash::make("admin123"),
            'role_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
