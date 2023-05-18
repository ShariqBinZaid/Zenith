<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dispositions;

class DispositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dispositions = [
            [
                'name' => 'Junk',
                'company_id' => 1
            ], [
                'name' => 'Not Interested',
                'company_id' => 1
            ], [
                'name' => 'No Answer',
                'company_id' => 1
            ], [
                'name' => 'Incorrect Number',
                'company_id' => 1
            ], [
                'name' => 'Voicemail',
                'company_id' => 1
            ], [
                'name' => 'In Contact',
                'company_id' => 1
            ],
            [
                'name' => 'Follow up',
                'company_id' => 1
            ],
            [
                'name' => 'Won',
                'company_id' => 1
            ],
            [
                'name' => 'Quoted',
                'company_id' => 1
            ]
        ];
        Dispositions::insert($dispositions);
    }
}
