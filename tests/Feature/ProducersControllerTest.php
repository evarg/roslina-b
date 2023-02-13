<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Producer;
use Tests\TestCase;

class ProducersControllerTest extends TestCase
{
    private $apiUrl = "http://roslina-b.poligon/api/";

    public function test_producers_show_one()
    {
        $producer = Producer::factory()->create();

        $this->getJson($this->apiUrl . 'producers/' . $producer->id)
            ->assertStatus(200)
            ->assertJsonStructure(PRODUCER_JSON_RESPONSE);
    }

    public function test_producers_show_all()
    {
        $this->getJson($this->apiUrl . 'producers')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => PRODUCER_JSON_RESPONSE
            ]);
    }

    public function test_producers_create()
    {
        $producer = Producer::factory()->make();

        $this->postJson($this->apiUrl . 'producers', $producer->toArray())
            ->assertStatus(201)
            ->assertJsonStructure(PRODUCER_JSON_RESPONSE);
    }

    public function test_producers_update()
    {
        $producer_old = Producer::factory()->create();
        $producer_new = Producer::factory()->make();
        $this->putJson($this->apiUrl . 'producers/' . $producer_old->id, $producer_new->toArray())
            ->assertStatus(201)
            ->assertJsonStructure(PRODUCER_JSON_RESPONSE)
            ->assertJson([
                "name" => $producer_new->name,
                "desc" => $producer_new->desc,
                "country" => $producer_new->country,
            ]);
    }

    public function test_producers_create_with_no_name()
    {
        $this->postJson($this->apiUrl . 'producers', ['name' => ''])
            ->assertStatus(422);
    }

    public function test_producers_create_without_name()
    {
        $this->postJson($this->apiUrl . 'producers', [])
            ->assertStatus(422);
    }

    public function test_delete()
    {
        $producer = Producer::factory()->create();

        $this->postJson($this->apiUrl . 'producers', $producer->toArray())
            ->assertStatus(201);

        $this->deleteJson($this->apiUrl . 'producers/' . $producer->id)
            ->assertStatus(201);

        $this->getJson($this->apiUrl . 'producers/' . $producer->id)
            ->assertStatus(404);
    }
}
