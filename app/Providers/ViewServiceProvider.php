<?php

namespace App\Providers;

use App\Services\ShortcutService;
use App\Services\UserService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerBladeDirectives();

        View::share([
            'ckeditorLocale' => app()->getLocale() !== 'uz' ? app()->getLocale() : 'en'
        ]);

        View::composer('dashboard.*', function ($view) {
            $view->with([
                'shortcuts' => (new ShortcutService())->getUserShortcuts(),
                'permissions' => (new UserService())->getPermissions(group: true)
            ]);
        });
    }

    /**
     * Register custom Blade directives.
     */
    protected function registerBladeDirectives(): void
    {
        if (!class_exists('\Blade')){
            return;
        }

        $this->registerRBACDirectives();
    }

    /**
     * Register Blade directives to handle RBAC functionality.
     */
    protected function registerRBACDirectives(): void
    {
        \Blade::directive('role', function($expression) {
            return "<?php if ((new \\App\\Services\\UserService())->hasRole({$expression})) : ?>";
        });

        \Blade::directive('endrole', function($expression) {
            return "<?php endif; // User::hasRole ?>";
        });

        \Blade::directive('permission', function($expression) {
            return "<?php if ((new \\App\\Services\\UserService())->can({$expression})) : ?>";
        });

        \Blade::directive('endpermission', function($expression) {
            return "<?php endif; // User::can ?>";
        });
    }
}
