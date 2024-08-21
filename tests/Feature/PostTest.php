<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_posts()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($user)->get('/api/client/posts?page=1&per_page=10&title=' . $post->title);

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => $post->title]);
    }

    public function test_store_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $tag = Tag::factory()->create();
        $data = [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'category_id' => $category->id,
            'tag_id' => [$tag->id]
        ];

        $response = $this->actingAs($user)->post('/api/client/posts', $data);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Успешно создано']);
        $this->assertDatabaseHas('posts', ['title' => $data['title'], 'content' => $data['content'], 'category_id' => $data['category_id']]);
        $this->assertDatabaseHas('post_tag', ['post_id' => Post::where('title', $data['title'])->first()->id, 'tag_id' => $data['tag_id'][0]]);
    }

    public function test_update_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id]);
        $newCategory = Category::factory()->create();
        $tag = Tag::factory()->create();
        $data = [
            'id' => $post->id,
            'title' => 'Updated Post',
            'content' => 'This is an updated post.',
            'category_id' => $newCategory->id,
            'tag_id' => [$tag->id]
        ];

        $response = $this->actingAs($user)->put('/api/client/posts/' . $post->id, $data);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Успешно обновлено']);
        $this->assertDatabaseHas('posts', ['title' => $data['title'], 'content' => $data['content'], 'category_id' => $data['category_id']]);
        $this->assertDatabaseHas('post_tag', ['post_id' => $post->id, 'tag_id' => $data['tag_id'][0]]);
    }

    public function test_delete_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($user)->delete('/api/client/posts/' . $post->id);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Успешно удалено']);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
