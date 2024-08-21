<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_categories()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->get('/api/client/categories?name=' . $category->name);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }


    public function test_store_category()
    {
        $user = User::factory()->create();
        $data = ['name' => 'Test Category'];

        $response = $this->actingAs($user)->post('/api/client/categories', $data);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Успешно создано']);
        $this->assertDatabaseHas('categories', $data);
    }

    public function test_update_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $data = [
            'id' => $category->id,
            'name' => 'Updated Category'
        ];

        $response = $this->actingAs($user)->put('/api/client/categories/' . $category->id, $data);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Успешно обновлено']);
        $this->assertDatabaseHas('categories', $data);
    }

    public function test_delete_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->delete('/api/client/categories/' . $category->id);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Успешно удалено']);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
