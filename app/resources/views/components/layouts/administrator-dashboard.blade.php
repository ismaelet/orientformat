@props(['school'])

<x-layouts.main :title="'Amministrazione - ' . $school->name">

	<div class="dashboard span-full-width bg-slate-50 md:flex">
		<x-administrator-dashboard.navigation />

		<div class="w-full p-8">
			{{ $slot }}
		</div>
	</div>

</x-layouts.main>
