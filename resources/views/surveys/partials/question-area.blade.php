@php
	$letter = chr($areaKey + 65);
@endphp

<div class="question-area grid grid-cols-1 gap-8">
	<div class="text-center">
		<x-typography.component-heading>
			{{ $letter }}. {{ $questionArea['title'] }}
		</x-typography.component-heading>
	</div>

	<div class="questions surface grid grid-cols-1 gap-8 p-6">
		@foreach ($questionArea['questions'] as $questionKey => $question)
			<div class="questio grid grid-cols-1 gap-4">
				<p class="text-lg font-medium"><span class="font-bold">{{ $letter . '.' . ($questionKey + 1) }}</span>
					{{ $question['text'] }}</p>

				@include('surveys.partials.question-' . $question['type'], [
					'question' => $question,
					'questionKey' => $questionKey,
				])
			</div>
		@endforeach
	</div>
</div>
