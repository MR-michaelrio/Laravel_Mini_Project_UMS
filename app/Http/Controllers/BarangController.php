<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Http\Requests\{StoreBarangRequest, UpdateBarangRequest};

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Barang::latest()->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangRequest $request)
    {
        return Barang::create($request->validated());
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
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $barang->update($request->validated());
        return response()->json($barang, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return response()->noContent();
    }
}
