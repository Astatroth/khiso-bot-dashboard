<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ShortcutAction extends Component
{
    /**
     * @var bool
     */
    public bool $isActive = false;

    /**
     * Create a new component instance.
     */
    public function __construct(public Collection $items)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        foreach ($this->items as $item) {
            if ($item->route_name === request()->route()->getName()) {
                $this->isActive = true;
                break;
            }
        }

        return view('components.shortcut-action', ['isActive' => $this->isActive]);
    }
}
