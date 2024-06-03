<!DOCTYPE html>
<html class="auth-login" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ($title ?? config('app.name')).' | '.config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ vendor('font-awesome-6-pro/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ vendor('adminlte/css/adminlte.min.css') }}">

    @vite('resources/css/app.scss')

    @stack('styles')
</head>

<body class="login-page bg-body-secondary">

@yield('content')

@vite('resources/js/app.js')

<script src="{{ vendor('jquery/jquery-3.7.1.min.js') }}"></script>

@if ($errors->any() && !isset($noToastr))
    <script>
        $(function () {
            @foreach ($errors->all() as $_error)
            toastr.error('{{  $_error }}');
            @endforeach
        });
    </script>
@endif

@if (config('recaptcha.api_site_key'))
    <script>
        function renderReCaptcha() {
            for (let i = 0; i < document.forms.length; i++) {
                var form = document.forms[i];
                var holder = form.querySelector('.invisible-recaptcha');
                if (null === holder) {
                    continue;
                }

                (function(frm) {
                    var holderId = grecaptcha.render(holder, {
                        'sitekey': '{{ config('recaptcha.api_site_key') }}',
                        'badge': 'badge',
                        'size': 'invisible',
                        'callback': function (token) {
                            HTMLFormElement.prototype.submit.call(frm);
                        },
                        'expired-callback': function () {
                            grecaptcha.reset(holderId);
                        }
                    });

                    frm.onsubmit = function (event) {
                        event.preventDefault();
                        grecaptcha.execute(holderId);
                    }
                })(form);
            }
        }

        $('[data-recaptcha-id]').on('focus', function (event) {
            let head = document.getElementsByTagName('head')[0];
            let script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://www.google.com/recaptcha/api.js?onload=renderReCaptcha&render=explicit';
            head.appendChild(script);

            $('[data-recaptcha-id]').off('focus');
        });
    </script>
@endif

@stack('scripts')
</body>

</html>
