<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kreator extends Model
{
    protected $table = 'kreator';

    protected $fillable = [
        'id_user',
        'nama_kreator',
        'slug',
        'deskripsi',
        'kontak',
        'logo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
