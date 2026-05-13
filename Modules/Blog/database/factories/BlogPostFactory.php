<?php

namespace Modules\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Blog\app\Models\BlogPost;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        $slug = \Illuminate\Support\Str::slug($title).'-'.$this->faker->unique()->numberBetween(1, 999999);

        return [
            'title' => ['ar' => $title, 'en' => $title],
            'description' => ['ar' => $this->faker->sentence(10), 'en' => $this->faker->sentence(10)],
            'slug' => $slug,
            'keywords' => ['ar' => ['كلمة', 'مدونة'], 'en' => ['keyword', 'blog']],
            'content' => ['ar' => $this->faker->paragraph(3), 'en' => $this->faker->paragraph(3)],
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
