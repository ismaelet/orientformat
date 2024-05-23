@props(['groups'])

@push('styles')
	<style>
		.navigation {
			position: relative;
			width: 18rem;
			transition: width 0.4s;
		}

		@scope (.navigation)

			{
			.navigation-content {
				position: sticky;
				top: 0;
				height: 100svh;
				padding-inline: 2.5rem;
				overflow: auto;
				scrollbar-width: thin;
				scrollbar-color: var(--color-surface-400) var(--color-background);
			}
		}
	</style>
@endpush

<aside class="navigation js-navigation">
	<div class="navigation-content">

		<div class="">
			<!-- Dashboard title -->
			<div class="navigation-header mb-12 mt-10 grid justify-items-center text-center text-neutral-700">
				<img
					src="<?= asset('images/logo/logo.png') ?>"
					alt=""
					class="h-16"
				>
			</div>

			<!-- Dashboard groups -->
			<div class="js-open-navigation grid gap-4">

				@foreach ($groups as $group)
					<x-dashboard.navigation.group :navigation-group="$group" />
				@endforeach
			</div>

		</div>
</aside>
