<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $guard_name = 'api'; 
    public function run()
    {
        $user = [[
            'name' => 'Fahad Ali',
            'email' => 'faddimalik56@gmail.com',
            'password' => bcrypt('123456789'),
        ],
        [
            'name' => 'Shariq Bin Zaid',
            'email' => 'shariqbinzaid@gmail.com',
            'password' => bcrypt('123456789'),
        ]];
        User::insert($user);
    }
}
