<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use app\Models\SocialMedia;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        SocialMedia::create([
            'facebook' => '',
            'instagram' => '',
            'tiktok' => '',
            'mail' => '',
            'bklive' => '',
        ]);
    }
}
