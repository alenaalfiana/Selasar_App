<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Illuminate\Support\Str;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'pendaftaran_id',
        'foto_bukti_pembayaran',
        'status',
        'waktu_bayar',
    ];

    protected function casts(): array
    {
        return [
            'waktu_bayar' => 'datetime',
        ];
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function tiket()
    {
        return $this->hasOne(Tiket::class);
    }

    protected static function booted()
    {
        static::updated(function ($pembayaran) {
            if ($pembayaran->isDirty('status') && $pembayaran->status === 'valid') {
                $tiket = $pembayaran->tiket;
                if (!$tiket) {
                    $kode = strtoupper(\Illuminate\Support\Str::random(10));
                    $tiket = \App\Models\Tiket::create([
                        'pembayaran_id' => $pembayaran->id,
                        'kode_tiket' => $kode,
                        'qr_path' => $kode,
                    ]);
                }

                $user = $pembayaran->pendaftaran->user;
                \Filament\Notifications\Notification::make()
                    ->title('Pembayaran telah diterima! Klik untuk mengambil tiket.')
                    ->actions([
                        Action::make('ambil_tiket')
                            ->label('Ambil Tiket')
                            ->url('/tickets/' . $tiket->id)
                    ])
                    ->sendToDatabase($user);
            } elseif ($pembayaran->isDirty('status') && $pembayaran->status === 'ditolak') {
                $user = $pembayaran->pendaftaran->user;
                \Filament\Notifications\Notification::make()
                    ->title('Pembayaran ditolak. Silakan upload bukti pembayaran baru.')
                    ->sendToDatabase($user);
            }
        });
    }
}
