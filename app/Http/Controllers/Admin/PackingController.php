<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Packing;
use App\Http\Requests\StorePackingRequest;
use App\Http\Requests\UpdatePackingRequest;

class PackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Packing $packing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Packing $packing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackingRequest $request, Packing $packing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Packing $packing)
    {
        //
    }
}
