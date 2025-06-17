<?php
// Add to the $middleware property in app/Http/Kernel.php
protected $middleware = [
    // ...existing middleware
    \App\Http\Middleware\SecureHeaders::class,
];

function ensureHttps($url) {
    return str_replace('http://', 'https://', $url);
}
