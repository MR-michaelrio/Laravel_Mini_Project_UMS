<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model {
    protected $fillable = ['kode','nama','kategori','harga'];
    public function itemPenjualans(){ 
        return $this->hasMany(ItemPenjualan::class); 
    }
}