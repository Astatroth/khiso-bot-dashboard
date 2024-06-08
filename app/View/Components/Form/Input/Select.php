<?php

namespace App\View\Components\Form\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * @var bool
     */
    public $isRequired = false;

    /**
     * Create a new component instance.
     */
    public function __construct(public string $name, bool $required = false)
    {
        $this->isRequired = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input.select');
    }
}
