<?php

namespace App\View\Components\ClassDashboard\Navigation;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Category extends Component {

	/**
	 * Property: The URL of the category
	 */
	public ?string $url = null;

	/**
	 * Property: The route name of the category
	 */
	public ?string $routeName = null;

	/**
	 * Property: The links within the category
	 */
	public ?array $links = null;

	/**
	 * Property: Whether the category is checked
	 */
	public bool $checked = false;

	/**
	 * Create a new component instance
	 */
	public function __construct(public array $category) {
		$this->url = isset($category['url']) ? route(...$category['url']) : null;
		$this->routeName = $category['url'][0] ?? null;
		$this->links = $category['links'] ?? null;
		$this->checked = $this->isChecked();
	}

	/**
	 * Get the view / contents that represent the component
	 */
	public function render(): View|Closure|string {
		return view('components.class-dashboard.navigation.category');
	}

	/**
	 * Check if the category is checked
	 */
	private function isChecked(): bool {
		if (!$this->routeName) {
			return false;
		}

		$currentRouteName = request()->route()->getName();

		if ($this->routeName === $currentRouteName) {
			return true;
		}

		return false;
	}
}
