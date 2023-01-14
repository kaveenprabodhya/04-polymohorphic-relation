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
        User::factory()->create([
            'name' => 'thivanka',
            'email' => 'thivanka@gmail.com'
        ]);

        User::factory()->fakeAdmin()->create();

        $userCount = (int)$this->command->ask('How many users would you like?', 10);


        User::factory($userCount)->create();
    }
}