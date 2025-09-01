<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPenjualan extends Model {
    protected $fillable = ['penjualan_id','barang_id','qty','harga_satuan','total'];
    
    public function penjualan(){ 
        return $this->belongsTo(Penjualan::class); 
    }
    
    public function barang(){ 
        return $this->belongsTo(Barang::class); 
    }
}