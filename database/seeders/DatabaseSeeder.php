<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            OAuthSeeder::class,
            UserRoleSeeder::class,
            UserSeeder::class,
            PageSeeder::class,
            ModuleSeeder::class,
        ]);
    }
}
