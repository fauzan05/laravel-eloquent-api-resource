<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    public function testResource()
    {
        $this->seed(CategorySeeder::class);
        $category = Category::first();
        $this->get("/api/categories/$category->id")
                ->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'id' => $category->id,
                        'name' => $category->name,
                        'created_at' => $category->created_at->toJSON(),
                        'updated_at'=> $category->updated_at->toJSON(),
                    ]
                    ]);
    }

    public function testResourceCollection()
    {
        $this->seed(CategorySeeder::class);
        $category = Category::all();
        $this->get('/api/categories')
            ->assertStatus(200)
            ->assertJson([
                'data' => [[
                    'id' => $category[0]->id,
                    'name' => $category[0]->name,
                    'created_at' => $category[0]->created_at->toJSON(),
                    'updated_at'=> $category[0]->updated_at->toJSON(),
                ],
                [
                    'id' => $category[1]->id,
                    'name' => $category[1]->name,
                    'created_at' => $category[1]->created_at->toJSON(),
                    'updated_at'=> $category[1]->updated_at->toJSON(),
                ]
                ]]);
    }

    public function testProductResource()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $products = Product::first();
        $this->get("/api/products/$products->id")
            ->assertStatus(200);
    }
    public function testProductCollection()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $response = $this->get("/api/products-collections")
            ->assertStatus(200);
        $names = $response->json("data.*.name");
        // var_dump($names);
        for ($i = 0; $i < count($names)-5; $i++) {
            self::assertContains("Product $i of Gadget", $names);
            // self::assertContains("Product $i of Food", $names);
        }
    }

    public function testLoad()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $products = Product::first();
        // var_dump($products);
    }
}
  