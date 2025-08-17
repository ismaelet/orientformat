@pushOnce('styles')
	<style>
		.dashboard__navigation {
			--fc-700: #fff;
			--fc-400: hsl(calc(var(--_background-h) - 4), 25%, 60%);
			display: block;
			color: var(--fc-400);
			padding-bottom: 5rem;
			transition: width 0.4s;
		}

		.dashboard__navigation-wrapper {
			position: sticky;
			top: 0;
			max-height: 100dvh;
		}


		.dashboard__navigation-header {
			padding-block: 4rem 5rem;
			padding-inline: 0.5rem;
		}

		.dashboard__logo {
			--_padding: 0.6rem;
			display: flex;
			margin-inline: auto;
			width: clamp(4rem, 10vw, 7rem);
			max-width: 100%;
			padding: var(--_padding);
			background: conic-gradient(var(--color-primary-400), var(--color-transition-400), var(--color-secondary-400), var(--_background));
			border-radius: 50%;
		}

		.dashboard__logo::after {
			content: attr(data-content);
			display: flex;
			align-items: center;
			justify-content: center;
			width: 100%;
			aspect-ratio: 1;
			outline: calc(var(--_padding) - 1px) solid var(--color-tertiary-800);
			outline-offset: -1px;
			background-color: var(--color-tertiary-700);
			border-radius: inherit;
			color: var(--fc-700);
			font-family: var(--ff-titles);
			font-size: calc(min(3rem, 4.5vw) * 2/var(--character-count));
			line-height: 1;
			text-shadow: 0.25rem 0.5rem 1rem black;
		}

		.dashboard__navigation-body {
			display: grid;
			grid-template-columns: minmax(0, 1fr);
			gap: 2rem;
		}
	</style>
@endpushOnce

<aside class="dashboard__navigation js-dashboard-navigation">
	<div class="dashboard__navigation-wrapper">

		<div class="dashboard__navigation-header">
			<!-- logo -->
			<div
				class="dashboard__logo"
				data-content="{{ $class->name }}"
				style="--character-count: {{ mb_strlen($class->name) }}"
			></div>
		</div>

		<!-- Admin sections -->
		<nav class="dashboard__navigation-body">

			<!-- Navigation -->
			@foreach ($navigation as $category)
				<x-class-dashboard.navigation.category :$category />
			@endforeach

		</nav>
	</div>
</aside>
