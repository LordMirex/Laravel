<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isInstallerRequest = $request->is('install*');

        // Rule 1: storage/installed.lock exists
        $isInstalled = file_exists(storage_path('installed.lock'));

        // Rule 2: APP_INSTALLED env (optional fallback)
        if (!$isInstalled && config('app.installed')) {
            $isInstalled = true;
        }

        if (!$isInstalled && !$isInstallerRequest) {
            return redirect()->route('installer.welcome');
        }

        if ($isInstalled && $isInstallerRequest) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
