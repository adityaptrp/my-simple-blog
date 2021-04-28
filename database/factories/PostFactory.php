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
            'category_id' => rand(1, 4),
            'user_id' => 1,
            'title' => $this->faker->sentence(),
            'slug' => Str::slug($this->faker->sentence() . '-' . Str::random(12)),
            'subtitle' => $this->faker->sentence(),
            'header' => $this->faker->paragraph(10),
            'body' => $this->faker->paragraph(20),
            'footer' => $this->faker->paragraph(5),
            'thumbnail' => 'images/posts/post-' . $this->faker->numberBetween(1, 8) . '.jpg',
            'sub_thumbnail1' => 'images/posts/post-5.jpg',
            'sub_thumbnail2' => 'images/posts/post-6.jpg',
            'quote' => 'There is a way out of every box, a solution to every puzzle; it’s just a matter of finding it.',
            'quote_author' => 'Jean Luc Picard',
            'youtube_link' => 'https://youtu.be/ebchrRL2B9A',
        ];
    }
}
