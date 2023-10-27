<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::factory()->create(['name' => 'Plano básico', 'price' => '80.00', 'qtd_days' => 3]);
        Plan::factory()->create(['name' => 'Plano completo', 'price' => '100.00', 'qtd_days' => 5]);
    }
}
