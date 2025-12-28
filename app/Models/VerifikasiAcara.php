<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifikasiAcara extends Model
{
    protected $table = 'verifikasi_acara';

    protected $fillable = [
        'id_acara',
        'jenis_dokumen',
        'nama_dokumen',
        'file_path',
        'status_verifikasi',
        'catatan_admin',
        'diverifikasi_oleh',
        'diverifikasi_pada',
    ];

    protected $casts = [
        'diverifikasi_pada' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship with Acara model
     */
    public function acara()
    {
        return $this->belongsTo(Acara::class, 'id_acara');
    }

    /**
     * Relationship with Admin/User who verified
     */
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}
