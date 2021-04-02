<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'name' => $this->faker->name,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'mobile' => $this->faker->phoneNumber,
            'displayName' => $this->faker->name. " " .$this->faker->lastName,
            'LastMs' => null,
            'slug' => Str::slug($this->faker->firstName),
            'nicname' => $this->faker->userName,
            'about' => $this->faker->text(100),
            'temporalTocken' => null,
            'onlyDelete' => null,
            'town' => $this->faker->numberBetween(1, 70),
            'photo' => $this->faker->imageUrl(400, 400),
            'especialParam' => null,
            'pago' => null,
            'email_verified_at' => now(),
            'password' => bcrypt(123456),
            'language' => 'en,es'
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
