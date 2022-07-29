<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Partner::factory()->count(20)->create();
        $users = User::select('id')->inRandomOrder()->get();
        foreach ($users as $user) {
            $user_id = $user->id;
            Partner::create([
                'parent_id' => $user_id,
                'partner_id' => User::select('id')->where('id', '!=', $user_id)->inRandomOrder()->first()->id,
            ]);
        }

    }
}
