<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Packet;
use Tests\TestCase;

class PacketControllerTest extends TestCase
{
    private $apiUrl = "http://roslina-b.poligon/api/";

    public function test_packets_show_one()
    {
        $packet = Packet::factory()->create();

        $this->getJson($this->apiUrl . 'packets/' . $packet->id)
            ->assertStatus(200)
            ->assertJsonStructure(PACKET_JSON_RESPONSE);
    }

    public function test_packets_show_all()
    {
        $this->getJson($this->apiUrl . 'packets')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => PACKET_JSON_RESPONSE
            ]);
    }

    public function test_packets_create()
    {
        $packet = Packet::factory()->make();

        $this->postJson($this->apiUrl . 'packets', $packet->toArray())
            ->assertStatus(201)
            ->assertJsonStructure(PACKET_JSON_RESPONSE);
    }

    public function test_packets_update()
    {
        $packet_old = Packet::factory()->create();
        $packet_new = Packet::factory()->make();
        $this->putJson($this->apiUrl . 'packets/' . $packet_old->id, $packet_new->toArray())
            ->assertStatus(201)
            ->assertJsonStructure(PACKET_JSON_RESPONSE)
            ->assertJson([
                "name" => $packet_new->name,
                "desc" => $packet_new->desc,
                "name_polish" => $packet_new->name_polish,
                "name_latin" => $packet_new->name_latin,
                "producer" => $packet_new->producer,
                "expiration_date" => $packet_new->expiration_date,
                "purchase_date" => $packet_new->purchase_date
            ]);
    }

    public function test_packets_create_with_no_name()
    {
        $this->postJson($this->apiUrl . 'packets', ['name' => ''])
            ->assertStatus(422);
    }

    public function test_packets_create_without_name()
    {
        $this->postJson($this->apiUrl . 'packets', [])
            ->assertStatus(422);
    }

    public function test_delete()
    {
        $packet = Packet::factory()->create();

        $this->postJson($this->apiUrl . 'packets', $packet->toArray())
            ->assertStatus(201);

        $this->deleteJson($this->apiUrl . 'packets/' . $packet->id)
            ->assertStatus(201);

        $this->getJson($this->apiUrl . 'packets/' . $packet->id)
            ->assertStatus(404);
    }
}
