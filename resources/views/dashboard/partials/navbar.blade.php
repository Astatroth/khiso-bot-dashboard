<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="fa-duotone fa-list"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            @if (count(LaravelLocalization::getSupportedLocales()) > 1)
                <!-- Language selector -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-bs-toggle="dropdown" href="#">
                        <span class="flag-icon flag-icon-{{ flag(app()->getLocale()) }}"></span> {{ LaravelLocalization::getCurrentLocaleNative() }}
                    </a>
                    <div id="language-switcher" class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        @foreach(LaravelLocalization::getLocalesOrder() as $localeCode => $properties)
                            @if ($localeCode !== app()->getLocale())
                                <div class="dropdown-item">
                                    <a rel="alternate" hreflang="{{ $localeCode }}"
                                       href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        <span class="flag-icon flag-icon-{{ $properties['flag'] ?? $localeCode }}"></span>&nbsp;{{ $properties['native'] }}
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0);" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="fa-duotone fa-maximize"></i>
                    <i data-lte-icon="minimize" class="fa-duotone fa-minimize" style="display: none;"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link">
                    <i class="fa-duotone fa-fw fa-sign-out"></i> {{ __('Sign out') }}
                </a>
            </li>
        </ul>
    </div>
</nav>
