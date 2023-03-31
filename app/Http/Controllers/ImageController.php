<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    private $directoryTarget = 'images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreimageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreimageRequest $request)
    {
        $requestImage = $request->file('image');
        //var_dump($requestImage);
        //die();

        $filename_guid = $this->directoryTarget . '/' . Image::GUID();

        Storage::disk('public')->move($requestImage->getPathname(), $filename_guid);

        $file = new Image($request->all());
        $file->file_name = $requestImage->store('public/images');
        $file->org_name = $requestImage->getClientOriginalName();
        $file->size = $requestImage->getSize();
        $file->mime = $requestImage->getMimeType();
        $file->save();
        return new JsonResponse($file, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateimageRequest  $request
     * @param  \App\Models\image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateimageRequest $request, image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(image $image)
    {
        //
    }
}
