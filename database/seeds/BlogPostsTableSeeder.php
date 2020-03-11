<?php

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogPostsCount = (int) $this->command->ask('How many blog posts would you like?', 50);
        $users = App\User::all();
        // make will just instantiate BlogPost not create
        factory(App\BlogPost::class, $blogPostsCount)->make()->each(function ($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
