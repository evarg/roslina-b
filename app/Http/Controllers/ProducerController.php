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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new JsonResponse(Producer::all(), 200);
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
    public function show(Packet $producer, Request $request)
    {
        //        $producer->packets = $producer->packets;
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
        ;
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
