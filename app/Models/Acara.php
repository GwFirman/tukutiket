<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Acara extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'acara';

    protected $fillable = [
        'id_pembuat',
        'nama_acara',
        'slug',
        'deskripsi',
        'lokasi',
        'banner_acara',
        'banner_tiket',
        'waktu_mulai',
        'waktu_selesai',
        'no_telp_narahubung',
        'info_narahubung',
        'email_narahubung',
        'status',
        'maks_pembelian_per_akun',
        'maks_tiket_per_transaksi',
        'is_online',
        'venue',
        'latitude',
        'longitude',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nama_acara')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function jenisTiket()
    {
        return $this->hasMany(JenisTiket::class, 'id_acara');
    }

    public function penyelenggara()
    {
        return $this->belongsTo(Penyelenggara::class, 'id_penyelenggara');
    }

    public function kreator()
    {
        return $this->belongsTo(Kreator::class, 'id_kreator');
    }

    // Relasi kategori many-to-many melalui tabel pivot event_kategori
    public function kategori()
    {
        return $this->belongsToMany(kategori::class, 'event_kategori', 'id_acara', 'id_kategori');
    }

    public function eventKategori()
    {
        return $this->hasMany(EventKategori::class, 'id_acara');
    }
}
