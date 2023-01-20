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
            'name' => 'Unit 1',
            'leader'=>'2'
        ],[
            'name' => 'Unit 2',
            'leader'=>'3'
        ]];
        Teams::insert($teams);
    }
}
