<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = ['id', 'id_pembeli', 'kode_pesanan','total_harga','status_pembayaran','metode_pembayaran','nama_pemesan','email_pemesan','no_telp_peserta'];

    public function detailPesanan(){
        
        return $this->hasMany(DetailPesanan::class,'id_pesanan');
    }
    

}
