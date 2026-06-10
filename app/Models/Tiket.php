<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = 'tiket';

    protected $fillable = [
        'pembayaran_id',
        'kode_tiket',
        'qr_path',
    ];

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }

    public function presensi()
    {
        return $this->hasOne(Presensi::class);
    }
}
