<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PackageTypes;
class PackageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packagetypes = [[
            'name' => 'Website',
            'company_id'=>'1'
        ],[
            'name' => 'Ecommerce',
            'company_id'=>'1'
        ],[
            'name' => 'Mobile Applications',
            'company_id'=>'1'
        ],[
            'name' => 'Logo',
            'company_id'=>'1'
        ],[
            'name'=>'Branding',
            'company_id'=>'1'
        ],[
            'name'=>'Web Portal',
            'company_id'=>'1'
        ],[
            'name'=>'Video Animations',
            'company_id'=>'1'
        ],[
            'name'=>'Digital Marketing',
            'company_id'=>'1'
        ],[
            'name'=>'SEO',
            'company_id'=>'1'
        ],[
            'name'=>'Social Media Marketing',
            'company_id'=>'1'
        ],[
            'name'=>'PPC',
            'company_id'=>'1'
        ],[
            'name'=>'Web Content',
            'company_id'=>'1'
        ],[
            'name'=>'Articles',
            'company_id'=>'1'
        ],[
            'name'=>'Blogs',
            'company_id'=>'1'
        ]];
        PackageTypes::insert($packagetypes);
    }
}
