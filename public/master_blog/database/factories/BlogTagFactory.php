<?php

namespace Database\Factories;

use App\BlogTag;
use App\Blog;
use App\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogTag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $blog_id = 1;   
        static $tag_id = 1;   
        return [
            'blog_id'=> $blog_id++,
            'tag_id' => $tag_id++
        ];
    }
}
