@pushOnce('styles')
	<style>
		body {
			background-color: hsl(0, 0%, 3%);
		}

		.test__body {
			margin-bottom: unset;
		}

		.map__background {
			opacity: 0.5;
		}

		.map__background-container::after {
			content: '';
			position: absolute;
			inset: 0;
			background: radial-gradient(closest-side, hsl(0, 0%, 0%, 0), hsl(0, 0%, 3%, 1));
		}

		.map__system {
			width: 100%;
			padding: 5rem 3rem;
		}

		.star {
			width: 10%;
			aspect-ratio: 1;
		}

		.star__image {
			width: 100%;
			border-radius: 50%;
			box-shadow: 0 0 5rem 1rem hsl(34, 100%, 70%, 0.7);
		}

		.star__me {
			color: #fff;
			font-size: 3rem;
			text-shadow: 2px 2px 1rem rgba(0, 0, 0, 0.7);
			letter-spacing: 0.1em;
			margin-right: -0.1em;
		}

		.orbits {
			width: 100%;
			max-width: 1200px;
			aspect-ratio: 1;
		}

		.orbit {
			aspect-ratio: 1;
			border: 2px dashed hsl(0, 0%, 100%, 0.3);
			border-radius: 50%;
			position: relative;
			animation-name: orbiting;
			animation-timing-function: linear;
			animation-iteration-count: infinite;
			transition: border-color 0.2s;
		}

		.orbit:nth-child(1) {
			width: 100%;
			animation-duration: 30s;
			animation-delay: -22s;
		}

		.orbit:nth-child(2) {
			width: 82%;
			animation-duration: 22s;
			animation-delay: -2s;
		}

		.orbit:nth-child(3) {
			width: 64%;
			animation-duration: 15s;
			animation-delay: -10s;
		}

		.orbit:nth-child(4) {
			width: 47%;
			animation-duration: 11s;
			animation-delay: -8s;
		}

		.orbit:nth-child(5) {
			width: 30%;
			animation-duration: 7s;
			animation-delay: 0s;
		}

		.orbit:hover {
			border-color: var(--color-primary-400);
			animation-play-state: paused;
		}

		.planet {
			position: absolute;
			top: 50%;
			left: 50%;
			translate: -50% -50%;
			width: 5rem;
			animation-name: inherit;
			animation-duration: inherit;
			animation-timing-function: inherit;
			animation-iteration-count: inherit;
			animation-direction: reverse;
			animation-delay: inherit;
			transition: filter 0.2s, opacity 0.2s;
			cursor: pointer;
		}

		.orbits:has(.orbit:hover) .planet {
			opacity: 0.5;
			filter: saturate(0);
		}

		.orbit:hover .planet {
			opacity: 1 !important;
			filter: saturate(1) !important;
			animation-play-state: paused;
		}

		.planet:nth-child(1) {
			top: 0;
		}

		.planet:nth-child(2) {
			left: 0;
		}

		.planet:nth-child(3) {
			left: 100%;
		}

		.planet__image {
			width: 100%;
			aspect-ratio: 1;
			height: unset;
			position: relative;
			max-width: unset;
			border-radius: 50%;
			box-shadow: 0 1rem 4rem rgba(0, 0, 0, 0.7);
		}

		.planet__text {
			max-width: 20ch;
			width: max-content;
			position: relative;
			color: #fff;
			font-size: var(--fs-450);
			text-shadow: 1px 2px 2px rgba(0, 0, 0, 0.7);
		}

		.center-content:where(.grid),
		.center-content:where(.grid) {
			place-items: center;
			align-content: normal;
		}

		.center-content {
			text-align: center;
		}

		@keyframes orbiting {
			from {
				rotate: 0deg;
			}

			to {
				rotate: 360deg;
			}
		}

		body:has(.modal.open),
		body.fixed {
			position: relative;
			padding-right: 16px;
			overflow: hidden;
		}

		.modal-input {
			padding: 0.4em 0.8em;
			color: #fff;
			background-color: #303030;
		}

		.modal {
			position: fixed;
			inset: 0;
			z-index: 100;
			display: flex;
			visibility: hidden;
			opacity: 0;
			background-color: transparent;
			border: none;
			overflow: visible;
			transition: opacity 0.3s;
		}

		.modal::before {
			content: '';
			position: absolute;
			inset: 0;
			z-index: -1;
			background-color: rgba(0, 0, 0, 0.3);
		}

		.modal.open {
			visibility: visible;
			opacity: 1;
		}

		.modal-img {
			max-width: calc(100% - 4rem);
			max-height: calc(100% - 4rem);
			margin: auto;
		}

		.modal-form {
			display: grid;
			gap: 1rem;
			padding: 2rem;
			background-color: #fff;
			border-radius: var(--border-radius);
			box-shadow: 0 2rem 3rem -1rem rgba(0, 0, 0, 0.2);
		}

		.modal-form-header>* {
			text-align: center;
			font-size: 1.5rem;
			font-weight: 600;
		}

		.modal-form-footer {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			gap: 1rem;
		}

		.modal-form-footer .pbtn,
		.modal-form-footer .sbtn {
			flex-grow: 1;
			flex-basis: 0;
		}

		.modal {
			display: flex;
			position: fixed;
			inset: 0;
			z-index: 100;
			visibility: hidden;
			opacity: 0;
			transition: opacity 0.3s;
		}

		.modal::before {
			content: '';
			position: absolute;
			inset: 0;
			z-index: -1;
			background-color: hsl(0, 0%, 6%, 0.6);
			backdrop-filter: saturate(0.5);
		}

		.modal:has(.modal__content) {
			justify-content: center;
		}

		.modal.open {
			visibility: visible;
			opacity: 1;
		}

		.modal__close {
			opacity: 1;
			background-position: center;
			background-size: contain;
			width: 1.5rem;
			aspect-ratio: 1;
			position: absolute;
			top: 1rem;
			right: 1rem;
			filter: invert(1);
			cursor: pointer;
			transition: background 0.3s;
		}

		.modal__content {
			width: fit-content;
			max-width: 100%;
			min-width: min(400px, 100%);
			padding: 2rem;
			margin-block: auto;
			border-radius: var(--border-radius-400);
			box-shadow: 0 2rem 5rem rgba(0, 0, 0, 0.8);

			&.contrasting-background {
				background-color: #101010;
			}
		}
	</style>
