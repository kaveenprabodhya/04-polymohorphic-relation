<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $admin = User::factory()->create([
        //     'name' => 'Kaveen',
        //     'email' => 'kaveen@gmail.com'
        // ]);

        // $commons = User::factory(10)->create();

        // $users = $commons->concat([$admin]);

        // $posts = BlogPost::factory(50)->make()->each(function ($post) use ($users) {
        //     $post->user_id = $users->random()->id;
        //     $post->save();
        // });

        // $comments = Comment::factory(150)->make()->each(function ($comment) use ($posts) {
        //     $comment->blog_post_id = $posts->random()->id;
        //     $comment->save();
        // });


        if ($this->command->confirm('Do you want ot refresh the database?')) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed.');
        }

        $this->call([
            UserSeeder::class,
            BlogPostSeeder::class,
            CommentSeeder::class,
            TagsTableSeeder::class,
            BlogPostTagTableSeeder::class
        ]);
    }
}