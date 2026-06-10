<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';

    protected $fillable = [
        'tiket_id',
        'qr_scan_code',
        'status',
        'waktu_scan',
    ];

    protected function casts(): array
    {
        return [
            'waktu_scan' => 'datetime',
        ];
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }
}
