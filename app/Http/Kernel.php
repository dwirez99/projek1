<?php
// Add to the $middleware property in app/Http/Kernel.php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // ...existing middleware
        \App\Http\Middleware\SecureHeaders::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            // ... existing middleware
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    public function ensureHttps($url) {
        return str_replace('http://', 'https://', $url);
    }
}
