<?php

namespace App\Jobs;

use App\Models\DuckModel;
use App\Models\StatusModel;
use Faker\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateDuckDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ducks;
    protected $faker;

    /**
     * Create a new job instance.
     *
     * @param DuckModel $duck
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
        foreach ($this->ducks as $duck) {
            $this->updateDuckData($duck);
        }
    }

    private function getStatus(): string
    {
        return $this->faker->randomElement(StatusModel::pluck('name')->toArray());
    }

    private function getIsWalking(string $status): bool
    {
        return in_array($status, ['active']) ? $this->faker->boolean(70) : false;
    }

    private function getIsQuacking(string $status): bool
    {
        return in_array($status, ['active', 'feeding']) ? $this->faker->boolean(30) : false;
    }

    private function updateDuckData(DuckModel $duck): void
    {
        try {
            $status = $this->getStatus();
            $is_walking = $this->getIsWalking($status);
            $is_quacking = $this->getIsQuacking($status);

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
        } catch (\Exception $e) {
            // Log an error message if something goes wrong
            Log::error('Error updating duck', ['id' => $duck->id, 'error' => $e->getMessage()]);
        }
    }
}
