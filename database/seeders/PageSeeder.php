<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            'id' => 1,
            'language' => 'en',
            'is_published' => 1,
            'title' => 'About',
            'slug' => 'about',
            'publish_at' => Carbon::tomorrow(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pages')->insert([
            'id' => 2,
            'language' => 'es',
            'translates_id' => 1,
            'is_published' => 1,
            'title' => 'Acerca de',
            'slug' => 'acerca-de',
            'publish_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
