<?php

use Illuminate\Database\Seeder;

class TestAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array('first_name'=>'admin','last_name'=>'admin','email'=>'admin@admin.com','password'=>\Hash::make('12345678'),'profile_pic'=>'default.png');
        \App\Models\User::create($data)->assignRole(\Spatie\Permission\Models\Role::where('name','super-admin')->first());
    }
}
