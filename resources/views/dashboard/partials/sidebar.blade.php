<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('admin.home') }}" class="brand-link">
            <img src="{{ asset('img/AdminLTELogo.png') }}" alt="{{ config('app.name') }}"
                 class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">{{ config('app.name') }}</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <x-dashboard-menu.single-item :route="route('admin.home')" :iconClass="'fa-dashboard'"
                                              :iconStyle="'fa-solid'" :routes="'admin.home'">
                    {{ __('Dashboard') }}
                </x-dashboard-menu.single-item>

                @permission(['manage_settings', 'manage_content'])
                <x-dashboard-menu.header>
                    Telegram
                </x-dashboard-menu.header>
                @permission(['manage_settings'])
                <x-dashboard-menu.single-item :route="route('admin.channels.list')" :iconClass="'fa-telegram'"
                                              :iconStyle="'fa-brands'"
                                              :routes="'admin.channels.list'">
                    {{ __('Channels') }}
                </x-dashboard-menu.single-item>
                @endpermission
                @permission(['manage_content'])
                <x-dashboard-menu.single-item :route="route('admin.news.list')" :iconClass="'fa-newspaper'"
                                              :iconStyle="'fa-duotone'"
                                              :routes="'admin.news.list'">
                    {{ __('News') }}
                </x-dashboard-menu.single-item>
                @endpermission
                @endpermission

                <!-- Settings -->
                @permission(['manage_translations', 'use_file_manager', 'use_artisan_gui', 'manage_locations', 'manage_settings'])
                <x-dashboard-menu.header>
                    {{ __('Settings') }}
                </x-dashboard-menu.header>
                @permission(['manage_translations'])
                <x-dashboard-menu.single-item :route="route('admin.translation.show')" :iconClass="'fa-language'"
                                              :iconStyle="'fa-duotone'"
                                              :routes="'admin.translation.show'">
                    {{ __('Translations') }}
                </x-dashboard-menu.single-item>
                @endpermission

                @permission(['use_file_manager'])
                <x-dashboard-menu.single-item :route="route('unisharp.lfm.show')" :iconClass="'fa-image'"
                                              :iconStyle="'fa-duotone'" :routes="'unisharp.lfm.show'">
                    {{ __('File manager') }}
                </x-dashboard-menu.single-item>
                @endpermission
                @permission(['use_artisan_gui'])
                <x-dashboard-menu.single-item :route="route('admin.artisan.show')" :iconClass="'fa-square-terminal'"
                                              :iconStyle="'fa-duotone'" :routes="'admin.artisan.show'">
                    {{ __('Artisan') }}
                </x-dashboard-menu.single-item>
                @endpermission
                @endpermission
            </ul>
        </nav>
    </div>
</aside>
