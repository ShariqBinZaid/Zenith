<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Opportunity;
class OpportunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $opportunity = [[
            'name' => 'Test Opportunity',
            'email' => 'testopportunity@gmail.com',
            'phone' => '123456789',
            'message'=>'This is test Opportunity',
            'brand_id'=>'2',
            'url'=>'www.google.com',
            'package_id'=>'4',
            'unit_id'=>'2',
            'company_id'=>'1'
        ],[
            'name' => 'Test Opportunity 1',
            'email' => 'testopportunity1@gmail.com',
            'phone' => '1234567890',
            'message'=>'This is test Opportunity 1',
            'brand_id'=>'2',
            'url'=>'www.google.com',
            'package_id'=>'3',
            'unit_id'=>'2',
            'company_id'=>'1'
        ],[
            'name' => 'Test Opportunity 2',
            'email' => 'testopportunity2@gmail.com',
            'phone' => '12345678900',
            'message'=>'This is test Opportunity 2',
            'brand_id'=>'1',
            'url'=>'www.google.com',
            'package_id'=>'2',
            'unit_id'=>'1',
            'company_id'=>'1'
        ],[
            'name' => 'Test Opportunity 3',
            'email' => 'testopportunity3@gmail.com',
            'phone' => '123456789010',
            'message'=>'This is test Opportunity 3',
            'brand_id'=>'1',
            'url'=>'www.google.com',
            'package_id'=>'1',
            'unit_id'=>'1',
            'company_id'=>'1'
        ]];
        Opportunity::insert($opportunity);
    }
}
