<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LedgerController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//ledger routes

Route::middleware(['auth'])->group(function () {
    Route::get('/ledger', [LedgerController::class, 'index'])->name('ledger.index');
    
    Route::post('/ledger/transaction', [LedgerController::class, 'storeTransaction'])->name('ledger.store');
    Route::get('/ledger/report/{account_id}', [LedgerController::class, 'report'])
        ->name('ledger.report')
        ->where('account_id', '[0-9]+');

//for api ledger report
    Route::get('/ledgers/report/{account_id}', [LedgerController::class, 'getReportJson']);
        
});







require __DIR__.'/auth.php';
