<?php

namespace Database\Factories;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Content::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'uuid' => Str::uuid(),
            'content' => $this->faker->text(40),
            'description' => $this->faker->sentence(4, true),
            'slug' => $this->faker->word.'_'.$this->faker->word,
            'password' => null,
            'value' => $this->faker->numberBetween(0, 5),
            'rating' => $this->faker->numberBetween(0, 5),
            'excerpt' => $this->faker->sentence(4, true),
            'view' => null,
            'order' => null,
            'urlInbox' => $this->faker->url,
            'timeIn' => $this->faker->dateTime('now', null),
            'timeOut' => $this->faker->dateTime('now', null),
            'confParameter' => null,
            'assing' => null,
            'classroom' => $this->faker->sentence(2, true),
            'classroomText' => $this->faker->sentence(2, true),
            'address' => $this->faker->address,
            'timeLine' => $this->faker->numberBetween(0, 5),
            'meta' => null,
            'json' => null,
            'html' => null,
            'status' => true,
            'parent' => null,
            'language' => 'es',
        ];
    }
}
