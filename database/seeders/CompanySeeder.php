<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = [[
            'name' => 'Zenith Codes',
            'logo'=>'company/1676295466-Zenith Codes.png',
            'owner'=>'2',
            'desc'=>'Main Company'
        ]];
        Company::insert($company);
    }
}
