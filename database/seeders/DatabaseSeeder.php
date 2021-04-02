<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Course::factory(10)->create();
        \App\Models\Content::factory(10)->create();
        \App\Models\Params::factory(10)->create();
        \App\Models\Taxonomies::factory(10)->create();
        \App\Models\Links::factory(10)->create();
        \App\Models\Comunications::factory(10)->create();
        \App\Models\Interactions::factory(10)->create();
    }
}
