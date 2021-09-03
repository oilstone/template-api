<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @noinspection SpellCheckingInspection
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'id' => 'vXfom79m1toQ4JLr',
            'name' => 'OS Local access client',
            'secret' => 'CQp9s5orIppPlOGmWkd6yrtScl353nxAw7TlsNt06NAOcUtSqF4Vh2gAQ4ElNMsA4ZCzbVY6bw15qUFTnNCicv3me3tmsx72OW11',
        ]);
    }
}
