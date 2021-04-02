<?php

namespace Database\Factories;

use App\Models\Taxonomies;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaxonomiesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Taxonomies::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = array('category', 'item', 'tag', 'publicity', 'external', 'landingpage');
        return [
            'uuid' => Str::uuid(),
            'slug' => $this->faker->word.'_'.$this->faker->word,
            'taxonomy' =>  $this->faker->text(40),
            'description' => $this->faker->sentence(4, true),
            'meta' => null,
            'type' => $type[$this->faker->numberBetween(0,5)],
            'parent' => null,
            'html' => null,
            'json' => null,
            'language' => 'es',
            'status' => true,
        ];
    }
}
