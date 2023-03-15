<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepacketRequest;
use App\Http\Requests\UpdatepacketRequest;
use App\Http\Requests\UploadFileToPacketRequest;

use App\Models\Packet;
use App\Models\File;
use Illuminate\Http\JsonResponse;

class PacketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new JsonResponse(Packet::with('producer')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepacketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepacketRequest $request)
    {
        $packet = new Packet($request->all());
        $packet->save();

        $packet = Packet::with('producer')->find($packet->id);
        return new JsonResponse($packet, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\packet  $packet
     * @return \Illuminate\Http\Response
     */
    public function show(packet $packet)
    {
        $packet->producer = $packet->producer;
        $packet->files = $packet->files;
        return new JsonResponse($packet, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepacketRequest  $request
     * @param  \App\Models\packet  $packet
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepacketRequest $request, packet $packet)
    {
        $packet->update($request->all());;
        //$packet->producer = $packet->producer;
        return new JsonResponse($packet, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\packet  $packet
     * @return \Illuminate\Http\Response
     */
    public function destroy(packet $packet)
    {
        $packet->delete();
        return new JsonResponse(null, 201);
    }

    public function addFile(string $id, string $fileID)
    {
        $packet = Packet::findOrFail($id);
        $file = File::findOrFail($fileID);

        $packet->files()->attach($file);
        $packet->save();

        return new JsonResponse($packet, 201);
    }

    public function addFileUpload(UploadFileToPacketRequest $request, int $id)
    {
        $packet = Packet::findOrFail($id);

        $file = new File($request->all());
        $file->name = $request->file('image')->getClientOriginalName();
        $file->file_name = $request->file('image')->store('public/images');
        $file->org_name = $request->file('image')->getClientOriginalName();
        $file->size = $request->file('image')->getSize();
        $file->mime = $request->file('image')->getMimeType();
        $file->save();

        $packet->files()->attach($file);

        return new JsonResponse($request->all(), 201);
    }

    public function removeFile(string $id, string $fileID)
    {
        $packet = Packet::findOrFail($id);
        $file = File::findOrFail($fileID);

        $packet->files()->detach($file);
        $packet->save();

        return new JsonResponse($packet, 201);
    }
}
