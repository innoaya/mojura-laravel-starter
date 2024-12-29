<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AbilitySeeder::class);
        $this->call(RoleAbilitySeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
