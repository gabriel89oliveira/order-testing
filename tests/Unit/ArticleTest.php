<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    
    // Test if an article can be created
    public function test_create_article()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->post('/api/article', [
            'article_name' => 'Test Article',
            'article_code' => '1234',
            'article_price' => '12,30'
        ]);

        $response->assertStatus(200);
    }

}
