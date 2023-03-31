<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use Tests\TestCase;

class FileControllerTest extends TestCase
{
    private $apiUrl = "http://roslina-b.poligon/api/";

    public function test_file_store()
    {
        $file = File::factory()->make();

        $this->postJson($this->apiUrl . 'files', $file->toArray())
            ->assertStatus(201)
            ->assertJsonStructure(PRODUCER_JSON_RESPONSE);
    }

}
