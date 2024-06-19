<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\DuckModel;

class DuckModelTest extends TestCase
{
    public function test_duck_can_be_created()
    {
        $duck = DuckModel::factory()->create([
            'name' => 'Test Duck',
            'age' => 2,
            'health' => 85,
            'status' => 'active',
            'last_fed_time' => now(),
            'behaviors' => [
                'walking' => [
                    'is_walking' => true,
                    'speed' => 1.5,
                ],
                'breathing' => [
                    'is_breathing' => true,
                    'rate' => 20,
                ],
                'quacking' => [
                    'is_quacking' => true,
                    'volume' => 'medium',
                ],
            ],
        ]);

        $this->assertDatabaseHas('ducks', ['name' => 'Test Duck']);
    }

    public function test_scope_status()
    {
        DuckModel::factory()->create(['status' => 'active']);

        $ducks = DuckModel::where('status','=', 'active')->limit(1)->get();
        $this->assertCount(1, $ducks);
        $this->assertEquals('active', $ducks->first()->status);

        DuckModel::factory()->create(['status' => 'resting']);

        $ducks = DuckModel::where('status','=', 'resting')->limit(1)->get();
        $this->assertCount(1, $ducks);
        $this->assertEquals('resting', $ducks->first()->status);

    }
}
