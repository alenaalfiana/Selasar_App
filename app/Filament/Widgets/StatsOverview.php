<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\Event;
use App\Models\Pendaftaran;
use App\Models\Presensi;
use App\Models\User;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalEvents = Event::count();
        
        $successfulRegistrations = Pendaftaran::whereDoesntHave('pembayaran', function ($query) {
            $query->where('status', 'ditolak');
        })->count();

        $totalHadir = Presensi::where('status', 'hadir')->count();
        $attendancePercentage = $successfulRegistrations > 0 ? round(($totalHadir / $successfulRegistrations) * 100) : 0;

        $activeUsers = User::where('role_as', 'user')->count();

        return [
            Stat::make('Total Event Diadakan', $totalEvents)
                ->description('Semua event yang terdaftar')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),
            Stat::make('Pendaftaran Berhasil', $successfulRegistrations)
                ->description('Peserta yang valid/gratis')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
            Stat::make('Persentase Kehadiran', $attendancePercentage . '%')
                ->description('Peserta hadir dari total pendaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
            Stat::make('User Aktif', $activeUsers)
                ->description('Pengguna aplikasi')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),
        ];
    }
}
