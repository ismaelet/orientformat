@props(['navigationGroups'])

@push('styles')
	<style>
		.dashboard {
			display: grid;
			grid-template-columns: max-content minmax(0, 1fr);
		}
	</style>
@endpush

<div class="dashboard">
	<!-- Navigation bar -->
	<x-dashboard.navigation :groups="$navigationGroups" />

	<!-- Body -->
	<section class="min-h-svh p-8">
		<div class="min-w-64">

			{{ $slot }}

		</div>
	</section>
</div>
