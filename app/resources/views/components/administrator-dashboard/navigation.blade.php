@php
	$navigation = [
	    [
	        'label' => 'Gestione classi',
	        'icon' => 'school-classes',
	        'url' => 'administrator.classes.index',
	    ],
	    [
	        'label' => 'Gestione docenti',
	        'icon' => 'teachers',
	        'url' => 'administrator.teachers.index',
	    ],
	    [
	        'label' => 'Gestione studenti',
	        'icon' => 'users',
	        'url' => 'administrator.students.index',
	    ],
	];

	$currentRoute = request()->route()->getName();
@endphp

<aside class="bg-tertiary-400 shadow-lg md:h-full md:w-80">
	<nav class="sticky top-0 grid content-center justify-center py-20">
		@foreach ($navigation as $category)
			<a
				href="{{ route($category['url']) }}"
				class="hover:bg-tertiary-500 flex items-center gap-4 p-4 text-white opacity-50 transition-opacity hover:opacity-100 data-[active=true]:opacity-100"
				data-active="{{ $currentRoute === $category['url'] ? 'true' : 'false' }}"
			>
				<x-dynamic-component
					:component="'icon-' . $category['icon']"
					class="h-6 w-6 shrink-0"
				/>
				<span class="font-semibold">{{ $category['label'] }}</span>
			</a>
		@endforeach

	</nav>
</aside>
