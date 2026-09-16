<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudent
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user()?->isStudent(), 403, 'Halaman ini khusus siswa.');

        return $next($request);
    }
}
