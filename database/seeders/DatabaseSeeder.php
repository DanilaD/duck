<?php

namespace Database\Seeders;

use App\Models\DuckModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DuckModel::factory(100)->create();
    }
}
