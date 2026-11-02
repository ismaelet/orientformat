<?php

namespace App\View\Components\ClassDashboard\Navigation;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Item extends Component
{
    public bool $checked = false;

    public string $url = '';

    /**
     * Create a new component instance.
     */
    public function __construct(public array $link)
    {
        $routeName = $link['url'][0] ?? null;
        $currentRouteName = request()->route()->getName();

        $this->checked = $routeName === $currentRouteName;

        $this->url = isset($link['url']) ? route(...$link['url']) : '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.class-dashboard.navigation.item');
    }
}
