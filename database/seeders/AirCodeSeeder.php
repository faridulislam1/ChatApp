<?php

namespace Database\Seeders;
use App\Models\Aircode;
use Illuminate\Support\Str;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 2000) as $i) {
            Aircode::create([
                'air_name' => "Airline {$i}",
                'code' => strtoupper(Str::random(3)), 
            ]);
        }
    }
}
