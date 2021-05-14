<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

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
            'excerpt' => $this->faker->word.'_'.$this->faker->word,
            'title' => $this->faker->text(40),
            'content' => $this->faker->sentence(4, true),
            'views' =>  $this->faker->numberBetween(0, 100),
            'password' => null,
            'url' => null,
            'context' => 'post',
            'state' => 'published',
            'time_in' => $this->faker->date('Y-m-d H:i:s', 'now'),
            'time_out' => $this->faker->date('Y-m-d H:i:s', 'now'),
            'user_id' => $this->faker->numberBetween(0, 10),
            'notification' => null,
            'meta' => null,
            'json' => null,
            'html' => null,
            'status' => null,
            'parent' => null,
            'language' => 'es',
        ];
    }
}
