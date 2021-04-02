<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'slug' => $this->faker->word.'_'.$this->faker->word,
            'excerpt' => $this->faker->sentence(4, true),
            'course' => $this->faker->text(40),
            'description' => $this->faker->sentence(4, true),
            'classroom' => $this->faker->sentence(2, true),
            'level' => null,
            'descriptionTask' => $this->faker->sentence(4, true),
            'amountTask' => $this->faker->numberBetween(0, 7), // Cantidad de entregas
            'calification' => $this->faker->numberBetween(0, 5),
            'subject' => $this->faker->randomDigit,
            'notification' => $this->faker->word,
            'meta' => null,
            'json' => null,
            'html' => null,
            'status' => true,
            'parent' => null,
            'language' => 'es',
        ];
    }
}
