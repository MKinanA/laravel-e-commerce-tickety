<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/details/{slug}', [EventController::class, 'index'])->name('detail');
Route::get('/details', [EventController::class, 'toHome'])->name('detail-no-slug');

Route::post('/checkout/event/{slug}', [EventController::class, 'checkout'])->name('checkout');
Route::get('/checkout/event/{slug}', [EventController::class, 'toEventPage'])->name('checkout-get');
Route::get('/checkout', [EventController::class, 'toHome'])->name('checkout-get-no-slug');

Route::post('/checkout/pay', [EventController::class, 'checkoutPay'])->name('checkout-pay');
Route::get('/checkout/pay', [EventController::class, 'toHome'])->name('checkout-pay-get');

Route::get('/checkout-success', [EventController::class, 'checkoutSuccess'])->name('checkout-success');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('events', AdminEventController::class);
        Route::resource('events.tickets', AdminTicketController::class);
        Route::get('pdf/{event}/{transaction}', [AdminTransactionController::class, 'pdf'])->name('pdf');
        Route::get('approve/{event}/{transaction}', [AdminTransactionController::class, 'approve'])->name('approve');
        Route::resource('events.transactions', AdminTransactionController::class);
        Route::get('events/{event}/scan', [AdminEventController::class, 'scan'])->name('events.scan');
        Route::get('qr/{code}', [AdminTransactionController::class, 'qr'])->name('qr');
    });
});
