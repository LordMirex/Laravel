<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Installer\InstallerController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::prefix('install')->group(function () {
    Route::get('/', [InstallerController::class, 'welcome'])->name('installer.welcome');
    Route::get('/preflight', [InstallerController::class, 'preflight'])->name('installer.preflight');
    Route::get('/database', [InstallerController::class, 'databaseForm'])->name('installer.database');
    Route::post('/database/test', [InstallerController::class, 'testDatabase'])->name('installer.database.test');
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return 'Admin Dashboard';
    });
});
