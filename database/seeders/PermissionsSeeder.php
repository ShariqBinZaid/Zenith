<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [[
            'name' => 'add leads',
            'guard_name' => 'api',
        ],[
            'name' => 'update leads',
            'guard_name' => 'api',
        ],[
            'name' => 'view leads',
            'guard_name' => 'api',
        ],[
            'name' => 'delete leads',
            'guard_name' => 'api',
        ],[
            'name' => 'assign leads',
            'guard_name' => 'api',
        ],[
            'name' => 'view inactive users',
            'guard_name' => 'api',
        ],[
            'name' => 'create users',
            'guard_name' => 'api',
        ],[
            'name' => 'update users',
            'guard_name' => 'api',
        ],[
            'name' => 'inactive users',
            'guard_name' => 'api',
        ],[
            'name' => 'view users',
            'guard_name' => 'api',
        ],[
            'name' => 'assign opportunities',
            'guard_name' => 'api',
        ],[
            'name' => 'edit opportunities',
            'guard_name' => 'api',
        ],[
            'name' => 'update opportunities',
            'guard_name' => 'api',
        ],[
            'name' => 'view opportunities',
            'guard_name' => 'api',
        ],[
            'name' => 'delete opportunities',
            'guard_name' => 'api',
        ],[
            'name' => 'add opportunities',
            'guard_name' => 'api',
        ],[
            'name' => 'add brands',
            'guard_name' => 'api',
        ],[
            'name' => 'update brands',
            'guard_name' => 'api',
        ],[
            'name' => 'view brands',
            'guard_name' => 'api',
        ],[
            'name' => 'delete brands',
            'guard_name' => 'api',
        ],[
            'name' => 'edit packages',
            'guard_name' => 'api',
        ],[
            'name' => 'update packages',
            'guard_name' => 'api',
        ],[
            'name' => 'delete packages',
            'guard_name' => 'api',
        ],[
            'name' => 'convert opportunity to project',
            'guard_name' => 'api',
        ],
        [
            'name' => 'view projects',
            'guard_name' => 'api',
        ],[
            'name' => 'edit projects',
            'guard_name' => 'api',
        ],[
            'name' => 'update projects',
            'guard_name' => 'api',
        ],[
            'name' => 'delete projects',
            'guard_name' => 'api',
        ],
        [
            'name' => 'view teams',
            'guard_name' => 'api',
        ],[
            'name' => 'update teams',
            'guard_name' => 'api',
        ],[
            'name' => 'delete teams',
            'guard_name' => 'api',
        ],[
            'name' => 'create teams',
            'guard_name' => 'api',
        ],
        [
            'name' => 'add teams member',
            'guard_name' => 'api',
        ]
    ];
        Permission::insert($permission);
    }
}
