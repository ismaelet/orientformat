<div>
	<h2 class="dashboard-panel__title text-center">
		Consiglio orientativo
	</h2>

	<form
		class="grid grid-cols-1 gap-4 rounded bg-neutral-50 p-8 shadow"
		data-spacing="400"
		wire:submit="save"
	>
		<p>
			È possibile selezionare qui sotto uno o più consigli orientativi.
			Si può indicare un'area generica (ad esempio "Liceo") oppure
			un indirizzo più specifico:
		</p>

		<div
			class="mar-t-2 grid"
			data-spacing="400"
		>
			@for ($i = 0; $i < 3; $i++)
				<x-select wire:model="selectedAdvices.{{ $i }}">
					<option value="0">- nessuno -</option>

					@foreach ($advices as $adviceId => $adviceTitle)
						<option value="{{ $adviceId }}">
							{{ $adviceTitle }}
						</option>
					@endforeach
				</x-select>
			@endfor
		</div>

		@if (session()->has('advice-saved'))
			<p
				wire:key="advice-saved-{{ $saveCount }}"
				class="text-success-600"
				x-data="{ visible: true }"
				x-show="visible"
				x-init="setTimeout(() => visible = false, 5000)"
				x-transition
			>
				{{ session('advice-saved') }}
			</p>
		@endif

		<x-button
			type="submit"
			class="button push-right"
			wire:loading.attr="disabled"
			wire:target="save"
		>
			<span
				wire:loading.remove
				wire:target="save"
			>
				Salva
			</span>

			<span
				wire:loading
				wire:target="save"
			>
				Salvataggio…
			</span>
		</x-button>
	</form>
</div>
