<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CSVImportController; 

Route::get('/WarmtenetDashboard', function () {
    return view('WarmtenetDashboard');
})->name('WarmtenetDashboard'); 

Route::get('/Upload', function () {
    return view('Upload');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/Upload-csv', [CSVImportController::class, 'import'])->name('csv.import');
});

require __DIR__.'/auth.php';
