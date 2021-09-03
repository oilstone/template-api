<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'id' => 1,
            'lookup' => 'administrator',
            'title' => 'Administrator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('user_roles')->insert([
            'id' => 2,
            'lookup' => 'marketing',
            'title' => 'Marketing',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
