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
        ],[
            'name' => 'Euro',
            'code' => 'EUR',
            'symbol' => '€',
        ],[
            'name' => 'Pounds',
            'code' => 'GBP',
            'symbol' => '£',
        ],[
            'name' => 'Canadian Dollar',
            'code' => 'CAD',
            'symbol' => '$',
        ]];
        Currency::insert($currencies);
    }
}
