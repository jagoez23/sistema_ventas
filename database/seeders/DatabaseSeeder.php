<?php

namespace Database\Seeders;

use App\Models\Denomination;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(DenominationSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(UserSeeder::class);
    }
}
