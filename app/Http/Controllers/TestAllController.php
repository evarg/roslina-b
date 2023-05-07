<?php

namespace App\Http\Controllers;

use App\Models\TestAll;
use App\Http\Requests\StoreTestAllRequest;
use App\Http\Requests\UpdateTestAllRequest;
use Illuminate\Http\JsonResponse;
use RuntimeException;

class TestAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTestAllRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTestAllRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestAll  $testAll
     * @return \Illuminate\Http\Response
     */
    public function show(TestAll $testAll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestAll  $testAll
     * @return \Illuminate\Http\Response
     */
    public function edit(TestAll $testAll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTestAllRequest  $request
     * @param  \App\Models\TestAll  $testAll
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTestAllRequest $request, TestAll $testAll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestAll  $testAll
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestAll $testAll)
    {
        //
    }
}
