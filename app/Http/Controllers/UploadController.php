<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

use App\Models\File;
use App\Http\Requests\StoreUploadRequest;

class UploadController extends Controller
{
    private $directory_source = "ftp";
    private $directory_target = "images";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = array_map(function ($filename) {
            return [
                'name' => $filename,
                'name_encode' => base64_encode($filename)
            ];
        }, Storage::disk('public')->files($this->directory_source));

        $directories = array_map(function ($directoryname) {
            return [
                'name' => $directoryname,
                'name_encode' => base64_encode($directoryname)
            ];
        }, Storage::disk('public')->directories($this->directory_source));

        return new JsonResponse([
            'directories' => $directories,
            'files' => $files
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUploadRequest $request)
    {
        $filename = base64_decode($request->filename_source);
        if (!Storage::disk('public')->exists($filename)) {
            return new JsonResponse('Brak pliku: ' . $filename, 404 );
        }

        $mime_type = Storage::disk('public')->mimeType($filename);
        if ($mime_type != 'image/jpeg') {
            return new JsonResponse('Zły format pliku: ' . $mime_type, 404);
        }

        $filename_guid = $this->directory_target . '/' . File::GUID();

        Storage::disk('public')->move($filename, $filename_guid);

        $file = new File($request->all());
        $file->file_name = $filename_guid;
        $file->org_name = $filename;
        $file->size = Storage::disk('public')->size($filename_guid);
        $file->mime = $mime_type;
        $file->save();
        return new JsonResponse($file, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($encoded_filename)
    {
        $filename = base64_decode($encoded_filename);
        if (!Storage::disk('public')->exists($filename)) {
            return new JsonResponse('Brak pliku: ' . $filename, 404);
        }

        return [
            'encoded_filename' => $encoded_filename,
            'filename' => base64_decode($encoded_filename),
            'mime' => Storage::disk('public')->mimeType($filename),
            'size' => Storage::disk('public')->size($filename),
            'created_at' => Storage::disk('public')->lastModified($filename)
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($encoded_filename)
    {
        $filename = base64_decode($encoded_filename);
        if (!Storage::disk('public')->exists($filename)) {
            return new JsonResponse('Brak pliku: ' . $filename, 404);
        }

        Storage::disk('public')->delete($filename);
        return $filename;
    }
}
