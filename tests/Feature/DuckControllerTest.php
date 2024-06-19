<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\DuckModel;
use Illuminate\Support\Facades\Artisan;

class DuckControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // Ensure the database is in a clean state
        Artisan::call('migrate:refresh');
        $this->seed();
    }

    public function test_index_displays_ducks()
    {
        DuckModel::factory()->count(3)->create();

        $response = $this->get(route('ducks.index'));

        $response->assertStatus(200);
        $response->assertViewHas('ducks');
    }

    public function test_ages_route()
    {
        $agesData = ['age' => 2];
        $response = $this->post(route('ducks.ages'), $agesData);
        $response->assertStatus(200);
    }

    public function test_edit_route()
    {
        $duck = DuckModel::factory()->create();
        $response = $this->get(route('ducks.edit', ['id' => $duck->id]));
        $response->assertStatus(200);
    }

    public function test_duck_can_be_updated()
    {
        $duck = DuckModel::factory()->create([
            'name' => 'Old Name',
            'age' => 2,
            'health' => 85,
            'status' => 'active',
        ]);

        $response = $this->put(route('ducks.update', $duck->id), [
            'name' => 'New Name',
            'age' => 3,
            'health' => 90,
            'status' => 'resting',
            'last_fed_time' => now(),
            'behaviors' => [
                'walking' => [
                    'is_walking' => false,
                    'speed' => 0.0,
                ],
                'breathing' => [
                    'is_breathing' => true,
                    'rate' => 25,
                ],
                'quacking' => [
                    'is_quacking' => false,
                    'volume' => 'low',
                ],
            ],
        ]);

        $response->assertRedirect(route('ducks.index'));
        $this->assertDatabaseHas('ducks', ['name' => 'New Name']);
    }

    public function test_search_ducks()
    {
        DuckModel::factory()->create(['name' => 'Test Duck']);

        $response = $this->post(route('ducks.search'), ['name' => 'Test Duck']);
        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function it_can_destroy_a_duck()
    {
        // Create a duck instance to delete
        $duck = DuckModel::factory()->create();

        // Ensure the duck exists in the database
        $this->assertDatabaseHas('ducks', ['id' => $duck->id]);

        // Send the POST request to destroy the duck
        $response = $this->post(route('ducks.destroy', $duck->id));

        // Check that the response is successful
        $response->assertStatus(200);

        // Check that the duck was deleted from the database
        $this->assertDatabaseMissing('ducks', ['id' => $duck->id]);
    }

}
