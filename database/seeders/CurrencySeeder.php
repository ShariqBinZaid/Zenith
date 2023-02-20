<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;
class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [[
            'name' => 'Dollars',
            'code' => 'USD',
            'symbol' => '$',
            'company_id'=>'1'
        ],[
            'name' => 'Euro',
            'code' => 'EUR',
            'symbol' => '€',
            'company_id'=>'1'
        ],[
            'name' => 'Pounds',
            'code' => 'GBP',
            'symbol' => '£',
            'company_id'=>'1'
        ],[
            'name' => 'Canadian Dollar',
            'code' => 'CAD',
            'symbol' => '$',
            'company_id'=>'1'
        ]];
        Currency::insert($currencies);
    }
}
