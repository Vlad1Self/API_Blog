<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_tags()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->actingAs($user)->get('/api/client/tags?page=1&per_page=10&name=' . $tag->name);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $tag->name]);

    }

    public function test_store_tag()
    {
        $user = User::factory()->create();
        $data = ['name' => 'Test Tag'];

        $response = $this->actingAs($user)->post('/api/client/tags', $data);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Успешно создано']);
        $this->assertDatabaseHas('tags', $data);
    }

    public function test_update_tag()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();
        $data = [
            'id' => $tag->id,
            'name' => 'Updated Tag'
        ];

        $response = $this->actingAs($user)->put('/api/client/tags/' . $tag->id, $data);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Успешно обновлено']);
        $this->assertDatabaseHas('tags', $data);
    }

    public function test_delete_tag()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->actingAs($user)->delete('/api/client/tags/' . $tag->id);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Успешно удалено']);
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }
}
