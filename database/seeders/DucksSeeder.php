<?php

namespace Database\Seeders;

use App\Models\DuckModel;
use Illuminate\Database\Seeder;

class DucksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DuckModel::factory()->count(100000)->create();
    }
}
