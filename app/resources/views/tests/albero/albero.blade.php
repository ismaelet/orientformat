@pushOnce('styles')
	<style>
		.test__body {
			margin-bottom: 0;
		}

		.tree-wrapper {
			overflow-x: auto;
		}

		.tree {
			>* {
				grid-row: 1;
			}
		}

		.tree__side-image {
			height: 100%;
			background-size: auto 100%;
		}

		.tree__side-image:nth-child(1) {
			grid-column: full-width-start / content-start;
			background-position: right;
		}

		.tree__side-image:nth-child(2) {
			grid-column: content-end / full-width-end;
			background-position: left;
		}

		.tree__center {
			width: calc(100% + 1px);
			position: relative;
		}

		/* Branches */
		.branch__leaves,
		.branch__highlight {
			position: absolute;
			inset: 0;
			opacity: 0;
			z-index: 1;
			background-size: contain;
			transition: opacity 0.4s;
			pointer-events: none;
		}

		.branch.active .branch__leaves {
			opacity: 1;
		}

		.branch__highlight.active {
			opacity: 1;
		}

		.branch__interaction {
			position: absolute;
			translate: -50% -50%;
			cursor: pointer;
			z-index: 1;
		}

		.branch[data-id='1'] .branch__interaction {
			rotate: 30deg;
			top: 44%;
			left: 29%;
			width: 44%;
			aspect-ratio: 1.8;
		}

		.branch[data-id='2'] .branch__interaction {
			rotate: 0deg;
			top: 60%;
			left: 29%;
			width: 36%;
			aspect-ratio: 2.5;
		}

		.branch[data-id='3'] .branch__interaction {
			rotate: 50deg;
			top: 33%;
			left: 48%;
			width: 37%;
			aspect-ratio: 1.8;
		}

		.branch[data-id='4'] .branch__interaction {
			rotate: 130deg;
			top: 40%;
			left: 73%;
			width: 33%;
			aspect-ratio: 1.4;
		}

		.branch[data-id='5'] .branch__interaction {
			rotate: 0deg;
			top: 60%;
			left: 79%;
			width: 35%;
			aspect-ratio: 2;
		}

		.branch__name {
			position: absolute;
			translate: -50% -50%;
			z-index: 3;
			color: #fff;
			font-size: min(var(--text-xl), 4cqw);
			font-weight: var(--font-weight-medium);
			font-family: var(--font-heading);
			line-height: 1.2;
			text-align: center;
			text-shadow: 1px 2px 0.5rem rgb(0, 0, 0, 0.9);
			text-transform: uppercase;
			letter-spacing: 0.05em;
			pointer-events: none;
		}

		.branch[data-id='1'] .branch__name {
			rotate: 13deg;
			top: 48.1%;
			left: 33%;
			z-index: 2;
		}

		.branch[data-id='2'] .branch__name {
			rotate: -2deg;
			top: 58.7%;
			left: 30%;
		}

		.branch[data-id='3'] .branch__name {
			rotate: 32deg;
			top: 38.7%;
			left: 49%;
		}

		.branch[data-id='4'] .branch__name {
			rotate: 295deg;
			top: 47%;
			left: 64.5%;
		}

		.branch[data-id='5'] .branch__name {
			rotate: 20deg;
			top: 57.5%;
			left: 79%;
		}

		/* Fruits */
		.fruit {
			visibility: hidden;
			position: absolute;
			z-index: 2;
			translate: -50% -50%;
			width: 6.5%;
			opacity: 1;
			cursor: pointer;
		}

		.branch.active .fruit {
			visibility: visible;
		}

		.fruit[data-fruit-id='1'] {
			top: 50%;
			left: 23%;
		}

		.fruit[data-fruit-id='2'] {
			top: 52.5%;
			left: 37%;
			transform: rotate(4deg);
		}

		.fruit[data-fruit-id='3'] {
			top: 39.5%;
			left: 20%;
		}

		.fruit[data-fruit-id='4'] {
			top: 62.2%;
			left: 18%;
			transform: rotate(-4deg);
		}

		.fruit[data-fruit-id='5'] {
			top: 62.5%;
			left: 27%;
			transform: rotate(-7deg);
		}

		.fruit[data-fruit-id='6'] {
			top: 62.5%;
			left: 39%;
			transform: rotate(0deg);
		}

		.fruit[data-fruit-id='7'] {
			top: 35%;
			left: 33%;
			transform: rotate(0deg);
		}

		.fruit[data-fruit-id='8'] {
			top: 42%;
			left: 47%;
			transform: rotate(4deg);
		}

		.fruit[data-fruit-id='9'] {
			top: 25.5%;
			left: 47.5%;
			transform: rotate(-7deg);
		}

		.fruit[data-fruit-id='10'] {
			top: 37%;
			left: 67%;
			transform: rotate(0deg);
		}

		.fruit[data-fruit-id='11'] {
			top: 45.1%;
			left: 86%;
			transform: rotate(-2deg);
		}

		.fruit[data-fruit-id='12'] {
			top: 49.7%;
			left: 70.7%;
			transform: rotate(-8deg);
		}

		.fruit[data-fruit-id='13'] {
			top: 62%;
			left: 66%;
			transform: rotate(-7deg);
		}

		.fruit[data-fruit-id='14'] {
			top: 62%;
			left: 80%;
			transform: rotate(3deg);
		}

		.fruit[data-fruit-id='15'] {
			top: 64.5%;
			left: 88%;
			transform: rotate(-5deg);
		}

		.fruit__images {
			transform-origin: top;
			scale: 0.5;
			visibility: hidden;
			transition: opacity 0.4s, translate 0.4s, scale 0.4s;
		}

		.fruit.active .fruit__images {
			visibility: visible;
			opacity: 1;
			scale: 1;
		}

		.fruit:hover .fruit__image {
			opacity: 0;
			transition: opacity 0s 0.15s;
		}

		.fruit__image--highlight {
			opacity: 0;
			transition: opacity 0.15s;
		}

		.fruit:hover .fruit__image--highlight {
			opacity: 1;
			transition: opacity 0.15s;
		}

		.fruit__add {
			display: grid;
			place-items: center;
			width: 75%;
			aspect-ratio: 1;
			opacity: 0;
			scale: 0.5;
			background-color: var(--color-primary-400);
			border-radius: 50%;
			box-shadow: 0.5rem 1rem 2rem rgb(0, 0, 0, 0.3);
			color: #fff;
			cursor: pointer;
			transition: background 0.2s, scale 0.2s, opacity 0.2s;

			svg {
				width: 60%;
				height: 60%;
			}
		}

		.branch.active .fruit:not(.active) .fruit__add {
			opacity: 1;
			scale: 1;
		}

		.fruit__add:hover {
			background-color: var(--color-primary-500);
		}

		.fruit__name {
			position: absolute;
			opacity: 0;
			color: #fff;
			background: rgba(0, 0, 0, 0.7);
			border-radius: var(--radius-md);
			font-size: min(var(--text-lg), 3vw);
			left: 50%;
			translate: -50% -1rem;
			width: max-content;
			max-width: 7rem;
			padding: 0.2rem 0.5rem;
			line-height: 1.2;
			word-wrap: break-word;
			text-align: center;
			text-transform: lowercase;
			transition: opacity 0.4s, translate 0.4s;
		}

		.fruit.active .fruit__name {
			opacity: 1;
			translate: -50% 0.25rem;
		}

		.modal__content {
			position: relative;
			width: fit-content;
			max-width: 100%;
			min-width: min(400px, 100%);
			padding: 2rem;
			margin-block: auto;
			background-color: var(--color-background);
			border-radius: var(--radius-sm);
			box-shadow: 0 2rem 5rem rgba(0, 0, 0, 0.8);

			&.contrasting-background {
				background-color: #101010;
			}
		}
	</style>
