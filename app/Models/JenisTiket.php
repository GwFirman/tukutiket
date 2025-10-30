<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTiket extends Model
{
    protected $table  = 'jenis_tiket';
protected $fillable = [
    'id_acara',
    'nama_jenis',
    'harga',
    'kuota',
    'deskripsi',
    'penjualan_mulai',
    'penjualan_selesai',
];

    public function acara() {
        return $this->belongsTo(Acara::class,'id_acara');
    }

    
}
