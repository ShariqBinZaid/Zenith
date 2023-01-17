<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Leads;
class LeadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leads = [[
            'username' => 'Test Lead',
            'email' => 'testlead@gmail.com',
            'phone' => '123456789',
            'message'=>'This is test lead',
            'url'=>'www.google.com',
            'brand_id'=>'2'
        ],[
            'username' => 'Test Lead 1',
            'email' => 'testlead1@gmail.com',
            'phone' => '1234567890',
            'message'=>'This is test lead 1',
            'url'=>'www.google.com',
            'brand_id'=>'2'
        ],[
            'username' => 'Test Lead 2',
            'email' => 'testlead2@gmail.com',
            'phone' => '12345678900',
            'message'=>'This is test lead 2',
            'url'=>'www.google.com',
            'brand_id'=>'1'
        ],[
            'username' => 'Test Lead 3',
            'email' => 'testlead3@gmail.com',
            'phone' => '123456789010',
            'message'=>'This is test lead 3',
            'url'=>'www.google.com',
            'brand_id'=>'1'
        ]];
        Leads::insert($leads);
    }
}
