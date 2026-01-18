<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Installer\InstallerController;
use App\Models\Task;
use Illuminate\Http\Request;

Route::get('/', [App\Http\Controllers\Controller::class, 'showHome'])->name('home');

Route::post('/tasks', function (Request $request) {
    Task::create($request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ]));
    return back();
});

Route::patch('/tasks/{task}/toggle', function (Task $task) {
    $task->update(['completed' => !$task->completed]);
    return back();
});

Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();
    return back();
});

Route::prefix('install')->group(function () {
    Route::get('/', [InstallerController::class, 'welcome'])->name('installer.welcome');
    Route::get('/preflight', [InstallerController::class, 'preflight'])->name('installer.preflight');
    Route::get('/database', [InstallerController::class, 'databaseForm'])->name('installer.database');
    Route::post('/database/test', [InstallerController::class, 'testDatabase'])->name('installer.database.test');
    Route::get('/migrate', [InstallerController::class, 'migrationForm'])->name('installer.migrate');
    Route::post('/migrate/run', [InstallerController::class, 'runMigrations'])->name('installer.migrate.run');
    Route::get('/admin', [InstallerController::class, 'adminForm'])->name('installer.admin');
    Route::post('/admin/create', [InstallerController::class, 'createAdmin'])->name('installer.admin.create');
    Route::get('/identity', [InstallerController::class, 'identityForm'])->name('installer.identity');
    Route::post('/finish', [InstallerController::class, 'finish'])->name('installer.finish');
});

use App\Http\Controllers\Admin\BlockController;

use App\Http\Controllers\Admin\ProductController;

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::prefix('blocks')->group(function () {
        Route::get('/', [BlockController::class, 'index'])->name('admin.blocks.index');
        Route::post('/', [BlockController::class, 'store'])->name('admin.blocks.store');
        Route::patch('/{block}', [BlockController::class, 'update'])->name('admin.blocks.update');
        Route::post('/reorder', [BlockController::class, 'reorder'])->name('admin.blocks.reorder');
        Route::delete('/{block}', [BlockController::class, 'destroy'])->name('admin.blocks.destroy');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
        Route::post('/', [ProductController::class, 'store'])->name('admin.products.store');
        Route::patch('/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    });
});
