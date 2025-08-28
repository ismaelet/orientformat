@pushOnce('styles')
	<style>
		.area {
			&[data-area="1"] {
				--_color: rgb(255, 164, 0);
			}

			&[data-area="2"] {
				--_color: rgb(0, 99, 189);
			}

			&[data-area="3"] {
				--_color: rgb(0, 131, 179);
			}

			&[data-area="4"] {
				--_color: rgb(179, 0, 179);
			}
		}
	</style>
@endpushOnce

<a
	class="area cursor-pointer rounded bg-neutral-50 px-4 pb-4 pt-8 shadow transition-colors hover:bg-slate-100"
	data-area="{{ $area->id }}"
	href="{{ route('class.general.progress.show', ['class' => $class, 'area' => $area, 'grade' => $grade->id]) }}"
>
	<h3 class="text-2xl font-bold">{{ $area->name }}</h3>
	<p class="text-lg text-slate-400">Sezioni completate</p>

	<div class="mt-8 grid grid-cols-[minmax(0,1fr)_4rem] gap-2">
		<div class="shadow-sm-strong relative flex h-7 items-center rounded-sm bg-slate-100">
			<span
				class="bg-(--_color) absolute h-full rounded-[inherit] transition-all"
				style="width: {{ $completionPercentage }}%;"
			></span>
			<p @class([
				'relative pl-2 font-semibold transition-all',
				'text-white text-shadow-[1px_1px_2px_rgba(0,0,0,0.5)]' =>
					$completedSections > 0,
				'text-neutral-400' => $completedSections == 0,
			])>
				{{ $completedSections }}/{{ $totalSections }}
			</p>
		</div>

		<div @class([
			'shadow-sm-strong flex h-7 items-center justify-center rounded-sm font-semibold transition-all',
			'bg-slate-100' => $completionPercentage < 100,
			'text-white text-shadow-[1px_1px_2px_rgba(0,0,0,0.5)] bg-(--_color)' =>
				$completionPercentage === 100,
		])>
			{{ $completionPercentage }}%
		</div>
	</div>
</a>
