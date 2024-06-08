<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Permission
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
     * Permission constructor.
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
     * @param array|string $permissions
     */
    public function handle(Request $request, Closure $next, $permissions): Response
    {
        if (!is_array($permissions)) {
            $permissions = explode(self::SEPARATOR, $permissions);
        }

        $userService = new UserService();

        if ($this->guard->guest() || !$userService->can($permissions)) {
            abort(403);
        }

        return $next($request);
    }
}
