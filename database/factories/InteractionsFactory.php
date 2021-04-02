<?php

namespace Database\Factories;

use App\Models\Interactions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InteractionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Interactions::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'interaction' =>  $this->faker->text(40),
            'response' => $this->faker->sentence(4, true),
            'context' => $this->faker->sentence(4, true),
            'value' =>  $this->faker->numberBetween(0, 60),
            'notification' => $this->faker->word,
            'users_id' => $this->faker->numberBetween(1, 10),
            'courses_id' =>  $this->faker->numberBetween(1, 10),
        ];
    }
}
