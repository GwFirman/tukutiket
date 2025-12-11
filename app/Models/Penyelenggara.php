<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyelenggara extends Model
{
    protected $table = 'penyelenggara';

    protected $fillable = [
        'id_user',
        'nama_penyelenggara',
        'slug',
        'deskripsi',
        'logo',
        'kontak',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function acara()
    {
        return $this->hasMany(Acara::class, 'id_penyelenggara');
    }
}
