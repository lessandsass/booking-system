<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $title = 'Hair',
            'slug' => str()->slug($title),
            'price' => 2000,
        ];
    }
}