@endpushOnce

@pushOnce('scripts')
	<script defer>
		// branches
		const branchSelector = '.js-branch'
		const branchHighlightSelector = '.js-branch-highlight'
		const branchLeavesSelector = '.js-branch-leaves'
		const branchInteractionSelector = '.js-branch-interaction'
		const branchValueSelector = '.js-branch-value'
		const branchNameSelector = '.js-branch-name'

		// fruits
		const fruitSelector = '.js-fruit'
		const fruitValueSelector = '.js-fruit-value'
		const fruitNameSelector = '.js-fruit-name'
		const fruitInteractionSelector = '.js-fruit-interaction'

		// modals
		const branchNameInputSelector = '.js-branch-name-input'
		const fruitNameInputSelector = '.js-fruit-name-input'
		const addBranchSelector = '.js-add-branch'
		const addFruitSelector = '.js-add-fruit'

		document.addEventListener('DOMContentLoaded', function() {
			const branchNameInput = document.querySelector(branchNameInputSelector)
			const fruitNameInput = document.querySelector(fruitNameInputSelector)
			const addBranch = document.querySelector(addBranchSelector)
			const addFruit = document.querySelector(addFruitSelector)

			let activeBranchId
			let activeFruitId

			document.addEventListener('keypress', function(e) {
				if (e.code === 'Enter') {
					e.preventDefault()
				}
			})

			// branch interactions
			document.querySelectorAll(branchInteractionSelector).forEach((element) => {
				const branch = element.closest(branchSelector)

				element.addEventListener('click', () => {
					activeBranchId = branch.dataset.id
					branchName = branch.querySelector(branchValueSelector).value
					branchNameInput.value = branchName
					branchNameInput.focus()
				})

				element.addEventListener('mouseenter', () => {
					branch.querySelector(branchHighlightSelector).classList.add('active')
				})

				element.addEventListener('mouseleave', () => {
					branch.querySelector(branchHighlightSelector).classList.remove('active')
				})
			})

			// branch modal interaction
			addBranch.addEventListener('click', () => {
				const branchName = branchNameInput.value
				const branch = document.querySelector(branchSelector + '[data-id="' + activeBranchId + '"]')
				const branchValueElement = branch.querySelector(branchValueSelector)
				const branchNameElement = branch.querySelector(branchNameSelector)

				branchValueElement.value = branchName
				branchNameElement.innerHTML = branchName

				if (branchName) {
					branch.classList.add('active')
				} else {
					branch.classList.remove('active')

					branch.querySelectorAll(fruitSelector).forEach((element) => {
						element.classList.remove('active')
					})

					branch.querySelectorAll(fruitValueSelector).forEach((element) => {
						element.value = ''
					})

					branch.querySelectorAll(fruitNameSelector).forEach((element) => {
						element.innerHTML = ''
					})
				}

				closeModal(null, 'branch-modal')
			})

			branchNameInput.addEventListener('keypress', function(e) {
				if (e.code === 'Enter') {
					addBranch.click()
				}
			})

			// fruit interaction
			document.querySelectorAll(fruitInteractionSelector).forEach((element) => {
				element.addEventListener('click', () => {
					fruit = element.closest(fruitSelector)
					activeFruitId = fruit.dataset.fruitId
					fruitValueElement = fruit.querySelector(fruitValueSelector)
					fruitName = fruitValueElement.value
					fruitNameInput.value = fruitName
					fruitNameInput.focus()
				})
			})

			// fruit modal interaction
			addFruit.addEventListener('click', () => {
				const fruitName = fruitNameInput.value
				const fruit = document.querySelector(fruitSelector + '[data-fruit-id="' + activeFruitId + '"]')
				const fruitValueElement = fruit.querySelector(fruitValueSelector)
				const fruitNameElement = fruit.querySelector(fruitNameSelector)

				fruitValueElement.value = fruitName

				if (fruitName) {
					fruitNameElement.innerHTML = fruitName
					fruit.classList.add('active')
				} else {
					fruit.classList.remove('active')
				}

				closeModal(null, 'fruit-modal')
			})

			fruitNameInput.addEventListener('keypress', function(e) {
				if (e.code === 'Enter') {
					addFruit.click()
				}
			})
		})
	</script>
