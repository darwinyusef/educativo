<?php

namespace Database\Factories;

use App\Models\Params;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ParamsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Params::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $context = array('core', 'api', 'structure', 'web', 'mobile', 'state', 'admin', 'enum', 'unique', 'personal', 'frecuency', 'publicity');
        return [
            'uuid' => Str::uuid(),
            'param_key' => $this->faker->word,
            'param_value' => $this->faker->randomDigit,
            'slug' => $this->faker->word.'_'.$this->faker->word,
            'settings' => $this->faker->sentence(4, true),
            'url' => $this->faker->url,
            'value' => $this->faker->randomDigit,
            'timeIn' => $this->faker->dateTime('now', null),
            'timeOut' => $this->faker->dateTime('now', null),
            'context' => $context[$this->faker->numberBetween(0,11)],
            'autoload' => $this->faker->randomDigit,
            'frecuency' => null,
            'parent' => null,
            'especial' => 'si',
            'html' => null,
            'json' => null,
            'language' => 'es',
            'status' => true,
        ];
    }
}
