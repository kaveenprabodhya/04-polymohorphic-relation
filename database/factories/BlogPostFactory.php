<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'content' => $this->faker->paragraph(5, true),
            'created_at' => $this->faker->dateTimeBetween(
                '-3 months'
            )
        ];
    }

    /**
     * new title post
     *
     * @return static
     */
    public function newTitlePost()
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'New Title',
            ];
        });
    }
}