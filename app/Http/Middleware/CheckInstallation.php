<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\InstallationService;
use Symfony\Component\HttpFoundation\Response;

class CheckInstallation
{
    protected $installationService;

    public function __construct(InstallationService $installationService)
    {
        $this->installationService = $installationService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isInstalled = $this->installationService->isInstalled();
        $isInstallPath = $request->is('install') || $request->is('install/*');

        if (!$isInstalled && !$isInstallPath) {
            return redirect()->route('installer.welcome');
        }

        if ($isInstalled && $isInstallPath) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
