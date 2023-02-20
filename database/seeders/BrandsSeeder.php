<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brands;
class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leads = [[
            'name' => 'Brand 1',
            'url' => 'www.google.com',
            'image' => 'brands/default.jpg',
            'type'=>'Design',
            'initials'=>'BR',
            'unit_id'=>'1',
            'company_id'=>'1'
        ],[
            'name' => 'Brand 2',
            'url' => 'www.facebook.com',
            'image' => 'brands/default.jpg',
            'type'=>'EBook',
            'initials'=>'BR2',
            'unit_id'=>'2',
            'company_id'=>'1'
        ],[
            'name' => 'Brand 3',
            'url' => 'www.logo.com',
            'image' => 'brands/default.jpg',
            'type'=>'Logo',
            'initials'=>'BR3',
            'unit_id'=>'1',
            'company_id'=>'1'
        ]];
        Brands::insert($leads);
    }
}
