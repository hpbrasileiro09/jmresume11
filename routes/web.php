<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ParamController;
use App\Http\Controllers\DashBoardController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

use App\Models\Param;
use App\Models\Entry;
use App\Models\Category;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashBoardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	Route::get('/entry/support', [EntryController::class, 'support'])->name('entry.support');
	Route::post('/entry/supportsave', [EntryController::class, 'supportsave'])->name('entry.supportsave');
    Route::resource('entry', EntryController::class);
    Route::get('/lastcat', [EntryController::class, 'lastcat'])->name('entry.lastcat');
    Route::resource('/time', TimeController::class,['except' => ['create','destroy']]);
    Route::resource('/param', ParamController::class,['except' => ['create','destroy','show']]);
	Route::get('/param/generate', [ParamController::class, 'generate'])->name('param.generate');
	Route::get('/reports/detalhe', [ReportController::class, 'detalhe'])->name('reports.detalhe');
	Route::get('/reports/lupa', [ReportController::class, 'lupa'])->name('reports.lupa');
    Route::get('/entries_csv', [EntryController::class, 'entries_csv'])->name('entry.csv');
    Route::get('/all_entries_csv', [EntryController::class, 'all_entries_csv'])->name('allentry.csv');
    Route::get('/categories_arr', [EntryController::class, 'categories_arr'])->name('category.arr');
    Route::get('/all_categories_csv', [EntryController::class, 'all_categories_csv'])->name('allcategory.csv');
});

require __DIR__.'/auth.php';
