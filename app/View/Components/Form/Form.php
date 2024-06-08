<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string $action
     * @param string $method
     * @param bool   $files
     */
    public function __construct(
        public string $action,
        public string $method = 'POST',
        public bool $files = false
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.form');
    }
}
