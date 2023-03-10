<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shifts;
class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shifts = [[
            'name' => 'Morning Shift',
            'timing'=>'11AM-8PM',
            'company_id'=>'1'
        ],[
            'name' => 'Evening Shift',
            'timing'=>'3PM-12AM',
            'company_id'=>'1'
        ],[
            'name' => 'Night Shift',
            'timing'=>'9PM-6AM',
            'company_id'=>'1'
        ]];
        Shifts::insert($shifts);
    }
}
