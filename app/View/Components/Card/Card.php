<?php

namespace App\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'plain',
        public string $style = 'primary'
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->type !== 'plain') {
            $this->style = "card-{$this->style} card-outline";
        } else {
            $this->style = '';
        }

        return view('components.card.card');
    }
}
