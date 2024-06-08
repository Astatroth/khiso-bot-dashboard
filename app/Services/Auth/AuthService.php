<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\SignInRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

class AuthService
{
    use AuthenticatesUsers;

    /**
     * Attempts to log the user into the application.
     *
     * @param SignInRequest $request
     * @return bool
     */
    protected function attemptLogin(SignInRequest $request): bool
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return bool
     */
    protected function authenticated(SignInRequest $request, $user): bool
    {
        return $request->expectsJson();
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param SignInRequest $request
     * @return array
     */
    protected function credentials(SignInRequest $request): array
    {
        return $request->only('email', 'phone', 'password');
    }

    /**
     * @param SignInRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(SignInRequest $request)
    {
        if (
            method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Sign the user out.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(\Illuminate\Http\Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(SignInRequest $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * @param SignInRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse(SignInRequest $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $request->intended;
    }
}
