<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * String separator.
     */
    const SEPARATOR = '|';

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * Role constructor.
     *
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param array|string $roles
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if (!is_array($roles)) {
            $roles = explode(self::SEPARATOR, $roles);
        }

        $userService = new UserService();

        if ($this->guard->guest() || !$userService->hasRoles($roles)) {
            abort(403);
        }

        return $next($request);
    }
}
