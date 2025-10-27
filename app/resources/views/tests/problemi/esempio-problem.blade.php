@pushOnce('styles')
	<style>
		main article {
			font-size: 1.125rem;
			line-height: 2;
			padding-bottom: 3rem;
			border-bottom: 1px solid var(--color-slate-300);

			&:last-child {
				border-bottom: none;
				padding-bottom: 0;
			}

			ul {
				margin-left: 2rem;
				list-style: outside;
			}

			ul>li>ul {
				list-style: circle;
			}

			ol {
				display: grid;
				grid-template-columns: minmax(0, 1fr);
				gap: 1rem;
				list-style-type: decimal;
				margin-left: 1.5rem;
			}

			ol>li::marker {
				font-weight: bold;
				font-size: 1.25rem
			}

			h4 {
				font-size: 1.25rem;
				font-weight: 600;
			}

			table {
				border-collapse: separate;
				border-spacing: 4rem 1rem;
				margin: -1rem -4rem;
				margin-top: 2rem;

				td {
					font-size: 1rem;
				}
			}
		}
	</style>
@endpushOnce

<x-layouts.test
	:$title
	:$test
>
	<div class="mb-20 mt-10">
		<x-test.title :$test />

		<div class="mt-12 grid grid-cols-1 gap-12">
			<div class="grid grid-cols-1 gap-4">
				<x-heading.component>
					{{ __('problem-gruppo.example-subtitle-1') }}</x-heading.component>
				<ul class="grid grid-cols-1 gap-2">
					{!! __('problem-gruppo.example-list') !!}
				</ul>
			</div>
		</div>

		<section class="mt-16">
			<x-heading.component-big class="text-center">{!! __('problem-gruppo.example-title') !!}</x-heading.component-big>
			<p class="mt-4 text-center text-xl">{{ __('problem-gruppo.example-intro') }}</p>

			<div class="mt-20 grid grid-cols-1 gap-20">

				{{-- Esploratore --}}
				@include('tests.problemi.esempio-problem_esploratore')

				{{-- Stratega --}}
				@include('tests.problemi.esempio-problem_stratega')

				{{-- Critico --}}
				@include('tests.problemi.esempio-problem_critico')

				{{-- Saggio --}}
				@include('tests.problemi.esempio-problem_saggio')
			</div>
		</section>

		<div class="mt-8 flex w-full">
			<x-test.button
				:$test
				class="w-full"
			/>
		</div>
	</div>
</x-layouts.test>
