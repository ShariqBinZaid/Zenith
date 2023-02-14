<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Units;
class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [[
            'name' => 'Design Unit - Alpha',
            'company_id'=>'1',
            'unithead'=>'3',
            'desc'=>'Design Unit'
        ],[
            'name' => 'EBook Unit - Alpha',
            'company_id'=>'1',
            'unithead'=>'4',
            'desc'=>'EBook Unit'
        ]];
        Units::insert($units);
    }
}
