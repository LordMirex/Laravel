<?php

use Illuminate\Support\Facades\Route;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\ProductController;

Route::get('/', [App\Http\Controllers\Controller::class, 'showHome'])->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::prefix('blocks')->group(function () {
        Route::get('/manage', [BlockController::class, 'index'])->name('admin.blocks.index');
        Route::post('/', [BlockController::class, 'store'])->name('admin.blocks.store');
        Route::patch('/{block}', [BlockController::class, 'update'])->name('admin.blocks.update');
        Route::post('/reorder', [BlockController::class, 'reorder'])->name('admin.blocks.reorder');
        Route::delete('/{block}', [BlockController::class, 'destroy'])->name('admin.blocks.destroy');
    });

    Route::prefix('products')->group(function () {
        Route::get('/manage', [ProductController::class, 'index'])->name('admin.products.index');
        Route::post('/', [ProductController::class, 'store'])->name('admin.products.store');
        Route::patch('/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    });
});
