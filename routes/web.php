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

    Route::prefix('members')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\MemberController::class, 'index'])->name('admin.members.index');
        Route::post('/', [\App\Http\Controllers\Admin\MemberController::class, 'store'])->name('admin.members.store');
    });

    Route::prefix('ministries')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\MinistryController::class, 'index'])->name('admin.ministries.index');
        Route::post('/', [\App\Http\Controllers\Admin\MinistryController::class, 'store'])->name('admin.ministries.store');
        Route::delete('/{ministry}', [\App\Http\Controllers\Admin\MinistryController::class, 'destroy'])->name('admin.ministries.destroy');
    });
});
