<?php

namespace Tests\Feature;

use App\Jobs\UpdateDuckDataJob;
use App\Models\DuckModel;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UpdateDuckDataJobTest extends TestCase
{

    public function test_updates_duck_data_correctly()
    {
        // Create a collection of ducks
        $ducks = DuckModel::factory()->count(10)->create();

        // Dispatch the job
        UpdateDuckDataJob::dispatch($ducks);

        // Fetch the ducks again to check for updates
        $updatedDucks = DuckModel::all();

        // Assert that each duck has been updated
        foreach ($updatedDucks as $duck) {
            $this->assertNotNull($duck->health);
            $this->assertNotNull($duck->status);
            $this->assertNotNull($duck->last_fed_time);
            $this->assertIsArray($duck->behaviors);
            $this->assertArrayHasKey('walking', $duck->behaviors);
            $this->assertArrayHasKey('breathing', $duck->behaviors);
            $this->assertArrayHasKey('quacking', $duck->behaviors);
        }
    }
}
