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
        ],[
            'name' => 'Ecommerce',
        ],[
            'name' => 'Mobile Applications',
        ],[
            'name' => 'Logo',
        ],[
            'name'=>'Branding',
        ],[
            'name'=>'Web Portal',
        ],[
            'name'=>'Video Animations',
        ],[
            'name'=>'Digital Marketing',
        ],[
            'name'=>'SEO',
        ],[
            'name'=>'Social Media Marketing',
        ],[
            'name'=>'PPC',
        ],[
            'name'=>'Web Content',
        ],[
            'name'=>'Articles',
        ],[
            'name'=>'Blogs',
        ]];
        PackageTypes::insert($packagetypes);
    }
}
