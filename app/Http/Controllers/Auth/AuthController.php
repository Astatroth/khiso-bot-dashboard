<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInRequest;
use App\Providers\RouteServiceProvider;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * AuthController constructor.
     *
     * @param AuthService $service
     */
    public function __construct(protected AuthService $service)
    {
        //
    }

    /**
     * @param SignInRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(SignInRequest $request)
    {
        $result = $this->service->login($request);

        if ($result === route('login')) {
            return redirect()->route(RouteServiceProvider::HOME);
        }

        return redirect()->to($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        return $this->service->logout($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        $this->title(__('Sign in'));

        $this->view('auth.login');

        return $this->render([
            'intended' => request()->back_url
        ]);
    }
}
