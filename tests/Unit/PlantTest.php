<?php
namespace Tests\Feature;

use App\Models\Plante;
use App\Models\Category;
use Tests\TestCase;

class PlanteControllerTest extends TestCase
{
    // Test fetching all plants
    public function test_user_can_fetch_all_plants()
    {
        $response = $this->json('GET', '/api/plantes');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'price', 'description', 'image', 'categorie_id', 'slug'],
        ]);
    }

    // Test creating a plant
    public function test_user_can_create_plant()
    {
        $category = Category::factory()->create();  // Assuming you have a category factory

        $response = $this->json('POST', '/api/plantes', [
            'name' => 'Aloe Vera',
            'price' => 20,
            'description' => 'A succulent plant.',
            'image' => 'image_path.jpg',
            'categorie_id' => $category->id,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id', 'name', 'price', 'description', 'image', 'categorie_id', 'slug',
        ]);
    }

    // Test creating a plant with invalid data
    public function test_user_cannot_create_plant_with_invalid_data()
    {
        $response = $this->json('POST', '/api/plantes', [
            'name' => '',
            'price' => -10,
            'description' => '',
            'image' => '',
            'categorie_id' => 999,  // Assuming this ID doesn't exist
        ]);

        $response->assertStatus(400);  // Bad Request due to validation errors
        $response->assertJsonStructure(['error']);
    }

    // Test fetching a single plant by ID
    public function test_user_can_fetch_single_plant()
    {
        $plante = Plante::factory()->create();

        $response = $this->json('GET', '/api/plantes/' . $plante->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id', 'name', 'price', 'description', 'image', 'categorie_id', 'slug',
        ]);
    }

    // Test fetching a single plant that doesn't exist
    public function test_user_cannot_fetch_non_existing_plant()
    {
        $response = $this->json('GET', '/api/plantes/9999');  // Assuming no plant with this ID

        $response->assertStatus(404);  // Not Found
        $response->assertJson(['error' => 'Plant not found']);
    }

    // Test updating a plant
    public function test_user_can_update_plant()
    {
        $plante = Plante::factory()->create();
        $category = Category::factory()->create();

        $response = $this->json('PUT', '/api/plantes/' . $plante->id, [
            'name' => 'Updated Plant',
            'price' => 30,
            'description' => 'Updated description',
            'image' => 'updated_image_path.jpg',
            'categorie_id' => $category->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $plante->id,
            'name' => 'Updated Plant',
            'price' => 30,
            'description' => 'Updated description',
            'image' => 'updated_image_path.jpg',
            'categorie_id' => $category->id,
            'slug' => 'updated-plant',
        ]);
    }

    // Test updating a plant with invalid data
    public function test_user_cannot_update_plant_with_invalid_data()
    {
        $plante = Plante::factory()->create();

        $response = $this->json('PUT', '/api/plantes/' . $plante->id, [
            'name' => '',
            'price' => -10,
            'description' => '',
            'image' => '',
            'categorie_id' => 999,  // Assuming this ID doesn't exist
        ]);

        $response->assertStatus(400);  // Bad Request due to validation errors
        $response->assertJsonStructure(['error']);
    }

    // Test deleting a plant
    public function test_user_can_delete_plant()
    {
        $plante = Plante::factory()->create();

        $response = $this->json('DELETE', '/api/plantes/' . $plante->id);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Plant deleted successfully']);
    }

    // Test deleting a plant that doesn't exist
    public function test_user_cannot_delete_non_existing_plant()
    {
        $response = $this->json('DELETE', '/api/plantes/9999');  // Assuming no plant with this ID

        $response->assertStatus(404);  // Not Found
        $response->assertJson(['error' => 'Plant not found']);
    }

    // Test fetching a plant by slug
    public function test_user_can_fetch_plant_by_slug()
    {
        $plante = Plante::factory()->create([
            'slug' => 'aloe-vera',
        ]);

        $response = $this->json('GET', '/api/plantes/slug/aloe-vera');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id', 'name', 'price', 'description', 'image', 'categorie_id', 'slug',
        ]);
    }

    // Test fetching a non-existing plant by slug
    public function test_user_cannot_fetch_non_existing_plant_by_slug()
    {
        $response = $this->json('GET', '/api/plantes/slug/non-existing-slug');

        $response->assertStatus(404);  // Not Found
        $response->assertJson(['error' => 'Plant not found']);
    }
}
