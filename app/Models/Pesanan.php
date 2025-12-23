<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'id_pembeli',
        'id_acara',
        'nama_pemesan',
        'email_pemesan',
        'no_telp_pemesan',
        'metode_pembayaran',
        'bukti_pembayaran',
        'total_harga',
        'status',
        'status_pembayaran',
        'kode_pesanan',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function acara()
    {
        return $this->belongsTo(Acara::class, 'id_acara');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }
}
