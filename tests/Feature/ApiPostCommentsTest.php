<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiPostCommentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_blog_post_does_not_have_comments()
    {
        // BlogPost::factory()->create([
        //     'user_id' => $this->user()->id
        // ]);

        $this->posts();

        $response = $this->json('GET', 'api/v1/posts/1/comments');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(0, 'data');
    }

    public function test_blog_post_has_10_comments()
    {
        $this->posts()->each(function (BlogPost $post) {
            $post->comments()->saveMany(Comment::factory(10)->make([
                'user_id' => $this->user()->id
            ]));
        });

        $response = $this->json('GET', 'api/v1/posts/2/comments');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'content',
                        'created_at',
                        'updated_at',
                        'user' => [
                            'id',
                            'name',
                        ]
                    ]
                ],
                'links',
                'meta',
            ])
            ->assertJsonCount(10, 'data');
    }

    public function test_adding_comments_when_not_authenticated()
    {
        $this->posts();
        $response = $this->json('POST', 'api/v1/posts/3/comments', [
            'content' => 'hello world',
        ]);
        $response->assertUnauthorized();
    }

    public function test_adding_comments_when_authenticated()
    {
        $this->posts();
        $response = $this->actingAs($this->user(), 'api')->json('POST', 'api/v1/posts/4/comments', [
            'content' => 'hello world',
        ]);
        $response->assertStatus(201);
    }

    public function test_adding_comments_with_invalid_data()
    {
        $this->posts();
        $response = $this->actingAs($this->user(), 'api')->json('POST', 'api/v1/posts/5/comments', [
            'content' => ''
        ]);
        $response->assertStatus(422)->assertJson([
            "message" => "The content must be at least 5 characters.",
            "errors" => [
                "content" => [
                    "The content must be at least 5 characters."
                ]
            ]
        ]);
    }
}