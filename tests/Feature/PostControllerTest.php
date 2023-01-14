<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test database when its empty
     *
     * @return void
     */
    public function test_database_when_its_does_not_have_any_posts()
    {
        $response = $this->actingAs($this->user(), 'web')->get('/posts');

        $response->assertSeeText('No posts found.');
        // $response->assertStatus(302);
    }

    /**
     * retrieve a post
     *
     * @return void
     */
    public function test_create_post_and_retrieve_it()
    {
        $post = $this->getDummyBlogPost();

        $response = $this->actingAs($this->user(), 'web')->get('/posts');

        $response->assertSeeText('New Title');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title',
        ]);
    }

    public function test_blog_post_with_comments()
    {
        $user = $this->user();

        $post = $this->getDummyBlogPost();
        Comment::factory()->count(4)->create([
            'commentable_id' => $post->id,
            'commentable_type' => 'App\Models\BlogPost',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($this->user(), 'web')->get('/posts');
        $response->assertSeeText('4 comments');
    }

    public function test_store_method()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'at least 5 characters'
        ];
        $this->actingAs($this->user(), 'web')->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('success');
        $this->assertEquals(session('success'), 'Post was created.');
    }

    public function test_store_method_in_fail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x',
        ];

        $this->actingAs($this->user(), 'web')->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $errors = session('errors');

        $this->assertEquals($errors->get('title')[0], 'The title must be at least 5 characters.');

        // dd($errors->get('title')[0]);
    }
    public function test_update_method()
    {
        // dd($this->usingInMemoryDatabase());
        // $this->usingInMemoryDatabase()
        //     ? $this->refreshInMemoryDatabase()
        //     : $this->refreshTestDatabase();

        // $post = new BlogPost();
        // $post->title = 'New Title';
        // $post->content = 'Content of the blog post';
        // $post->save();

        $user = $this->user();

        $post = $this->getDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);

        $params = [
            'title' => 'A new named title',
            'content' => 'Content',
        ];

        $this->actingAs($user, 'web')->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertEquals(session('success'), 'Post was updated.');
        $this->assertDatabaseMissing('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);
    }

    public function test_delete_method()
    {
        $user = $this->user();
        $post = $this->getDummyBlogPost($user->id);
        // dd($post->toArray());
        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title,
        ]);

        $this->actingAs($user, 'web')
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertEquals(session('success'), 'Post was deleted.');

        // $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertSoftDeleted('blog_posts', [
            'title' => $post->title
        ]);
    }
    private function getDummyBlogPost($userId = null): BlogPost
    {
        // $post = new BlogPost();
        // $post->title = 'New Title';
        // $post->content = 'Content of the blog post';
        // $post->save();

        // dd(BlogPost::factory()->newTitlePost()->create());
        return BlogPost::factory()->newTitlePost()->create(
            [
                'user_id' => $userId ?? $this->user()->id,
            ]
        );

        // return $post;
    }
}