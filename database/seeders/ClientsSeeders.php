<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::where('email', 'user@user.com')->first();
        $user2 = User::factory()->create(['email' => 'user-confirm@mail.com']);

        Client::factory()->create(['user_id' => $user1->id]);
        Client::factory()->create(['user_id' => $user2->id]);
        Client::factory(10)->create();
    }
}
