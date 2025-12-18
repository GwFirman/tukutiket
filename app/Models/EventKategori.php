<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventKategori extends Model
{
    protected $table = 'event_kategori';

    protected $fillable = ['id_acara', 'id_kategori'];

    public function acara()
    {
        return $this->belongsTo(Acara::class, 'id_acara');
    }

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'id_kategori');
    }
}
