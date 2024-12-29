<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        // empty data first
        DB::table('roles')->truncate();

        // then seed
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Super Admin'],
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
