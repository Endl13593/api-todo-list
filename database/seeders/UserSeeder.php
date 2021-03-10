<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(1)
            ->create([
                'first_name' => 'Eduardo',
                'last_name' => 'Nunes',
                'email' => 'nunes.eduardo1993@gmail.com',
                'password' => bcrypt('vasco@123')
            ]);

        User::factory()->count(5)->create();
    }
}
