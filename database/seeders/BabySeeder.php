<?php

namespace Database\Seeders;

use App\Models\Baby;
use Illuminate\Database\Seeder;

class BabySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Baby::factory()->count(50)->create();
    }
}
