<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LeaveTypes;
class LeaveTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leavestype = [[
            'name' => 'Annual Leaves',
            'days'=>'22'
        ],[
            'name' => 'Casual Leaves',
            'days'=>'10'
        ],[
            'name' => 'Sick Leaves',
            'days'=>'10'
        ]];
        LeaveTypes::insert($leavestype);
    }
}
