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
     *   path="/producers",
     *   summary="Get list of all producers",
     *   description="
          Get list of all producers. Targer functionality is:
           - get global defined producers
           - get logged in user defined producers
           - get shared producers of other users
           - if user is admin get all producers
      *     ",
     *   tags={"producer"},
     *   security={ {"bearer": {} }},
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="packets", type="array",
     *         @OA\Items(
     *           allOf={
     *             @OA\Schema(ref="#/components/schemas/User"),
     *           },
     *         ),
     *       ),
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     ref="#/components/responses/ApiResponse401"
     *   )
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
