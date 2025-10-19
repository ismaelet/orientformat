@php
	$mainRoles = $helper::mainRoles($test, $student);
	$otherRoles = $helper::otherRoles($test, $student);
@endphp

<div class="">
	<x-test.title
		:$test
		description="In evidenza c’è il ruolo (o i ruoli) per il quale sei più portato, come emerge dal questionario. Tuttavia un buon risolutore di problemi dovrebbe possedere tutte le caratteristiche dei diversi ruoli. Osservando i descrittori che registrano il punteggio più basso, scoprirai dove puoi intervenire per migliorare le tue prestazioni."
	/>

	<div class="mt-8 grid grid-cols-1 gap-12">
		<section>
			<x-heading.component-big
				class="text-center">{{ $mainRoles->count() == 1 ? 'Ruolo Principale' : 'Ruoli Principali' }}</x-heading.component-big>

			<div class="mt-8 grid-cols-1 gap-8">
				@foreach ($mainRoles as $role)
					<article class="shadow-round grid items-center overflow-hidden rounded-lg md:grid-cols-2">
						<img
							src="{{ Vite::image('tests/problemi-superiori/role-' . $role['id'] . '.webp') }}"
							alt="{{ $role['name'] }}"
							class="max-h-120 h-full bg-neutral-200 object-cover"
						>
						<div class="grid grid-cols-1 gap-4 p-8">
							<x-heading.component class=""><span class="md:text-3xl">{{ $role['name'] }}
									({{ $role['percentage'] }}%)
							</x-heading.component>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
								magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
								consequat.</span></p>
						</div>
					</article>
				@endforeach
			</div>
		</section>

		<section>
			<x-heading.component
				class="text-center">{{ $otherRoles->count() == 1 ? 'Ruolo Secondario' : 'Ruoli Secondari' }}</x-heading.component>

			<div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-2">
				@foreach ($otherRoles as $role)
					<article class="shadow-round grid items-center overflow-hidden rounded-lg md:grid-cols-2">
						<img
							src="{{ Vite::image('tests/problemi-superiori/role-' . $role['id'] . '-sm.webp') }}"
							alt="{{ $role['name'] }}"
							class="h-full min-h-40 bg-neutral-200 object-cover"
						>
						<div class="grid grid-cols-1 gap-4 p-8">
							<x-heading.component class="">{{ $role['name'] }} ({{ $role['percentage'] }}%)</x-heading.component>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
								magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
								consequat.</p>
						</div>
					</article>
				@endforeach
			</div>
		</section>
	</div>
</div>
