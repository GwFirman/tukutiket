<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = ['nama_kategori', 'slug'];

    public function acara()
    {
        return $this->belongsToMany(Acara::class, 'event_kategori', 'id_kategori', 'id_acara');
    }
}
