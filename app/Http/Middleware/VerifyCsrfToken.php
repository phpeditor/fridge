<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/api/v3/book_blocks',
        '/api/v3/locations',
        '/api/v3/my_bookings',
        '/api/v3/{location-id}/calculate'
    ];
}
