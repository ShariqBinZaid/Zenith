<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Packages;

class PackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [[
            'name' => 'Test Packages',
            'price' => '10',
            'cut_price' => '20',
            'description'=>'<p>This is test Packages</p>',
            'currency'=>'1',
            'brand_id'=>'1',
            'discount'=>'0',
            'package_type'=>'1'
        ],[
            'name' => 'Test Packages 1',
            'price' => '10',
            'cut_price' => '20',
            'description'=>'<p>This is test Packages</p>',
            'currency'=>'1',
            'brand_id'=>'2',
            'discount'=>'0',
            'package_type'=>'2'
        ],[
            'name' => 'Test Packages 2',
            'price' => '10',
            'cut_price' => '20',
            'description'=>'<p>This is test Packages</p>',
            'currency'=>'1',
            'brand_id'=>'3',
            'discount'=>'0',
            'package_type'=>'3'
        ],[
            'name' => 'Test Packages 3',
            'price' => '10',
            'cut_price' => '20',
            'description'=>'<p>This is test Packages</p>',
            'currency'=>'1',
            'brand_id'=>'1',
            'discount'=>'0',
            'package_type'=>'4'
        ]];
        Packages::insert($packages);
    }
}
