<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureJsonHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accept = $request->header('Accept');
        $contentType = $request->header('Content-Type');

        $valid = fn ($value) => str_contains($value, 'application/json');

        if (! $valid($accept) || ! $valid($contentType)) {
            return response()->json([
                'message' => 'Bad Request: Missing or invalid JSON headers.'
            ], 400);
        }

        return $next($request);
    }
}
