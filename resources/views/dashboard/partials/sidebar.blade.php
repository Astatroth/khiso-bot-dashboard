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

                @permission(['manage_content'])
                <!-- Structure -->
                <x-dashboard-menu.header>
                    {{ __('Structure') }}
                </x-dashboard-menu.header>
                <x-dashboard-menu.single-item :route="route('admin.structure.block.list')" :iconClass="'fa-cubes'"
                                              :iconStyle="'fa-solid'" :routes="'admin.structure.block.*'">
                    {{ __('Blocks') }}
                </x-dashboard-menu.single-item>

                <!-- Content -->
                <x-dashboard-menu.header>
                    {{ __('Content') }}
                </x-dashboard-menu.header>
                <x-dashboard-menu.single-item :route="route('admin.content.banner.list')" :iconClass="'fa-gallery-thumbnails'"
                                              :iconStyle="'fa-solid'" :routes="'admin.content.banner.*'">
                    {{ __('Banners') }}
                </x-dashboard-menu.single-item>
                <x-dashboard-menu.single-item :route="route('admin.content.restaurant.list')" :iconClass="'fa-utensils'"
                                              :iconStyle="'fa-solid'" :routes="'admin.content.restaurant.*'">
                    {{ __('Restaurants') }}
                </x-dashboard-menu.single-item>
                <x-dashboard-menu.single-item :route="route('admin.content.hotel.list')" :iconClass="'fa-bed-empty'"
                                              :iconStyle="'fa-solid'" :routes="'admin.content.hotel.*'">
                    {{ __('Hotels') }}
                </x-dashboard-menu.single-item>
                <x-dashboard-menu.single-item :route="route('admin.content.manufacturer.list')" :iconClass="'fa-industry'"
                                              :iconStyle="'fa-solid'" :routes="'admin.content.manufacturer.*'">
                    {{ __('Manufacturers') }}
                </x-dashboard-menu.single-item>
                <x-dashboard-menu.single-item :route="route('admin.content.chef.list')" :iconClass="'fa-user-chef'"
                                              :iconStyle="'fa-solid'" :routes="'admin.content.chef.*'">
                    {{ __('Chefs') }}
                </x-dashboard-menu.single-item>
                <x-dashboard-menu.single-item :route="route('admin.content.representative.list')" :iconClass="'fa-user-vneck-hair'"
                                              :iconStyle="'fa-solid'" :routes="'admin.content.representative.*'">
                    {{ __('Representatives') }}
                </x-dashboard-menu.single-item>
                <x-dashboard-menu.single-item :route="route('admin.content.partner.list')" :iconClass="'fa-handshake'"
                                              :iconStyle="'fa-solid'" :routes="'admin.content.partner.*'">
                    {{ __('Partners') }}
                </x-dashboard-menu.single-item>
                <x-dashboard-menu.single-item :route="route('admin.content.team.list')" :iconClass="'fa-people-group'"
                                              :iconStyle="'fa-solid'" :routes="'admin.content.team.*'">
                    {{ __('Team') }}
                </x-dashboard-menu.single-item>
                <x-dashboard-menu.single-item :route="route('admin.content.news.list')" :iconClass="'fa-newspaper'"
                                              :iconStyle="'fa-solid'" :routes="'admin.content.news.*'">
                    {{ __('News') }}
                </x-dashboard-menu.single-item>
                <x-dashboard-menu.single-item :route="route('admin.content.faq.list')" :iconClass="'fa-question'"
                                              :iconStyle="'fa-solid'" :routes="'admin.content.faq.*'">
                    {{ __('FAQ') }}
                </x-dashboard-menu.single-item>
                @endpermission

                <!-- Misc -->
                <x-dashboard-menu.header>
                    {{ __('Misc') }}
                </x-dashboard-menu.header>
                <x-dashboard-menu.single-item :route="route('admin.application.list')" :iconClass="'fa-envelope'"
                                              :iconStyle="'fa-solid'" :routes="'admin.application.*'">
                    {{ __('Applications') }}
                </x-dashboard-menu.single-item>

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

                @permission(['manage_seo'])
                <x-dashboard-menu.single-item :route="route('admin.seo.list')" :iconClass="'fa-radar'"
                                              :iconStyle="'fa-duotone'"
                                              :routes="'admin.seo.*'">
                    {{ __('SEO') }}
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
