<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Packet;
use App\Models\Producer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PacketControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $apiUrl = "http://roslina-b.poligon/api/";

    public function test_packets_show_one()
    {
        $packet = Packet::factory()->create([
            'producer_id' => Producer::factory()->create()->id]
        );

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

    public function test_packets_create_with_exists_producer()
    {
        $producer = Producer::factory()->create();
        $packet = Packet::factory()->make([
            'producer_id' => $producer->id
        ]);

        $this->postJson($this->apiUrl . 'packets', $packet->toArray())
            ->assertStatus(201)
            ->assertJsonStructure([]);
    }

    public function test_packets_create_with_no_exists_producer()
    {
        $packet = Packet::factory()->make([
            'producer_id' => 999999
        ]);

        $this->postJson($this->apiUrl . 'packets', $packet->toArray())
            ->assertStatus(422);
    }

    public function test_packets_update_with_exists_producer()
    {
        $producer_old = Producer::factory()->create();
        $producer_new = Producer::factory()->create();
        $packet_old = Packet::factory()->create(['producer_id' => $producer_old->id]);
        $packet_new = Packet::factory()->make(['producer_id' => $producer_new->id]);

        $this->putJson($this->apiUrl . 'packets/' . $packet_old->id, $packet_new->toArray())
            ->assertStatus(201)
            ->assertJson([
                "name" => $packet_new->name,
                "desc" => $packet_new->desc,
                "name_polish" => $packet_new->name_polish,
                "name_latin" => $packet_new->name_latin,
                "expiration_date" => $packet_new->expiration_date,
                "purchase_date" => $packet_new->purchase_date,
                'producer_id' => $packet_new->producer_id,
                //'producer' => [
                //     'id' => $producer_new->id,
                //     'name' => $producer_new->name,
                //     'country' => $producer_new->country
                //]
            ]);
    }

    public function test_packets_update_with_no_exists_producer()
    {
        $producer_old = Producer::factory()->create();
        $packet_old = Packet::factory()->create(['producer_id' => $producer_old->id]);
        $packet_new = Packet::factory()->make(['producer_id' => 999999]);

        $this->putJson($this->apiUrl . 'packets/' . $packet_old->id, $packet_new->toArray())
            ->assertStatus(422);
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
