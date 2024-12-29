<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // empty all data
        DB::table('users')->truncate();

        // then seed
        DB::table('users')->insert([
            ['id' => 1, 'username' => 'superadmin', 'password' => Hash::make('superadmin'), 'full_name' => 'Super Administrator', 'role_id' => 1, 'status' => 'ACTIVE'],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
