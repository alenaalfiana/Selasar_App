<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';

    protected $fillable = [
        'kategori_id',
        'jenis_id',
        'judul',
        'deskripsi',
        'lokasi',
        'kapasitas',
        'harga',
        'tanggal_pelaksanaan',
        'tanggal_selesai',
        'foto_banner_event',
        'nama_rekening',
        'nama_rekening_bank',
        'no_rekening_pembayaran',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pelaksanaan' => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
