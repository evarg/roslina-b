<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use App\Http\Requests\StoreProducerRequest;
use App\Http\Requests\UpdateProducerRequest;
use App\Models\Packet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProducerController extends Controller
{
    /**
     * @OA\Get(
     * path="/producers",
     * summary="Retrieve profile information",
     * description="Get profile short information",
     * operationId="profileShow2",
     * tags={"profile2"},
     * security={ {"bearer": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="object", ref="#/components/schemas/producersList")
     *        )
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="User should be authorized to get profile information",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized"),
     *    )
     * )
     * )
     */
    public function index()
    {
        $producersList = [
            "data" => Producer::all()
        ];
        return new JsonResponse($producersList, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProducerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProducerRequest $request)
    {
        $producer = new Producer($request->all());
        $producer->save();
        return new JsonResponse(Producer::find($producer->id), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producer $producer
     * @return \Illuminate\Http\Response
     */
    public function show(Producer $producer, Request $request)
    {
        $producer = Producer::with('packets')->findOrFail($producer->id);
        return new JsonResponse($producer, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProducerRequest $request
     * @param  \App\Models\Producer                     $producer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProducerRequest $request, Producer $producer)
    {
        $producer->update($request->all());
        return new JsonResponse(Producer::find($producer->id), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producer $producer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producer $producer)
    {
        foreach ($producer->packets as $packet) {
            $packet->delete();
        }

        $producer->delete();
        return new JsonResponse(null, 201);
    }
}
