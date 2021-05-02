<?php

namespace Database\Factories;

use App\Models\Comunications;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ComunicationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comunications::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'title' => $this->faker->text(40),
            'description' => $this->faker->sentence(4, true),
            'expiration' => $this->faker->dateTime('now', null),
            'url' => $this->faker->url,
            'icon' => null,
            'color' => null,
            'progress' => null,
            'rol' => null,
            'param' => null,
            'html' => null,
            'json' => null,
            'language' => null,
            'status' => true,
        ];
    }
}
