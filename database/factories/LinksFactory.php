<?php

namespace Database\Factories;

use App\Models\Links;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LinksFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Links::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $location = array('header','footer','nav','mobile','social','social_footer', 'mobile_footer', 'left_admin', 'top_admin', 'rigth_admin');
        return [
            'uuid' => Str::uuid(),
            'url' => $this->faker->url,
            'name' => $this->faker->word,
            'description' => $this->faker->sentence(4, true),
            'notes' => null,
            'icon' => null,
            'location' => $location[ $this->faker->numberBetween(0,9) ],
            'target' => null,
            'visible' => null,
            'parent' => null,
            'param' => null,
        ];
    }
}
