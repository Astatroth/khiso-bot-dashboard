<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IntlPhoneNumber extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string $name
     */
    public function __construct(public string $name)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.intl-phone-number');
    }
}
