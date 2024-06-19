<?php

namespace App\Jobs;

use App\Models\DuckModel;
use Faker\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateDuckDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Collection of ducks to be processed by the job
    protected $ducks;

    // Faker instance for generating random data
    protected $faker;

    /**
     * Create a new job instance.
     *
     * @param Collection $ducks Collection of DuckModel instances
     * @return void
     */
    public function __construct(Collection $ducks)
    {
        $this->ducks = $ducks;
        $this->faker = Factory::create();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Iterate through each duck in the collection and update its data
        foreach ($this->ducks as $duck) {
            $this->updateDuckData($duck);
        }
    }

    /**
     * Get a random status for a duck.
     *
     * @return string
     */
    private function getStatus(): string
    {
        return $this->faker->randomElement(['active', 'resting', 'feeding', 'sleeping']);
    }

    /**
     * Determine if the duck is walking based on its status.
     *
     * @param string $status
     * @return bool
     */
    private function getIsWalking(string $status): bool
    {
        return in_array($status, ['active']) ? $this->faker->boolean(70) : false;
    }

    /**
     * Determine if the duck is quacking based on its status.
     *
     * @param string $status
     * @return bool
     */
    private function getIsQuacking(string $status): bool
    {
        return in_array($status, ['active', 'feeding']) ? $this->faker->boolean(30) : false;
    }

    /**
     * Update the duck's data with random values.
     *
     * @param DuckModel $duck The duck model to be updated
     * @return void
     */
    private function updateDuckData(DuckModel $duck): void
    {
        // Generate random status, walking, and quacking states for the duck
        $status = $this->getStatus();
        $is_walking = $this->getIsWalking($status);
        $is_quacking = $this->getIsQuacking($status);

        // Update the duck model with the new random data
        $duck->update([
            'health' => $this->faker->numberBetween(1, 100),
            'status' => $status,
            'last_fed_time' => $this->faker->dateTimeBetween($duck->last_fed_time, 'now'),
            'behaviors' => [
                'walking' => [
                    'is_walking' => $is_walking,
                    'speed' => $is_walking ? $this->faker->randomFloat(2, 0.5, 2.0) : 0.0,
                ],
                'breathing' => [
                    'is_breathing' => true,
                    'rate' => $this->faker->randomNumber(2)
                ],
                'quacking' => [
                    'is_quacking' => $is_quacking,
                    'volume' => $is_quacking ? $this->faker->randomElement(['low', 'medium', 'high']) : 0,
                ]
            ]
        ]);
    }
}
