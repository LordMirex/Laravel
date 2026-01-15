<?php

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

// Middleware to check if the application is installed would go here.
// For scaffolding, we simulate this logic.

// Determine installation state (mock logic for now, in production check DB or .env)
$isInstalled = env('APP_INSTALLED', false);

if (!$isInstalled) {
    // === INSTALLER MODE ===
    // These routes handle the setup wizard.
    Route::get('/', function () {
        return '
            <h1>Laravel Installer</h1>
            <p>Welcome to the setup wizard.</p>
            <p>Status: Not Installed</p>
            <p>TODO: Wizard to write .env, run migrations, create admin.</p>
            <p>To simulate installed state, set APP_INSTALLED=true in .env</p>
        ';
    })->name('installer.welcome');

    Route::get('/install/step1', function () {
        return 'Installer Step 1';
    })->name('installer.step1');
} else {
    // === INSTALLED APPLICATION MODE ===
    
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    // === ADMIN ONLY AREA ===
    // Protected by 'auth' middleware in production
    Route::prefix('admin')->group(function () {
        Route::get('/', function () {
            return '<h1>Admin Dashboard</h1><p>Restricted access.</p>';
        })->name('admin.dashboard');
        
        // Settings, User Management, etc.
        Route::get('/settings', function () {
            return 'Admin Settings';
        });
    });
}
