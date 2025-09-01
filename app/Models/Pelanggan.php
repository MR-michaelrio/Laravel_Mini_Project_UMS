<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model {
    protected $fillable = ['kode','nama','domisili','jenis_kelamin'];
    public function penjualans(){ 
        return $this->hasMany(Penjualan::class); 
    }
}
