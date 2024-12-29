<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbilitySeeder extends Seeder
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
        DB::table('abilities')->truncate();

        // then seed
        DB::table('abilities')->insert([
            ['id' => 1, 'action' => 'index', 'subject' => 'Home'],
            ['id' => 2, 'action' => 'index', 'subject' => 'Role'],
            ['id' => 3, 'action' => 'create', 'subject' => 'Role'],
            ['id' => 4, 'action' => 'read', 'subject' => 'Role'],
            ['id' => 5, 'action' => 'update', 'subject' => 'Role'],
            ['id' => 6, 'action' => 'delete', 'subject' => 'Role'],
            ['id' => 7, 'action' => 'index', 'subject' => 'User'],
            ['id' => 8, 'action' => 'create', 'subject' => 'User'],
            ['id' => 9, 'action' => 'read', 'subject' => 'User'],
            ['id' => 10, 'action' => 'update', 'subject' => 'User'],
            ['id' => 11, 'action' => 'delete', 'subject' => 'User'],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
