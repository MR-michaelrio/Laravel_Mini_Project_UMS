<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model {
    protected $fillable = ['nota','tgl','pelanggan_id','subtotal'];
    protected $casts = ['tgl' => 'date:Y-m-d'];

    public function pelanggan(){ 
        return $this->belongsTo(Pelanggan::class); 
    }

    public function items(){ 
        return $this->hasMany(ItemPenjualan::class); 
    }
}
