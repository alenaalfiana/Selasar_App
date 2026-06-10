<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;

Auth::routes();

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/events/{event}', [FrontendController::class, 'show'])->name('events.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('events.register');
    
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/registrations/{pendaftaran}/payment', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/registrations/{pendaftaran}/payment', [PaymentController::class, 'store'])->name('payments.store');
    
    Route::get('/tickets/{tiket}', [TicketController::class, 'show'])->name('tickets.show');

    Route::get('/notifications/mark-all-read', function() {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAsRead');

    Route::get('/notifications/{id}/read', function($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        $actionUrl = $notification->data['action_url'] ?? $notification->data['url'] ?? null;
        if (!$actionUrl && isset($notification->data['actions'][0]['url'])) {
            $actionUrl = $notification->data['actions'][0]['url'];
        }
        return redirect($actionUrl ?? route('dashboard'));
    })->name('notifications.read');
});
