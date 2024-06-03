<!DOCTYPE html>
<html class="dashboard" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ($title ?? config('app.name')).' | '.config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/AdminLTELogo.png') }}">

    <link rel="stylesheet" href="{{ vendor('font-awesome-6-pro/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ vendor('overlay-scrollbars-2.3.0/overlayscrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ vendor('flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ vendor('adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ vendor('fancybox-5.0/dist/fancybox/fancybox.css') }}">

    @stack('styles')

    @vite('resources/css/dashboard.scss')

    <script type="module">
        window.datatableCookieConfig = @json(config('dynamic-table.cookie'));
        window.supportedLocales = @json(\LaravelLocalization::getLocalesOrder());
        window.appUrl = '{{ config('app.url') }}';
        window.routeName = '{{ request()->route()->getName() }}';
        window.routeParams = @json(request()->route()->parameters());
    </script>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">
    @include('dashboard.partials.navbar')

    @include('dashboard.partials.sidebar')

    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        @isset($title)
                            <h3 class="mb-0">
                                {{ $title }}
                                @if (request()->route()->getName() !== 'admin.home')
                                    <x-shortcut-action :items="$shortcuts"/>
                                @endif
                            </h3>
                        @endisset
                    </div>
                    <!-- TODO: breadcrumbs -->
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </main>

    @include('dashboard.partials.footer')

    @stack('modals')
</div>
<script src="{{ vendor('overlay-scrollbars-2.3.0/overlayscrollbars.browser.es6.min.js') }}"></script>
<script src="{{ vendor('jquery/jquery-3.7.1.min.js') }}"></script>
<script src="{{ vendor('adminlte/js/adminlte.min.js') }}"></script>
<script src="{{ vendor('fancybox-5.0/dist/fancybox/fancybox.umd.js') }}"></script>

@vite(['resources/js/dashboard.js', 'resources/js/Vue/vue.js'])

@stack('scripts')

<script>
    const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
    const Default = {
        scrollbarTheme: "os-theme-light",
        scrollbarAutoHide: "leave",
        scrollbarClickScroll: true,
    };
    document.addEventListener("DOMContentLoaded", function() {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (
            sidebarWrapper &&
            typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
        ) {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: Default.scrollbarTheme,
                    autoHide: Default.scrollbarAutoHide,
                    clickScroll: Default.scrollbarClickScroll,
                },
            });
        }
    });

    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        Fancybox.bind('[data-fancybox]');

        var $currentViewContainers = $('.current-view--container');
        if ($currentViewContainers.length) {
            $('.current-view--container > button[data-image-remove]').click(function (e) {
                e.preventDefault();
                $(this).closest('.current-view').remove();

                toastr.info('{{ __('Image removed. Save the form to submit changes.') }}');
            });
        }

        var $shortcutActionIcon = $('.shortcut-action__icon');
        $shortcutActionIcon.on('click', function (event) {
            $.ajax({
                url: '{{ route('admin.shortcut.toggle') }}',
                method: 'POST',
                dataType: 'json',
                data: {
                    shortcutName: '{{ $title ?? __('Shortcut') }}',
                    routeName: window.routeName,
                    routeParams: window.routeParams
                },
                success: response => {
                    let message = '{{ __('Shortcut saved.') }}';
                    if (response.state === 1) {
                        $(this).addClass('text-warning');
                    } else {
                        message = '{{ __('Shortcut deleted.') }}';
                        $(this).removeClass('text-warning');
                    }

                    toastr.success(message);
                }
            });
        });

        var $shortcutButton = $('.dashboard-shortcut button');
        $shortcutButton.on('click', function (event) {
            $.ajax({
                url: '{{ route('admin.shortcut.remove') }}',
                method: 'POST',
                dataType: 'json',
                data: {
                    id: $(this).data('id')
                },
                success: response => {
                    $(this).parent('.dashboard-shortcut').remove();
                }
            });
        });
    });
</script>

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
