<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifikasiKreator extends Model
{
    protected $table = 'verifikasi_kreator';

    protected $fillable = [
        'id_kreator',
        'foto_ktp',
        'foto_npwp',
        'status',
        'catatan_admin',
    ];

    public function kreator()
    {
        return $this->belongsTo(Kreator::class, 'id_kreator');
    }
}
