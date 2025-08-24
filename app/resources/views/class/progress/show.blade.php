<x-layouts.class-dashboard :$class>

	<div class="flex items-center">
		<a
			class="hover:text-primary-400 transition-colors"
			href="{{ route('class.general.progress', ['class' => $class]) }}"
		>
			<x-icon-back class="h-12 w-12" />
		</a>

		<x-heading.main>{{ $area->name }}</x-heading.main>
	</div>

	<div class="columns-25rem mt-12 grid gap-8">
		@foreach ($sections as $section)
			<article>
				<h2 class="mb-2 text-2xl font-medium">{{ $section->name }}</h2>

				<ul class="grid grid-cols-1 gap-1 rounded bg-neutral-50 p-2 shadow">
					@foreach ($students as $student)
						<li class="grid w-full grid-cols-[1fr_auto]">
							<span
								class="fill flex h-full grow items-center rounded-sm bg-slate-100 px-2 font-medium">{{ $student->inverted_full_name }}</span>

							<span @class([
								'flex h-8 w-8 shrink-0 items-center justify-center rounded-sm',
								'bg-error-200' => !$student->hasCompletedSection($section),
								'bg-success-200' => $student->hasCompletedSection($section),
							])>
								<x-dynamic-component
									:component="'icon-correct'"
									@class([
										'w-4',
										'text-success-500' => $student->hasCompletedSection($section),
										'text-error-500' => !$student->hasCompletedSection($section),
									])
								/>
							</span>
						</li>
					@endforeach
				</ul>
			</article>
		@endforeach
	</div>

</x-layouts.class-dashboard>
