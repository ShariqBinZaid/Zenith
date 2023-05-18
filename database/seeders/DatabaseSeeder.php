<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< Updated upstream
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
=======
        $this->call(CurrencySeeder::class);
        $this->call(PackageTypeSeeder::class);
        $this->call(BrandsSeeder::class);
        $this->call(LeadsSeeder::class);
        $this->call(OpportunitySeeder::class);
        $this->call(PackagesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(UserRolesSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(TeamsSeeder::class);
        $this->call(ShiftSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(UnitsSeeder::class);
        $this->call(LeaveTypesSeeder::class);
        $this->call(DispositionsSeeder::class);
>>>>>>> Stashed changes
    }
}
