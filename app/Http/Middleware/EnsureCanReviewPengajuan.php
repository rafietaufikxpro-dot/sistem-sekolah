<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCanReviewPengajuan
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || (! $user->isAdmin() && ! $user->isGuru())) {
            abort(403, 'Akses ditolak. Hanya admin atau guru yang memiliki izin untuk memproses pengajuan administrasi.');
        }

        return $next($request);
    }
}
