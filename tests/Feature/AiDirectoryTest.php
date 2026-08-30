<?php

namespace Tests\Feature;

use App\Models\AiTool;
use App\Models\Category;
use Database\Seeders\AiToolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AiDirectoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AiToolSeeder::class);
    }

    public function test_home_page_displays_categories_and_tools(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('เขียนโค้ด');
        $response->assertSee('สร้างภาพ');
        $response->assertSee('Claude');
        $response->assertSee('Midjourney');
    }

    public function test_tool_detail_page_loads_successfully(): void
    {
        $tool = AiTool::first();
        $response = $this->get('/tool/' . $tool->slug);

        $response->assertStatus(200);
        $response->assertSee($tool->name);
        $response->assertSee($tool->website_url);
    }

    public function test_api_search_endpoint_returns_json(): void
    {
        $response = $this->getJson('/api/search?q=Cursor');

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Cursor']);
    }

    public function test_category_filter_query(): void
    {
        $response = $this->get('/?category=coding');

        $response->assertStatus(200);
        $response->assertSee('Cursor');
    }
}
