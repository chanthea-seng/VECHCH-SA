<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    public function definition(): array
    {
        // $ids = User::get(['id'])->pluck('id')->toArray();
        return [
            'doctor_id' => 2,
            'category_id' => fake()->numberBetween(1, 3),
            'title' => fake()->sentence(6),
            'thumbnail' => 'article/no_thumbnail.jpg',
            'short_description' => fake()->text(100),
            'content' => fake()->paragraphs(3, true),
            'view' => 0,
            'is_published' => fake()->boolean(),
            'type' => 1,
        ];
    }

}
