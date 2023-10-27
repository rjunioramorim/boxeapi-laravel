<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->hasClient()
            ->create(['email' => 'user@user.com', 'user_type' => UserType::CLIENT->value, 'avatar_url' => 'images/avatar_default.jpg']);

        User::factory()->hasClient()->create(['email' => 'user1@user.com', 'user_type' => UserType::CLIENT->value, 'avatar_url' => 'images/avatar_default.jpg']);

        User::factory()->create(['email' => 'admin@admin.com', 'user_type' => UserType::MANAGER->value, 'avatar_url' => 'images/avatar_default.jpg']);
    }
}
