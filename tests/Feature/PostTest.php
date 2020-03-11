<?php

namespace Tests\Feature;

use App\BlogPost;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No Blog Post yet!');
    }

    public function testSeeOneBlogPostsWhenThereIs1WithNoComments()
    {
        // Arrange
        $post = $this->createDummyBlogPost();

        // Act
        $response = $this->get('/posts');

        //Assert
        $response->assertSeeText('New Title');
        $response->assertSeeText('No comments yet!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title',
        ]);
    }

    public function testSee1BlogPostWithComments()
    {
        // Arrange
        $post = $this->createDummyBlogPost();

        factory(Comment::class, 4)->create([
            'blog_post_id' => $post->id,
        ]);

        // Act
        $response = $this->get('/posts');
        $response->assertSeeText('4 comments');

    }

    public function testStoreValid()
    {
        // $user = $this->user();

        // Arrange
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters',
        ];

        // Acting as authenticated user
        // $this->actingAs($user);

        // Act
        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302) // redirect successful
            ->assertSessionHas('status');
        //Assert
        $this->assertEquals(session('status'), 'Blog post was created!');
    }

    public function testStoreFail()
    {
        // Arrange
        $params = [
            'title' => 'x',
            'content' => 'x',
        ];

        // Act
        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302) // redirect successful
            ->assertSessionHas('errors');

        //Assert
        $messages = session('errors')->getMessages();
        //dd($messages->getMessages());

        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $user = $this->user();
        // Arrange
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', $post->toArray());

        // Arrange
        $params = [
            'title' => 'A new named title',
            'content' => 'Content was changed',
        ];

        // Act
        $this->actingAs($user)
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302) // redirect successful
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was updated!');

        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'A new named title',
        ]);

    }

    public function testDelete()
    {
        $user = $this->user();
        // Arrange
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', $post->toArray());

        // Act
        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302) // redirect successful
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was deleted!');
        // $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertSoftDeleted('blog_posts', $post->toArray());

    }

    private function createDummyBlogPost($userId = null): BlogPost
    {
        // $post = new BlogPost();
        // $post->title = 'New Title';
        // $post->content = 'Content of the blog post';
        // $post->save();

        return factory(BlogPost::class)->state('new-title')->create(
            [
                'user_id' => $userId ?? $this->user()->id,
            ]
        );

        // return $post;
    }
}
