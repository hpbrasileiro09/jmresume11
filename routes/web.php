<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\ReportController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

use App\Models\Param;
use App\Models\Entry;
use App\Models\Category;

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
	Route::get('/entry/support', [EntryController::class, 'support'])->name('entry.support');
	Route::post('/entry/supportsave', [EntryController::class, 'supportsave'])->name('entry.supportsave');
    Route::resource('entry', EntryController::class);
    Route::get('/lastcat', [EntryController::class, 'lastcat'])->name('entry.lastcat');
    Route::resource('/time', TimeController::class,['except' => ['create','destroy']]);
	Route::get('/reports/detalhe', [ReportController::class, 'detalhe'])->name('reports.detalhe');
	Route::get('/reports/lupa', [ReportController::class, 'lupa'])->name('reports.lupa');
    Route::get('/entries_csv', [EntryController::class, 'entries_csv'])->name('entry.csv');
    Route::get('/all_entries_csv', [EntryController::class, 'all_entries_csv'])->name('allentry.csv');
    Route::get('/categories_arr', [EntryController::class, 'categories_arr'])->name('category.arr');
    Route::get('/all_categories_csv', [EntryController::class, 'all_categories_csv'])->name('allcategory.csv');
});

Route::get('/teste', function () {
    /*
    $param = new Param();
    $param->create([
		'label' => 'agora',
		'value' => '2024-06-20 00:00:00',
		'default' => '2024-06-20 00:00:00',
		'dt_params' => '2024-06-20 00:00:00',
		'type' => 'datetime',        
    ]);
    $cat = new Category();
    $cat->create([
        'name' => 'Debito',
        'published' => 1,
        'vl_prev' => 0.0,
        'day_prev' => 0,
        'ordem' => 0,
        'type' => '',    
    ]);
    $cat->create([
        'name' => 'Credito',
        'published' => 1,
        'vl_prev' => 0.0,
        'day_prev' => 0,
        'ordem' => 0,
        'type' => '',    
    ]);
    $entry = new Entry();
    $entry->create([
        'id_category' => 2,
        'dt_entry' => '2024-07-05 00:00:00',
        'vl_entry' => 5000.01,
        'nm_entry' => '',
        'ds_category' => 'Salário SL',
        'ds_subcategory' => '',
        'status' => 1,
        'fixed_costs' => 0,
        'checked' => 0,
        'published' => 1,
        'ds_detail' => '',    
    ]);
    */
    return Response::json(['data' => 'data'], 200);
});

require __DIR__.'/auth.php';
