<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Pelanggan,Barang,Penjualan};
use Carbon\Carbon;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Pelanggan
        $pelanggan = [
            ['kode'=>'PELANGGAN_1','nama'=>'ANDI','domisili'=>'JAK-UT','jenis_kelamin'=>'PRIA'],
            ['kode'=>'PELANGGAN_2','nama'=>'BUDI','domisili'=>'JAK-BAR','jenis_kelamin'=>'PRIA'],
            ['kode'=>'PELANGGAN_3','nama'=>'JOHAN','domisili'=>'JAK-SEL','jenis_kelamin'=>'PRIA'],
            ['kode'=>'PELANGGAN_4','nama'=>'SINTHA','domisili'=>'JAK-TIM','jenis_kelamin'=>'WANITA'],
            ['kode'=>'PELANGGAN_5','nama'=>'ANTO','domisili'=>'JAK-UT','jenis_kelamin'=>'PRIA'],
            ['kode'=>'PELANGGAN_6','nama'=>'BUJANG','domisili'=>'JAK-BAR','jenis_kelamin'=>'PRIA'],
            ['kode'=>'PELANGGAN_7','nama'=>'JOWAN','domisili'=>'JAK-SEL','jenis_kelamin'=>'PRIA'],
            ['kode'=>'PELANGGAN_8','nama'=>'SINTIA','domisili'=>'JAK-TIM','jenis_kelamin'=>'WANITA'],
            ['kode'=>'PELANGGAN_9','nama'=>'BUTET','domisili'=>'JAK-BAR','jenis_kelamin'=>'WANITA'],
            ['kode'=>'PELANGGAN_10','nama'=>'JONNY','domisili'=>'JAK-SEL','jenis_kelamin'=>'WANITA'],
        ];
        foreach($pelanggan as $p){ Pelanggan::create($p); }

        // Data Barang
        $barang = [
            ['kode'=>'BRG_1','nama'=>'PEN','kategori'=>'ATK','harga'=>15000],
            ['kode'=>'BRG_2','nama'=>'PENSIL','kategori'=>'ATK','harga'=>10000],
            ['kode'=>'BRG_3','nama'=>'PAYUNG','kategori'=>'RT','harga'=>70000],
            ['kode'=>'BRG_4','nama'=>'PANCI','kategori'=>'MASAK','harga'=>110000],
            ['kode'=>'BRG_5','nama'=>'SAPU','kategori'=>'RT','harga'=>40000],
            ['kode'=>'BRG_6','nama'=>'KIPAS','kategori'=>'ELEKTRONIK','harga'=>200000],
            ['kode'=>'BRG_7','nama'=>'KUALI','kategori'=>'MASAK','harga'=>120000],
            ['kode'=>'BRG_8','nama'=>'SIKAT','kategori'=>'RT','harga'=>30000],
            ['kode'=>'BRG_9','nama'=>'GELAS','kategori'=>'RT','harga'=>25000],
            ['kode'=>'BRG_10','nama'=>'PIRING','kategori'=>'RT','harga'=>35000],
        ];
        foreach($barang as $b){ Barang::create($b); }

        // Data Penjualan + Items
        $mapPelanggan = Pelanggan::pluck('id','kode');
        $mapBarang = Barang::pluck('id','kode');

        $trans = [
            [
              'nota'=>'NOTA_1','tgl'=>'01/01/2018','kode_pelanggan'=>'PELANGGAN_1','items'=>[
                ['kode_barang'=>'BRG_1','qty'=>2],
                ['kode_barang'=>'BRG_2','qty'=>2],
              ]
            ],
            [
              'nota'=>'NOTA_2','tgl'=>'01/01/2018','kode_pelanggan'=>'PELANGGAN_2','items'=>[
                ['kode_barang'=>'BRG_6','qty'=>1],
              ]
            ],
            [
              'nota'=>'NOTA_3','tgl'=>'01/01/2018','kode_pelanggan'=>'PELANGGAN_3','items'=>[
                ['kode_barang'=>'BRG_4','qty'=>1],
                ['kode_barang'=>'BRG_7','qty'=>1],
                ['kode_barang'=>'BRG_6','qty'=>1],
              ]
            ],
            [
              'nota'=>'NOTA_4','tgl'=>'02/01/2018','kode_pelanggan'=>'PELANGGAN_7','items'=>[
                ['kode_barang'=>'BRG_9','qty'=>2],
                ['kode_barang'=>'BRG_10','qty'=>2],
              ]
            ],
            [
              'nota'=>'NOTA_5','tgl'=>'02/01/2018','kode_pelanggan'=>'PELANGGAN_4','items'=>[
                ['kode_barang'=>'BRG_3','qty'=>1],
              ]
            ],
            [
              'nota'=>'NOTA_6','tgl'=>'03/01/2018','kode_pelanggan'=>'PELANGGAN_8','items'=>[
                ['kode_barang'=>'BRG_7','qty'=>1],
                ['kode_barang'=>'BRG_5','qty'=>1],
                ['kode_barang'=>'BRG_3','qty'=>1],
              ]
            ],
            [
              'nota'=>'NOTA_7','tgl'=>'03/01/2018','kode_pelanggan'=>'PELANGGAN_9','items'=>[
                ['kode_barang'=>'BRG_5','qty'=>1],
                ['kode_barang'=>'BRG_6','qty'=>1],
                ['kode_barang'=>'BRG_7','qty'=>1],
                ['kode_barang'=>'BRG_8','qty'=>1],
              ]
            ],
            [
              'nota'=>'NOTA_8','tgl'=>'03/01/2018','kode_pelanggan'=>'PELANGGAN_5','items'=>[
                ['kode_barang'=>'BRG_5','qty'=>1],
                ['kode_barang'=>'BRG_9','qty'=>1],
              ]
            ],
            [
              'nota'=>'NOTA_9','tgl'=>'04/01/2018','kode_pelanggan'=>'PELANGGAN_2','items'=>[
                ['kode_barang'=>'BRG_5','qty'=>1],
              ]
            ],
            [
              'nota'=>'NOTA_10','tgl'=>'04/01/2018','kode_pelanggan'=>'PELANGGAN_1','items'=>[
                ['kode_barang'=>'BRG_5','qty'=>10],
              ]
            ],
        ];

        foreach($trans as $t){
            $tgl = Carbon::createFromFormat('d/m/Y',$t['tgl'])->format('Y-m-d');
            $p = Penjualan::create([
                'nota'=>$t['nota'],
                'tgl'=>$tgl,
                'pelanggan_id'=>$mapPelanggan[$t['kode_pelanggan']],
                'subtotal'=>0,
            ]);
            $subtotal=0;
            foreach($t['items'] as $it){
                $barangId = $mapBarang[$it['kode_barang']];
                $harga = Barang::find($barangId)->harga;
                $qty = (int)$it['qty'];
                $total = $harga * $qty;
                $p->items()->create([
                    'barang_id'=>$barangId,
                    'qty'=>$qty,
                    'harga_satuan'=>$harga,
                    'total'=>$total,
                ]);
                $subtotal += $total;
            }
            $p->update(['subtotal'=>$subtotal]);
        }
    }
}
