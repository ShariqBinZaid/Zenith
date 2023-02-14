<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('superadmin'),
        ])->assignRole('superadmin');
        User::create([
            'name' => 'Fahad Ali',
            'email' => 'faddimalik56@gmail.com',
            'password' => bcrypt('123456789'),
        ])->assignRole('admin');
        
        User::create([
            'name' => 'Shariq Bin Zaid',
            'email' => 'shariqbinzaid@gmail.com',
            'password' => bcrypt('123456789'),
        ])->assignRole('business_unit_head');
        User::create([
            'name' => 'Nimroz Ali',
            'email' => 'nimroz@gmail.com',
            'password' => bcrypt('123456789'),
        ])->assignRole('business_unit_head');
        User::create([
            'name' => 'Faizan Ali',
            'email' => 'faizan@gmail.com',
            'password' => bcrypt('123456789'),
        ])->assignRole('front_sales_manager');
        User::create([
            'name' => 'Adil Jameel',
            'email' => 'adil@gmail.com',
            'password' => bcrypt('123456789'),
        ])->assignRole('front_sales_manager');
        User::create([
            'name' => 'James',
            'email' => 'james@gmail.com',
            'password' => bcrypt('123456789'),
        ])->assignRole('front_sales_executive');
        User::create([
            'name' => 'Wine',
            'email' => 'wine@gmail.com',
            'password' => bcrypt('123456789'),
        ])->assignRole('front_sales_executive');
        User::create([
            'name' => 'John',
            'email' => 'john@gmail.com',
            'password' => bcrypt('123456789'),
        ])->assignRole('front_sales_executive');
        User::create([
            'name' => 'Wick',
            'email' => 'wick@gmail.com',
            'password' => bcrypt('123456789'),
        ])->assignRole('front_sales_executive');
    }
}
