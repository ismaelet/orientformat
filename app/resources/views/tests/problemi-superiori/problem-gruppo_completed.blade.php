@php
	$mainRoles = $helper::mainRoles($test, $student);
	$otherRoles = $helper::otherRoles($test, $student);
@endphp

<div class="full-width">
	<x-test.title
		:$test
		description="{{ __('problem-gruppo.completed-description') }}"
	/>

	<div class="full-width mt-8 grid gap-12">
		<section>
			<x-heading.component-big
				class="text-center">{{ $mainRoles->count() == 1 ? __('problem-gruppo.main-role-singular') : __('problem-gruppo.main-role-plural') }}</x-heading.component-big>

			<div class="mt-8 grid grid-cols-1 gap-8">
				@foreach ($mainRoles as $role)
					<article
						class="shadow-round grid items-center overflow-hidden rounded-lg md:grid-cols-2"
						x-data="{ open: false }"
					>
						<img
							src="{{ Vite::image('tests/problemi-superiori/role-' . $role['id'] . '.webp') }}"
							alt="{{ $role['name'] }}"
							class="h-full bg-neutral-200 object-cover"
						>
						<div class="grid grid-cols-1 gap-4 p-4 md:p-8">
							<x-heading.component class=""><span class="md:text-3xl">{{ $role['name'] }}
									({{ $role['percentage'] }}%)
							</x-heading.component>
							<p>{{ $role['description'] }}</p>

							<x-button
								variant="secondary"
								size="xs"
								x-show="!open"
								@click="open = !open"
							>Mostra risposte</x-button>

							<div
								class="grid grid-cols-[minmax(0,_1fr)_max-content] gap-x-6"
								x-show="open"
								x-cloak
							>
								@foreach ($role['answers'] as $questionId => $answer)
									<div class="col-span-full grid grid-cols-subgrid items-center rounded-xl px-4 py-2 even:bg-slate-100">
										<p class="italic">{{ $helper::getQuestion($questionId)['text'] }}</p>
										<p class="font-bold">{{ $helper::getAnswerPercentage($answer) }}%</p>
									</div>
								@endforeach
							</div>
						</div>
					</article>
				@endforeach
			</div>
		</section>

		<section class="breakout">
			<x-heading.component
				class="text-center">{{ $otherRoles->count() == 1 ? __('problem-gruppo.other-roles-singular') : __('problem-gruppo.other-roles-plural') }}</x-heading.component>

			<div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-2">
				@foreach ($otherRoles as $role)
					<article
						class="shadow-round grid items-center overflow-hidden rounded-lg md:grid-cols-2"
						x-data="{ open: false }"
					>
						<img
							src="{{ Vite::image('tests/problemi-superiori/role-' . $role['id'] . '-sm.webp') }}"
							alt="{{ $role['name'] }}"
							class="h-full min-h-40 bg-neutral-200 object-cover"
						>
						<div class="grid grid-cols-1 gap-4 p-8">
							<x-heading.component class="">{{ $role['name'] }} ({{ $role['percentage'] }}%)</x-heading.component>
							<p>{{ $role['description'] }}</p>

							<x-button
								variant="secondary"
								size="2xs"
								x-show="!open"
								@click="open = !open"
							>Mostra risposte</x-button>
						</div>

						<div
							class="grid grid-cols-[minmax(0,_1fr)_max-content] gap-x-6 px-4 py-6 md:col-span-full"
							x-show="open"
							x-cloak
						>
							@foreach ($role['answers'] as $questionId => $answer)
								<div class="col-span-full grid grid-cols-subgrid items-center rounded-xl px-4 py-2 even:bg-slate-100">
									<p class="italic">{{ $helper::getQuestion($questionId)['text'] }}</p>
									<p class="font-bold">{{ $helper::getAnswerPercentage($answer) }}%</p>
								</div>
							@endforeach
						</div>
					</article>
				@endforeach
			</div>
		</section>
	</div>
</div>
