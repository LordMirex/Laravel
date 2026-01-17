<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Services\InstallationService;

class InstallerController extends Controller
{
    protected $installationService;

    public function __construct(InstallationService $installationService)
    {
        $this->installationService = $installationService;
    }

    public function welcome()
    {
        return view('installer.welcome');
    }

    public function preflight()
    {
        $checks = [
            'php_version' => version_compare(PHP_VERSION, '8.2.0', '>='),
            'pdo' => extension_loaded('pdo_mysql'),
            'mbstring' => extension_loaded('mbstring'),
            'openssl' => extension_loaded('openssl'),
            'tokenizer' => extension_loaded('tokenizer'),
            'xml' => extension_loaded('xml'),
            'ctype' => extension_loaded('ctype'),
            'json' => extension_loaded('json'),
            'bcmath' => extension_loaded('bcmath'),
            'storage_writable' => is_writable(storage_path()),
            'cache_writable' => is_writable(bootstrap_path('cache')),
        ];

        return view('installer.preflight', compact('checks'));
    }

    public function databaseForm()
    {
        return view('installer.database');
    }

    public function testDatabase(Request $request)
    {
        $request->validate([
            'host' => 'required',
            'port' => 'required',
            'database' => 'required',
            'username' => 'required',
        ]);

        try {
            config(['database.connections.mysql_test' => [
                'driver' => 'mysql',
                'host' => $request->host,
                'port' => $request->port,
                'database' => $request->database,
                'username' => $request->username,
                'password' => $request->password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ]]);

            DB::connection('mysql_test')->getPdo();
            
            // In a real app, we would write these to .env here.
            // For now, we assume they are already set in .env as per instructions.
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function migrationForm()
    {
        return view('installer.migrate');
    }

    public function runMigrations()
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            return response()->json(['success' => true, 'output' => \Illuminate\Support\Facades\Artisan::output()]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
