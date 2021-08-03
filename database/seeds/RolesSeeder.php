<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')
        ->insert([
            'role_name' => "Admin",
            'description' => "Admin Account",
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
