<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IncludedFeatures extends Component
{
    public mixed $features;
    /**
     * Create a new component instance.
     */
    public function __construct($features)
    {
        $this->features = $features;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.included-features');
    }
}
