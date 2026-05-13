<?php

namespace Tests\Feature\Modules\Blog\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Blog\app\Models\BlogPost;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BlogPostApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_paginated_list_of_active_blog_posts(): void
    {
        BlogPost::factory()->count(3)->create(['is_active' => true]);
        BlogPost::factory()->create(['is_active' => false]);

        $response = $this->getJson('/api/v1/blog-posts');

        $response->assertOk()
            ->assertJsonPath('data.total', 3);
    }

    #[Test]
    public function it_respects_per_page_parameter(): void
    {
        BlogPost::factory()->count(5)->create(['is_active' => true]);

        $response = $this->getJson('/api/v1/blog-posts?per_page=2');

        $response->assertOk()
            ->assertJsonPath('data.per_page', 2)
            ->assertJsonPath('data.total', 5);
    }

    #[Test]
    public function it_returns_a_single_post_by_slug(): void
    {
        $post = BlogPost::factory()->create([
            'is_active' => true,
            'slug' => 'my-test-post',
        ]);

        $response = $this->getJson('/api/v1/blog-posts/my-test-post');

        $response->assertOk()
            ->assertJsonPath('data.slug', 'my-test-post')
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'slug',
                    'thumbnail',
                    'preview_image',
                    'keywords',
                    'content',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    #[Test]
    public function it_returns_404_for_non_existent_slug(): void
    {
        $response = $this->getJson('/api/v1/blog-posts/does-not-exist');

        $response->assertStatus(404);
    }

    #[Test]
    public function it_does_not_return_inactive_posts_by_slug(): void
    {
        BlogPost::factory()->create([
            'is_active' => false,
            'slug' => 'hidden-post',
        ]);

        $response = $this->getJson('/api/v1/blog-posts/hidden-post');

        $response->assertStatus(404);
    }

    #[Test]
    public function listing_does_not_include_content_body(): void
    {
        BlogPost::factory()->create(['is_active' => true]);

        $response = $this->getJson('/api/v1/blog-posts');

        $response->assertOk();

        $items = $response->json('data.data');
        $this->assertNotEmpty($items);
        $this->assertArrayNotHasKey('content', $items[0]);
    }
}
