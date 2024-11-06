<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Logging\UltraLogService;

class UltraActivityLog
{
    protected $logService;

    public function __construct(UltraLogService $logService)
    {
        $this->logService = $logService;
    }

    public function handle(Request $request, Closure $next)
    {
        // Log dell'attività prima della richiesta
        $this->logService->logActivity(
            $request->user(),
            'access',
            $request->fullUrl(),
            $request->method()
        );

        $response = $next($request);

        // Log post-richiesta se necessario
        if ($response->getStatusCode() >= 400) {
            $this->logService->logActivity(
                $request->user(),
                'error',
                $request->fullUrl(),
                $response->getStatusCode()
            );
        }

        return $response;
    }
} 