@endpushOnce

@pushOnce('scripts')
	<script defer>
		const planetSelector = '.js-planet'
		const planetFieldSelector = '.js-planet-field'
		const planetTextSelector = '.js-planet-text'
		const interestSelector = '.js-interest'
		const addInterestSelector = '.js-add-interest'

		document.addEventListener('DOMContentLoaded', function() {
			const interestInput = document.querySelector(interestSelector)
			const addInterest = document.querySelector(addInterestSelector)

			let planetId = 0

			document.querySelectorAll(planetSelector).forEach((element) => {
				element.addEventListener('click', () => {
					const interest = element.querySelector(planetFieldSelector).value

					planetId = element.dataset.planetId

					interestInput.value = interest
					interestInput.focus()
				})
			})

			addInterest.addEventListener('click', () => {
				const planet = document.querySelector(planetSelector + '[data-planet-id="' + planetId + '"]')
				const planetField = planet.querySelector(planetFieldSelector)
				const planetText = planet.querySelector(planetTextSelector)
				const interest = interestInput.value

				planetField.value = interest
				planetText.innerHTML = interest
			})

			document.addEventListener('keypress', function(e) {
				if (e.code === 'Enter') {
					e.preventDefault()
				}
			})

			interestInput.addEventListener('keypress', function(e) {
				if (e.code === 'Enter') {
					addInterest.click()
				}
			})
		})

	</script>
@endpushOnce

<x-layouts.test
	:$title
	:$test
>
	<div class="dark mb-12 mt-12 grid grid-cols-1 gap-6">
		<x-test.title :$test />
		<x-test.button
			:$test
			class="w-full"
		/>
		<x-test.save :$completed />
	</div>

	<section class="map stack-content center-content fill-width grid">
		<div class="map__background-container relative">
			<img
				class="map__background h-full w-full object-cover"
				src="{{ Vite::image('tests/universo/background.webp') }}"
				alt=""
			>
		</div>

		<div class="content-grid w-full">
			<div class="breakout">
				<div class="map__system stack-content center-content grid">
					<div class="orbits stack-content center-content grid">
						@php
							$planetId = 0;
						@endphp

						@for ($i = 1; $i <= 5; $i++)
							<div class="orbit">
								@for ($j = 1; $j <= 3; $j++)
									@php
										$planetId++;
									@endphp

									<div
										class="planet {{ !isSupervisor() ? 'js-planet js-open-modal' : '' }} relative grid grid-cols-1 justify-items-center"
										data-planet-id="{{ $planetId }}"
										data-target="interest-modal"
									>
										<input
											type="hidden"
											class="js-planet-field"
											name="field[]"
											value="{{ $result ? $result[$planetId - 1] : null }}"
										>

										<img
											src="{{ Vite::image('tests/universo/planet-' . $planetId . '.svg') }}"
											alt=""
											class="planet__image"
										>

										<p class="planet__text js-planet-text pointer-events-none absolute">
											{{ $result ? $result[$planetId - 1] : null }}
										</p>
									</div>
								@endfor
							</div>
						@endfor
					</div>

					<div class="star stack-content center-content grid">
						<img
							class="star__image relative"
							src="{{ Vite::image('tests/universo/star.svg') }}"
							alt=""
						>
						<p class="star__me font-heading relative font-bold">{{ __('ME') }}</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section
		class="modal items-center justify-center"
		id="interest-modal"
	>
		<div class="max-w-100 dark grid w-full grid-cols-1 gap-8 rounded bg-neutral-900 p-8">
			<x-heading.component class="text-center">Inserisci l'interesse</x-heading.component>

			<x-input
				type="text"
				class="js-interest"
				placeholder="Interesse"
				maxlength="50"
			/>

			<x-button
				type="button"
				class="js-add-interest js-close-modal"
			>
				Inserisci
			</x-button>
		</div>
	</section>
</x-layouts.test>
