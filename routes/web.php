<?php

use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');

Route::get('/testing', function () {
    return view('welcome');
})->name('testing');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', [DashboardController::class, 'index'])
//     ->middleware(['auth'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/checklist', [ChecklistController::class, 'index'])->name('checklist.index');
    Route::get('/checklist/create', [ChecklistController::class, 'create'])->name('checklist.create');
    Route::get('/checklist/{checklist}/edit', [ChecklistController::class, 'edit'])->name('checklist.edit');
    Route::put('/checklist/{checklist}', [ChecklistController::class, 'update'])->name('checklist.update');
    Route::post('/checklist', [ChecklistController::class, 'store'])->name('checklist.store');
    Route::get('/checklist/export', [ChecklistController::class, 'export'])->name('checklist.export');
    Route::delete('/checklists/{checklist}', [ChecklistController::class, 'destroy'])->name('checklist.destroy');
    Route::post('/checklist/submit-all', [ChecklistController::class, 'submitAll'])->name('checklist.submit.all');
    Route::post('/checklist/approve-all', [ChecklistController::class, 'approveAll'])->name('checklist.approve.all');
    Route::PUT('/checklist/{checklist}/revision', [ChecklistController::class, 'revision'])->name('checklist.revision');
});

Route::get('/reports', [ReportController::class, 'index'])->name('report.index')->middleware(['auth']);
Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export')->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
