<?php

namespace Database\Factories;

use App\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'meta_title' => $this->faker->word,
            'meta_description' => $this->faker->text,
            'user_id'=> 1,
            'slug' => str_replace(" ", "-", $this->faker->word),
            'tag_id' => [1, 2 ,3],
            'image' =>  Str::random(5),
            'author' => $this->faker->text,
            'like' => 10,
            'dislike' => 25,
            'status' => 1,
            'sub_title' => $this->faker->text,
        ];
    }
}