@endpushOnce

<x-layouts.test
	:$title
	:$test
>
	<x-test.title
		:$test
		class="mb-8 mt-8"
	/>

	<div class="grid grid-cols-1 content-start gap-2">
		<x-test.button :$test />
		<x-test.save :$completed />
	</div>

	<!-- Tree -->
	<section class="tree-wrapper fill-width">
		<div class="tree full-width {{ $completed ? 'completed' : '' }}">
			<!-- Side images -->
			<div
				class="tree__side-image"
				style="background-image: url('{{ Vite::image('tests/albero/tree-1.webp') }}')"
			></div>
			<div
				class="tree__side-image"
				style="background-image: url('{{ Vite::image('tests/albero/tree-3.webp') }}')"
			></div>

			<!-- Center content -->
			<div class="tree__center">
				<!-- Tree image -->
				<img
					class="tree__center-image"
					src="{{ Vite::image('tests/albero/tree-2.webp') }}"
					alt=""
				>

				@php
					$fruitId = 0;
				@endphp

				@for ($i = 0; $i < 5; $i++)
					<div
						class="branch js-branch {{ empty($helper->branchResults[$i]) ? '' : 'active' }}"
						data-id="{{ $i + 1 }}"
						x-data
					>

						<!-- Branch value -->
						<input
							type="hidden"
							class="js-branch-value"
							name="branch[]"
							value="{{ $helper->branchResults[$i] ?? null }}"
						>

						<!-- Branch layers -->
						<div
							class="branch__highlight js-branch-highlight"
							style="background-image: url('{{ Vite::image('tests/albero/branch-highlight-' . ($i + 1) . '.webp') }}')"
						></div>

						<div
							class="branch__leaves js-branch-leaves"
							style="background-image: url('{{ Vite::image('tests/albero/branch-' . ($i + 1) . '.webp') }}')"
						></div>

						<div
							class="branch__interaction js-branch-interaction js-open-modal"
							data-target="branch-modal"
							@click="openModal('branch-modal')"
						></div>

						<p class="branch__name js-branch-name">{{ $helper->branchResults[$i] ?? null }}</p>

						<!-- Fruits -->
						@for ($j = 0; $j < 3; $j++)
							<div
								class="fruit js-fruit {{ empty($helper->fruitsResults[$fruitId]) ? '' : 'active' }}"
								data-fruit-id="{{ $fruitId + 1 }}"
							>
								<input
									type="hidden"
									class="js-fruit-value"
									name="fruit[]"
									value="{{ $helper->fruitsResults[$fruitId] ?? null }}"
									data-fruit-id="{{ $fruitId }}"
								>

								<div
									class="fruit__content stack-content center-content js-fruit-interaction js-open-modal grid place-items-center"
									data-target="fruit-modal"
									@click="openModal('fruit-modal')"
								>
									<div class="fruit__images stack-content grid">
										<img
											class="fruit__image"
											src="{{ Vite::image('tests/albero/fruit-' . ($i + 1) . '.webp') }}"
										>
										<img
											class="fruit__image fruit__image--highlight"
											src="{{ Vite::image('tests/albero/fruit-' . ($i + 1) . '-highlight.webp') }}"
										>
									</div>

									<div class="fruit__add">
										{!! embed_icon('add') !!}
									</div>
								</div>

								<p class="fruit__name js-fruit-name">{{ $helper->fruitsResults[$fruitId] ?? null }}</p>
							</div>

							@php $fruitId++; @endphp
						@endfor

					</div>
				@endfor

			</div>
		</div>
	</section>

	<div class="my-12 grid grid-cols-1 content-start gap-2">
		<x-test.button :$test />
		<x-test.save :$completed />
	</div>

	<x-modal
		class="modal"
		id="branch-modal"
	>
		<div class="modal__content center-content grid gap-8">
			<x-heading.component class="text-center">Inserisci il nome della categoria</x-heading.component>
			<x-input
				class="input fa-center js-branch-name-input"
				placeholder="Per es. musica, arte, sport o abilità manuali"
				maxlength="25"
			/>
			<x-button
				type="button"
				class="js-add-branch"
			>Inserisci</x-button>
		</div>
	</x-modal>

	<x-modal
		class="modal"
		id="fruit-modal"
	>
		<div class="modal__content center-content grid gap-8">
			<x-heading.component class="text-center">Inserisci la competenza</x-heading.component>
			<x-input
				class="input fa-center js-fruit-name-input"
				placeholder="Per es. suonare la chitarra, giocare a calcio, disegnare, ecc."
				maxlength="25"
			/>
			<x-button
				type="button"
				class="js-add-fruit"
			>Inserisci</x-button>
		</div>
	</x-modal>

</x-layouts.test>
