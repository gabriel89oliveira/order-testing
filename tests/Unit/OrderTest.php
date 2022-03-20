<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Article;
use Tests\TestCase;

class OrderTest extends TestCase
{
    
    // Test if an order can be created
    public function test_create_order()
    {
        $this->actingAs($user = User::factory()->create());

        $articles = Article::factory()->count(5)->create();
        $response = $this->post('/api/order', ['items' => $articles]);
        
        $response->assertStatus(200);
    }
    
}
