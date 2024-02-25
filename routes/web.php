<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('test', fn () => phpinfo());

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/scan', [
        PageController::class, 'scan'
    ])->name('scan.index');

    Route::get('/bookings', [
        PageController::class, 'bookings'
    ])->name('bookings.index');

    Route::get('/schedules', [
        PageController::class, 'schedules'
    ])->name('schedules.index');

    Route::get('/{roomId}/bundy', [
        PageController::class, 'bundy'
    ])->name('room.clockIn');
});
