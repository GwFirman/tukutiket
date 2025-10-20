<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTiket extends Model
{
    protected $table  = 'jenis_tiket';

    public function Acara() {
        return $this->belongsTo(Acara::class,'id_acara');
    }

    
}
