<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanan';

    protected $fillable = [
        'id',
        'id_pesanan',
        'id_jenis_tiket',
        'jumlah',
        'harga_per_tiket',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    public function jenisTiket()
    {
        return $this->belongsTo(JenisTiket::class, 'id_jenis_tiket');
    }

    public function tiketPeserta()
    {
        return $this->hasMany(TiketPeserta::class, 'id_detail_pesanan');
    }
}
