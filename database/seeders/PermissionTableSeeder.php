<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
        	// user permissions
          	[	
          		'name'=>'user-list',
          		'label'=>'User List'
      		],
          	[	
          		'name'=>'user-create',
          		'label'=>'User Create'
      		],
          	[	
          		'name'=>'user-edit',
          		'label'=>'User Edit'
      		],
            [	
          		'name'=>'user-delete',
          		'label'=>'User Delete'
      		],
      		[	
          		'name'=>'user-assing-gems',
          		'label'=>'User Assing Gems'
      		],
            [ 
                'name'=>'user-reset-password',
                'label'=>'User Reset Password'
            ],
            [   
                'name'=>'user-audit-logs',
                'label'=>'User Audit Logs'
            ],
            [   
                'name'=>'user-request-list',
                'label'=>'User Request List'
            ],
            [   
                'name'=>'user-request-actions',
                'label'=>'User Request Actions'
            ],
      		// streamer permissions
      		[	
          		'name'=>'stream-list',
          		'label'=>'Stream List'
      		],
            [ 
                'name'=>'stream-View',
                'label'=>'Stream View'
            ],
            // Subadmin permissions
            [ 
                'name'=>'subadmin-list',
                'label'=>'Subadmin List'
            ],
            [ 
                'name'=>'subadmin-create',
                'label'=>'Subadmin Create'
            ],
            [ 
                'name'=>'subadmin-edit',
                'label'=>'Subadmin Edit'
            ],
            [ 
                'name'=>'subadmin-delete',
                'label'=>'Subadmin Delete'
            ],
            [ 
                'name'=>'subadmin-delete',
                'label'=>'Subadmin Delete'
            ],
            [ 
                'name'=>'subadmin-reset-password',
                'label'=>'Subadmin Reset Password'
            ],
            // Subadmin permissions
            [ 
                'name'=>'agent-list',
                'label'=>'Agent List'
            ],
            [ 
                'name'=>'agent-create',
                'label'=>'Agent Create'
            ],
            [ 
                'name'=>'agent-edit',
                'label'=>'Agent Edit'
            ],
            [ 
                'name'=>'agent-delete',
                'label'=>'Agent Delete'
            ],
            [ 
                'name'=>'agent-delete',
                'label'=>'Agent Delete'
            ],
            [ 
                'name'=>'agent-reset-password',
                'label'=>'Agent Reset Password'
            ],
            [   
                'name'=>'agent-assing-gems',
                'label'=>'Agent Assing Gems'
            ],
            // Gift permissions
            [ 
                'name'=>'gift-list',
                'label'=>'Gift List'
            ],
            [ 
                'name'=>'gift-create',
                'label'=>'Gift Create'
            ],
            [ 
                'name'=>'gift-edit',
                'label'=>'Gift Edit'
            ],
            [ 
                'name'=>'gift-delete',
                'label'=>'Gift Delete'
            ],
            [ 
                'name'=>'gift-delete',
                'label'=>'Gift Delete'
            ],
            // Financial permissions
            [ 
                'name'=>'gems-calculation',
                'label'=>'Gems Calculation'
            ],
            [ 
                'name'=>'diamond-to-cash',
                'label'=>'Diamond to Cash'
            ],
            [ 
                'name'=>'paid-out-streamers',
                'label'=>'Paid Out Streamers'
            ],
            [ 
                'name'=>'gems-Top-up-list',
                'label'=>'Gems Top-up List'
            ],
            [ 
                'name'=>'agent-Top-up-list',
                'label'=>'Agent Top-up List'
            ],
            // Level permissions
            [ 
                'name'=>'level-list',
                'label'=>'Level List'
            ],
            [ 
                'name'=>'level-create',
                'label'=>'Level Create'
            ],
            [ 
                'name'=>'level-edit',
                'label'=>'Level Edit'
            ],
            [ 
                'name'=>'level-delete',
                'label'=>'Level Delete'
            ],
            [ 
                'name'=>'level-delete',
                'label'=>'Level Delete'
            ],
            
       	];
       	foreach ($permissions as $permission) {
       		if(! Permission::where('name',$permission['name'])->exists()){
        		Permission::create($permission);
        	}
        }
    }
}
