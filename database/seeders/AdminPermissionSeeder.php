<?php

use Illuminate\Database\Seeder;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     public $roles=[
     	[
     		'name'=>'super-admin',
     		'label'=>'Super Admin'
    	],
    	[
     		'name'=>'admin',
     		'label'=>'Admin'
    	],
    	[
     		'name'=>'agent',
     		'label'=>'Agent'
    	],
    	[
     		'name'=>'user',
     		'label'=>'User'
    	],
     ];
    public function run()
    {
        foreach ($this->roles as $value) {
        	if(! \Spatie\Permission\Models\Permission::where('name',$value['name'])->exists()){
        		\Spatie\Permission\Models\Permission::create($value);
        	}
        }
    }
}
