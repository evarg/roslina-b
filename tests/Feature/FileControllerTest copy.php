<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Producer;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    private $apiUrl = "http://roslina-b.poligon/api/";

    public function test_file_store()
    {
        $producer = File::factory()->make();

        $this->postJson($this->apiUrl . 'files', $producer->toArray())
            ->assertStatus(201)
            ->assertJsonStructure(PRODUCER_JSON_RESPONSE);
    }

}
