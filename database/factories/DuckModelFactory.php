<?php

namespace Database\Factories;

use App\Models\DuckModel;
use App\Models\StatusModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class DuckModelFactory extends Factory
{
    /**
     * The name of the model that the factory is for.
     *
     * @var string
     */
    protected $model = DuckModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $statuses = StatusModel::pluck('name')->toArray();
        $status = $this->faker->randomElement($statuses);
        $is_walking = in_array($status, ['active']) ? $this->faker->boolean(70) : false;
        $is_quacking = in_array($status, ['active', 'feeding']) ? $this->faker->boolean(30) : false;

        return [
            'name' => $this->faker->name,
            'age' => $this->faker->numberBetween(1, 10),
            'health' => $this->faker->numberBetween(1, 100),
            'status' => $status,
            'last_fed_time' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'behaviors' => [
                'walking' => [
                    'is_walking' => $is_walking,
                    'speed' => $is_walking ? $this->faker->randomFloat(2, 0.5, 2.0) : 0.0,
                ],
                'breathing' => [
                    'is_breathing' => $this->faker->boolean(100),
                    'rate' => $this->faker->randomNumber(2)
                ],
                'quacking' => [
                    'is_quacking' => $is_quacking,
                    'volume' => $is_quacking ? $this->faker->randomElement(['low', 'medium', 'high']) : 0,
                ]
            ]
        ];
    }
}
