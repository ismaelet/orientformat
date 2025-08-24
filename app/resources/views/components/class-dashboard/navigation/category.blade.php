@pushOnce('styles')
	<style>
		.dashboard-category {
			--icon-size: 1rem;
			--_padding: min(4rem, 4vw);
			display: grid;
			grid-template-columns: var(--_padding) var(--_icon-size) minmax(0, 1fr) var(--_padding);
			grid-template-rows: max-content 0fr;
			column-gap: 0.75rem;
			transition: grid-template-rows 0.3s, grid-template-columns 0.4s;
		}

		.dashboard-category input {
			display: none;
		}

		@media (max-width: 1024px) {
			.dashboard__navigation:not(.open) .dashboard-category {
				grid-template-columns: var(--_padding) var(--_icon-size) 0fr var(--_padding);
			}
		}

		.dashboard-category__header {
			grid-column: 1 / -1;
			display: grid;
			grid-template-columns: subgrid;
			align-items: center;
			font-size: var(--fs-450);
			cursor: pointer;
		}

		.dashboard-category__header a {
			display: contents;
		}

		.dashboard-category__header::before {
			content: '';
			opacity: 0;
			background-color: var(--color-primary-400);
			box-shadow: 3px 0 1rem 0 var(--color-primary-400), 3px 0 2rem 0 var(--color-primary-400);
			width: 3px;
			height: 100%;
			transition: opacity 0.2s;
		}

		.dashboard-category__label {
			font-size: 1em;
			font-family: var(--ff-titles);
			font-weight: var(--font-weight-medium);
			text-wrap: nowrap;
			transition: color 0.2s;
			cursor: pointer;
			overflow: hidden;
		}

		.dashboard-category__header .icon-embed {
			grid-column: 3;
			cursor: pointer;
		}

		.dashboard-category__dropdown {
			display: grid;
			gap: 1.5rem;
			grid-template-columns: minmax(0, 1fr);
			padding-top: 1.5rem;
		}

		.dashboard__navigation.open .dashboard-category:has([name='dashboard-category']:checked),
		.dashboard__navigation.open .dashboard-category:has([name='dashboard-link']:checked) {
			grid-template-rows: max-content 1fr;
		}

		@media (min-width: 1025px) {

			.dashboard-category:has([name='dashboard-category']:checked),
			.dashboard-category:has([name='dashboard-link']:checked) {
				grid-template-rows: max-content 1fr;
			}
		}

		.dashboard-category:has([name='dashboard-category']:checked) .dashboard-category__dropdown-wrapper,
		.dashboard-category:has([name='dashboard-link']:checked) .dashboard-category__dropdown-wrapper {
			opacity: 1;
		}

		.dashboard-category__header:has([name='dashboard-category']:checked),
		.dashboard-category__header:hover {
			color: var(--fc-700);
		}

		.dashboard-category:has([name='dashboard-category']:checked) .dashboard-category__header::before,
		.dashboard-category:has([name='dashboard-link']:checked) .dashboard-category__header::before {
			opacity: 1;
		}
	</style>
@endpushOnce

<ul class="dashboard-category relative">

	{{-- Title --}}
	<label class="dashboard-category__header">
		@if ($url)
			<a href="{{ $url }}">
				<input
					type="radio"
					name="dashboard-category"
					@checked($checked)
				>

				<x-dynamic-component :component="'icon-' . $category['icon']" />

				<p class="dashboard-category__label">{{ $category['title'] }}</p>
			</a>
		@else
			<div class="contents">
				<input
					type="radio"
					name="dashboard-category"
				>

				<x-dynamic-component :component="'icon-' . $category['icon']" />
				<p class="dashboard-category__label">{{ $category['title'] }}</p>
			</div>
		@endif
	</label>

	@if ($links)
		{{-- Dropdown --}}
		<ul class="dashboard-category__dropdown-wrapper">
			<div class="dashboard-category__dropdown">
				@foreach ($links as $key => $link)
					@if ($link)
						<x-class-dashboard.navigation.item
							:$link
							:$key
						/>
					@endif
				@endforeach
			</div>
		</ul>
	@endif

</ul>
