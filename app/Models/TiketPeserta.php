<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketPeserta extends Model
{
    use HasFactory;

    protected $table = 'tiket_peserta';

    protected $fillable = [
        'id_detail_pesanan',
        'kode_tiket',
        'nama_peserta',
        'email_peserta',
        'no_telp_peserta',
        'status_checkin',
        'waktu_checkin',
    ];

    public function detailPesanan()
    {
        return $this->belongsTo(DetailPesanan::class, 'id_detail_pesanan');
    }
}
