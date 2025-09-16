<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Facades\Math;

Route::get('/', function () {
    return view('welcome');
})->name('home');

    Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
  

    Route::get('/chat', [ChatController::class, 'chat'])->name('chat');
    Route::get('/users', [ChatController::class, 'index']);


});


Route::get('/orders', [OrderController::class, 'index']);
Route::get('/payment', [ChatController::class, 'makePayment']);
Route::get('/math', [ChatController::class, 'calculate']);


require __DIR__.'/auth.php';

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/ask', [App\Http\Controllers\ChatController::class, 'ask'])->name('ask');



Route::get('/pay', [PaymentController::class, 'showForm']);
Route::post('/pay', [PaymentController::class, 'pay'])->name('pay');
Route::post('/success', [PaymentController::class, 'success'])->name('success');
Route::post('/fail', [PaymentController::class, 'fail'])->name('fail');
Route::post('/cancel', [PaymentController::class, 'cancel'])->name('cancel');

