<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            'id' => 1,
            'position' => 'main',
            'sort' => 1,
            'type' => 'container',
            'title' => 'Sample module - container',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('modules')->insert([
            'id' => 2,
            'parent_id' => 1,
            'sort' => 1,
            'type' => 'plaintext',
            'title' => 'Sample module - plain text',
            'attributes' => json_encode([
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam facilisis elit id congue dictum. Sed suscipit, justo ut vulputate gravida, erat nibh tempor dui, non mollis sem felis quis nisi.',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('modules')->insert([
            'id' => 3,
            'parent_id' => 1,
            'sort' => 2,
            'type' => 'richtext',
            'title' => 'Sample module - rich text',
            'attributes' => json_encode([
                'text' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam facilisis elit id congue dictum. Sed suscipit, justo ut vulputate gravida, erat nibh tempor dui, non mollis sem felis quis nisi. Donec sit amet vulputate quam. Morbi accumsan porttitor turpis sed mattis. Fusce lectus nisl, condimentum id enim quis, bibendum ornare justo. Pellentesque vitae neque ut dolor laoreet tristique. Aliquam elementum in purus vel ultricies. Aliquam volutpat vitae nisi eu posuere. Suspendisse finibus, tellus consectetur tristique gravida, enim massa tempor lectus, vel rutrum ante nibh sed augue. Aenean enim justo, imperdiet quis sapien efficitur, tristique gravida ante. Donec vulputate, tellus nec dignissim vulputate, felis lectus laoreet ante, id malesuada ligula diam nec ipsum. Suspendisse viverra tempus ipsum, eget condimentum orci congue vel. Praesent tempus lacinia lobortis.</p><p>Donec lectus lectus, suscipit et nisi ac, vehicula dapibus tellus. Cras id consequat dolor, et interdum eros. Donec molestie urna lacus, et molestie velit molestie condimentum. Nulla neque sapien, sagittis eu erat ac, venenatis placerat nulla. Integer ornare massa elementum hendrerit vulputate. Vivamus sit amet massa interdum, dictum lectus malesuada, vulputate massa. Sed dictum magna at ligula dapibus faucibus.</p>',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('module_page')->insert([
            'id' => 1,
            'module_id' => 1,
            'page_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
