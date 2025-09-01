<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\Barang;
use App\Models\ItemPenjualan;
use App\Http\Requests\{StorePenjualanRequest, UpdatePenjualanRequest};

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Penjualan::with(['pelanggan','items.barang'])->latest('tgl')->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenjualanRequest $request)
    {
        
        return DB::transaction(function() use ($request){
            $data = $request->validated();
            $tgl = str_contains($data['tgl'],'/')
            ? Carbon::createFromFormat('d/m/Y',$data['tgl'])->format('Y-m-d')
            : Carbon::parse($data['tgl'])->format('Y-m-d');
            
            
            $pelanggan = Pelanggan::where('kode',$data['kode_pelanggan'])->firstOrFail();
            $penjualan = Penjualan::create([
                'nota' => $data['nota'],
                'tgl' => $tgl,
                'pelanggan_id' => $pelanggan->id,
                'subtotal' => 0,
            ]);
            
            
            $subtotal = 0;
            foreach($data['items'] as $item){
                $barang = Barang::where('kode',$item['kode_barang'])->firstOrFail();
                $harga = $barang->harga;
                $qty = (int)$item['qty'];
                $total = $harga * $qty;
                $penjualan->items()->create([
                    'barang_id' => $barang->id,
                    'qty' => $qty,
                    'harga_satuan' => $harga,
                    'total' => $total,
                ]);
                $subtotal += $total;
            }
            
            
            $penjualan->update(['subtotal' => $subtotal]);
            return $penjualan->load(['pelanggan','items.barang']);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $id->load(['pelanggan','items.barang']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenjualanRequest $request, Penjualan $penjualan)
    {
        return DB::transaction(function() use ($request, $penjualan) {
            $data = $request->validated();

            if (isset($data['tgl'])) {
                $tgl = str_contains($data['tgl'], '/')
                    ? Carbon::createFromFormat('d/m/Y', $data['tgl'])->format('Y-m-d')
                    : Carbon::parse($data['tgl'])->format('Y-m-d');
                $penjualan->tgl = $tgl;
            }

            if (isset($data['kode_pelanggan'])) {
                $pelanggan = Pelanggan::where('kode', $data['kode_pelanggan'])->firstOrFail();
                $penjualan->pelanggan_id = $pelanggan->id;
            }

            $subtotal = 0;

            if (isset($data['items'])) {
                $penjualan->items()->delete();

                foreach ($data['items'] as $item) {
                    $barang = Barang::where('kode', $item['kode_barang'])->firstOrFail();
                    $harga = $barang->harga;
                    $qty   = (int) $item['qty'];
                    $total = $harga * $qty;

                    $penjualan->items()->create([
                        'barang_id'     => $barang->id,
                        'qty'           => $qty,
                        'harga_satuan'  => $harga,
                        'total'         => $total,
                    ]);

                    $subtotal += $total;
                }

                $penjualan->subtotal = $subtotal;
            }

            $penjualan->save();

            return $penjualan->load(['pelanggan', 'items.barang']);
        });
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        $penjualan->delete();
        return response()->noContent();
    }
}
