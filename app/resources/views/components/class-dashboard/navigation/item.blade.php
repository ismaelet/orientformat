@pushOnce('styles')
	<style>
		.dashboard-category__dropdown-wrapper {
			grid-row: 2;
			grid-column: 3 / -1;
			overflow: hidden;
			opacity: 0;
			transition: opacity 0.3s;
		}

		.dashboard-category__dropdown input {
			display: none;
		}

		.dashboard-category__link {
			display: grid;
			grid-template-columns: 0.5rem auto;
			align-items: center;
			gap: 0.5rem;
			padding-right: 2rem;
			text-wrap: nowrap;
			line-height: 1.2;
			font-family: var(--ff-titles);
			font-size: var(--fs-450);
			font-weight: var(--fw-light);
			transition: 0.2s;
		}

		.dashboard-category__link:has([name='dashboard-link']:checked),
		.dashboard-category__link:hover {
			color: var(--fc-700);
		}

		.dashboard-category__link::before {
			content: '';
			width: 100%;
			aspect-ratio: 1;
			border-radius: 2px;
		}

		.dashboard-category__link:nth-child(1n)::before {
			background-color: #65add6;
		}

		.dashboard-category__link:nth-child(2n)::before {
			background-color: #e7d78f;
		}

		.dashboard-category__link:nth-child(3n)::before {
			background-color: #f05749;
		}

		.dashboard-category__link:nth-child(4n)::before {
			background-color: #93b3aa;
		}

		.dashboard-category__link:nth-child(5n)::before {
			background-color: #c99bd1;
		}
	</style>
@endpushOnce

<label class="dashboard-category__link">
	<input
		type="radio"
		name="dashboard-link"
		@checked($checked)
	>

	<a
		href="{{ $url }}"
		class="text-base"
	>
		{{ $link['title'] }}
	</a>
</label>
