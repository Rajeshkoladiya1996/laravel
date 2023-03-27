<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HotTagSetting;

class HotTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public $data=array('followers'=>'0','salmon_coin'=>'0');
    public function run()
    {
        HotTagSetting::create([
            'followers' => '0',
            'salmon_coin' => '0'
        ]);
        // \App\Models\HotTagSetting::create($data);
    }
}
