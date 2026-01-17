<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Services\InstallationService;

use Illuminate\Support\Facades\Artisan;
use App\Models\SiteSetting;
use App\Models\User;

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
            // Using MySQL as requested (Railway)
            config(['database.connections.mysql_test' => [
                'driver' => 'mysql',
                'host' => $request->host,
                'port' => $request->port,
                'database' => $request->database,
                'username' => $request->username,
                'password' => $request->password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'strict' => true,
                'engine' => null,
            ]]);

            DB::connection('mysql_test')->getPdo();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function migrationForm()
    {
        return view('installer.migrate');
    }

    public function adminForm()
    {
        return view('installer.admin');
    }

    public function createAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect()->route('installer.identity');
    }

    public function identityForm()
    {
        return view('installer.identity');
    }

    public function finish(Request $request)
    {
        $request->validate([
            'site_title' => 'required|string|max:255',
            'whatsapp_number' => 'required|string',
            'category' => 'required|string',
        ]);

        SiteSetting::updateOrCreate(['id' => 1], [
            'site_title' => $request->site_title,
            'whatsapp_number' => $request->whatsapp_number,
            'category' => $request->category,
            'features' => [
                'store' => true,
                'newsletter' => true,
                'events' => true,
            ],
        ]);

        File::put(storage_path('installed.lock'), json_encode([
            'installed_at' => now()->toDateTimeString(),
        ]));

        return response()->json(['success' => true]);
    }

    public function runMigrations()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            return response()->json(['success' => true, 'output' => Artisan::output()]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
