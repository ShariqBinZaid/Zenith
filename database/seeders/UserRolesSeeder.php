<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userroles = [[
            'name' => 'superadmin',
            'guard_name' => 'api'
        ],[
            'name' => 'admin',
            'guard_name' => 'api'
        ],
        [
            'name' => 'business_unit_head',
            'guard_name' => 'api'
        ],
        [
            'name' => 'front_sales_manager',
            'guard_name' => 'api'
        ],
        [
            'name' => 'front_sales_executive',
            'guard_name' => 'api'
        ],[
            'name' => 'project_manager',
            'guard_name' => 'api'
        ],[
            'name' => 'support_manager',
            'guard_name' => 'api'
        ],[
            'name' => 'support_agent',
            'guard_name' => 'api'
        ],
        [
            'name' => 'quality_assurance_manager',
            'guard_name' => 'api'
        ],
        [
            'name' => 'quality_assurance_executive',
            'guard_name' => 'api'
        ],
        [
            'name' => 'human_resource_manager',
            'guard_name' => 'api'
        ],[
            'name' => 'human_resource_executive',
            'guard_name' => 'api'
        ],
        [
            'name' => 'finance_depart',
            'guard_name' => 'api'
        ],[
            'name' => 'production_manager',
            'guard_name' => 'api'
        ],[
            'name' => 'design_manager',
            'guard_name' => 'api'
        ],[
            'name' => 'development_manager',
            'guard_name' => 'api'
        ],[
            'name' => 'content_manager',
            'guard_name' => 'api'
        ],[
            'name' => 'video_manager',
            'guard_name' => 'api'
        ],[
            'name' => 'client',
            'guard_name' => 'api'
        ]];
        Role::insert($userroles);
        $permissions = Permission::pluck('id');
        $admin = Role::find(1);
        $admin->syncPermissions($permissions);
    }
}
