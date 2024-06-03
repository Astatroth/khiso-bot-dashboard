<!DOCTYPE html>
<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">

    <base href="{{ config('app.url') }}">

    <title>{{ (isset($title) ? $title : config('app.name')).' | '.config('app.name') }}</title>

    <!-- SEO -->
    @include('partials.seo')

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="{{ vendor('bootstrap-5.3.2/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ vendor('font-awesome-6-pro/css/all.min.css') }}">
    <!-- FlagIconCss -->
    <link rel="stylesheet" href="{{ vendor('flag-icon-css/css/flag-icon.min.css') }}">

    <!-- Main styles -->
    @vite(['resources/css/app.scss'])

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')

    <link rel="stylesheet" href="{{ asset('css/override.css') }}">
</head>
<body>
<header>
    <div class="container">
        <div class="navbar-main">
            <div class="logo-content">
                <div class="logo-card">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo.svg') }}" alt="{{ config('app.title') }}">
                    </a>
                </div>
                <div class="logo-content-txt">
                    <p>{{ __('WICS') }}</p>
                </div>
            </div>
            <div class="navbar-right-content">
                <div>
                    <button type="button"  class="header-button btn"
                             data-bs-toggle="modal"
                             data-bs-target="#application-modal">
                        {{ __('Apply now') }}
                    </button>
                </div>

                <div class="dropdown-content">
                    <div class="select-item">
                        <span class="selected">{{Str::upper(LaravelLocalization::getCurrentLocale()) }}</span>
                        <div class="caret"></div>
                    </div>
                    <ul class="dropdown-menu">
                        @foreach (LaravelLocalization::getLocalesOrder() as $localeCode => $properties)
                            <li @class(['active' => $localeCode === app()->getLocale()])>
                                <a rel="alternate"
                                   hreflang="{{ $localeCode }}"
                                   class="language-links"
                                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                </a>
                                    {{ \Str::upper($localeCode) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="burger-menu">
        <div class="bar">
            <span class="bar-1"> </span>
            <span class="bar-2"> </span>
            <span class="bar-3"> </span>
        </div>
    </div>
    <div class="navbar-buttons">
        <a class="navbar-btn" href="{{ route('about') }}">{{ __('About us') }}</a>
        <a class="navbar-btn" href="{{ route('news') }}">{{ __('News') }}</a>
        <a class="navbar-btn" href="{{ route('restaurant.country.list') }}">{{ __('Restaurants') }}</a>
        <a class="navbar-btn" href="#company-logos-section">{{ __('Manufacturers') }}</a>
        <a class="navbar-btn" href="#strange-cards-section">{{ __('Chefs') }}</a>
        <a class="navbar-btn" href="#country-flags-section">{{ __('Representatives') }}</a>
        <a class="navbar-btn" href="#section-partners">{{ __('Partners') }}</a>
        <a class="navbar-btn" href="{{ route('guide') }}">{{ __('Halal guide') }}</a>
    </div>
</header>

@yield('content')

<div class="modal" id="application-modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="popup-input-content-main">
                    <div class="popup-txt-content">
                        <p class="popup-title">{{ __('Submit your application') }}:
                        </p>
                        <p class="popup-txt">
                            {{ __('In this section, you can leave a request, our staff will contact you, advise you, answer your questions and help you in obtaining the Halal Certificate.') }}
                        </p>
                    </div>
                    <div class="popup-input-wrapper">
                        <x-form.form :action="route('application.submit')">
                            <div class="popup-inner">
                                <input class="popup-input" type="text" name="name" placeholder="{{ __('Name') }} *" data-recaptcha-id>
                                <input class="popup-input" type="text" name="last_name" placeholder="{{ __('Lat name') }} *" data-recaptcha-id>
                            </div>
                            <div>
                                <input class="popup-input big-input" type="text" name="brand" placeholder="{{ __('Brand name') }} *" data-recaptcha-id>

                                <p class="select-title">
                                    {{ __('Select ype of activity ') }} <span class="text-danger">*</span>
                                </p>

                                <select class="popup-select form-select form-select-lg" name="activity" aria-label="Type of activity" data-recaptcha-id>
                                    <option value="1">
                                        {{ __('Food production') }}
                                    </option>
                                    <option value="2">
                                        {{ __('Catering establishment (restaurant, cafe, etc.)') }}
                                    </option>
                                    <option value="3">
                                        {{ __('Hotel (hostel, motel, etc.)') }}
                                    </option>
                                </select>
                                <div class="popup-inner popup-inner-secondary">
                                    <input class="popup-input" type="text" name="phone" placeholder="{{ __('Phone number') }} *" data-recaptcha-id>
                                    <input class="popup-input" type="email" name="email" placeholder="E-mail *" data-recaptcha-id>
                                </div>
                                <button class="submit-btn" type="submit">
                                    {{ __('buttons.send') }}
                                </button>
                            </div>
                        </x-form.form>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

@stack('modals')

<footer>
    <div class="container">
        <div class="footer-content-main">

            <div class="footer-content-txt">
                {!! render_block('footer-block') !!}
            </div>

            <div class="footer-content-btns">
                <a class="footer-content-btn" href="{{ route('home') }}">{{ __('Home') }}</a>
                <a class="footer-content-btn" href="{{ route('about') }}">{{ __('About us') }}</a>
                <a class="footer-content-btn" href="{{ route('news') }}">{{ __('News') }}</a>
                <a class="footer-content-btn" href="{{ route('restaurant.country.list') }}">{{ __('Restaurants') }}</a>
                <a class="footer-content-btn" href="{{ route('chef.country.list') }}">{{ __('Chefs') }}</a>
                <a class="footer-content-btn" href="#section-partners">{{ __('Partners') }}</a>
                <a class="footer-content-btn" href="{{ route('guide') }}">{{ __('Halal guide') }}</a>
            </div>

            <div class="green-btn">
                <a class="green-btn-inner" href="{{ route('faq') }}">{{ __('FAQ') }}</a>
            </div>

        </div>
        <div class="the-end-of-footer">
            World Halal Committee &copy; {{ date('Y') > 2023 ? '2023-'.date('Y') : 2023 }}
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="{{ vendor('jquery/jquery-3.7.1.min.js') }}"></script>
<!-- Bootstrap 5 -->
<script src="{{ vendor('bootstrap-5.3.2/js/bootstrap.bundle.min.js') }}"></script>

@vite(['resources/js/app.js'])

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

<script>
    $(function () {
        $(".burger-menu").on("click", ".bar", function() {
            $(".navbar-buttons").slideToggle();
            $(".bar").toggleClass('change');
            $(".navbar-buttons a").slideRight();
        });

        const dropdown = document.querySelector(".dropdown-content");
        const select = dropdown.querySelector(".select-item");
        const caret = dropdown.querySelector(".caret");
        const menu = dropdown.querySelector(".dropdown-menu");
        const options = dropdown.querySelectorAll(".dropdown-menu li");
        const selected = dropdown.querySelector(".selected");
        select.addEventListener("click", () => {
            select.classList.toggle("select-clicked");
            caret.classList.toggle("caret-rotate");
            menu.classList.toggle("menu-open")
        })
        options.forEach(option => {
            option.addEventListener("click", () => {
                selected.innerText = option.innerText;
                select.classList.remove("select-clicked");
                caret.classList.remove("caret-rotate");
                menu.classList.remove("menu-open");
                options.forEach(option => {
                    option.classList.remove("active")
                })
                option.classList.add("active")
            })
        })
    });
</script>

@stack('scripts')

@if ($errors->any() && !isset($noToastr))
    <script>
        $(function () {
            @foreach ($errors->all() as $_error)
            toastr.error('{{  $_error }}');
            @endforeach
        });
    </script>
@endif

@if (isset($messages) && $messages->count())
    <script>
        $(function () {
            @foreach ($messages as $message)
            toastr.{{ $message['style'] }}('{{  $message['message'] }}');
            @endforeach
        });
    </script>
@endif

</body>
</html>
