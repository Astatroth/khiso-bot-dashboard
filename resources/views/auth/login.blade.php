@extends('layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="javascript:void(0);">
                {{ config('app.name') }}
            </a>
        </div>
        <x-card.card>
            <x-slot:body>
                <x-form.form :action="route('login.submit')" method="post">
                    <input type="hidden" name="intended" value="{{ old('intended') ?: $intended }}">

                    <div class="invisible-recaptcha"></div>

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="E-mail"
                               value="{{ old('email') }}" data-recaptcha-id>
                        <div class="input-group-text">
                            <span class="fa fa-envelope"></span>
                        </div>
                    </div>

                    <div class="">
                        <h5 class="hl text-center">
                            <span class="text-uppercase">{{ __('common.or') }}</span>
                        </h5>
                    </div>

                    <x-intl-phone-number class="input-group mb-3" :name="'phone_number'">
                        <div class="input-group-text input-group-text-append">
                            <span class="fa fa-phone"></span>
                        </div>
                    </x-intl-phone-number>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password"
                               data-recaptcha-id>
                        <div class="input-group-text">
                            <span class="fa fa-lock"></span>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-8">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="remember" role="switch"
                                       id="remember" value="1">
                                <label class="form-check-label" for="remember">{{ __('Remember me') }}</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Log in') }}</button>
                        </div>
                    </div>
                </x-form.form>
                <!-- TODO: password recovery & sign up -->
            </x-slot:body>
        </x-card.card>
    </div>
@endsection
