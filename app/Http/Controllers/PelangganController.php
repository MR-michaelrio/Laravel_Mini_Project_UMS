<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Http\Requests\{StorePelangganRequest, UpdatePelangganRequest};

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Pelanggan::query()->latest()->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePelangganRequest $request)
    {
        return Pelanggan::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePelangganRequest $request, Pelanggan $pelanggan)
    {
        $pelanggan->update($request->validated());
        return response()->json($pelanggan, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return response()->json(null, 204);
    }
}
