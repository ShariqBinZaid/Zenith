<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teams;
class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [[
            'name' => 'Designers',
            'leader'=>'5',
            'unit_id'=>'1',
            'company_id'=>'1'
        ],[
            'name' => 'Developers',
            'leader'=>'6',
            'unit_id'=>'1',
            'company_id'=>'1'
        ]];
        Teams::insert($teams);
    }
}
