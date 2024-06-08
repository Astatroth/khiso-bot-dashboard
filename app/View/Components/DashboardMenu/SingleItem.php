<?php

namespace App\View\Components\DashboardMenu;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SingleItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $route,
        public string $iconClass,
        public string $iconStyle = 'fa',
        public array|string $routes = []
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard-menu.single-item');
    }
}
