<!DOCTYPE html>
<html lang="it">

<head>
	<meta charset="UTF-8">

	<style>
		@page {
			margin: 40px 75px;
		}

		body {
			font-family: DejaVu Sans, sans-serif;
			font-size: 16px;
		}

		.title {
			margin-bottom: 75px;
			font-size: 32px;
			font-weight: bold;
			text-align: center;
		}

		.student {
			font-size: 22px;
			font-weight: normal;
			font-style: italic;
		}

		.question {
			margin-bottom: 20px;
			page-break-inside: avoid;
		}
	</style>
</head>

<body>
	<div class="title">
		Risposte - {{ $test->name }}

		@if ($showStudentName)
			<div class="student">
				{{ $student->inverted_full_name }}
			</div>
		@endif
	</div>

	@foreach ($questions as $index => $question)
		<p class="question">
			<strong>{{ $index + 1 }}.</strong>
			{{ $question['text'] }}

			<br>

			<strong>Risposta:</strong>
			<i>{{ $question['answer'] }}</i>
		</p>
	@endforeach
</body>

</html>
