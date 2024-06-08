<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class VerifyAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->tokenMatch($request)) {
            return $next($request);
        }

        throw new UnauthorizedException();
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function tokenMatch(Request $request): bool
    {
        $token = $request->bearerToken();

        return $token === config('api.access_token');
    }
}
