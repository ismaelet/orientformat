<?php

use Activity\Test;
use UserSystem\Student;

function print_survey_results($testId, $studentId, $teacherView = false) {
	$test = new Test($testId);
	$survey = $test->survey;
	$result = $test->rawResults;

	if ($teacherView) {
		$student = new Student($studentId);
		$test->title .= '<br><i>' . $student->lastname . ' ' . $student->firstname . '</i>';
	}

	// opening html
	$html = "
		<html>
		<head>
			<meta charset='UTF-8'>
			<style>
				@import url('https://fonts.googleapis.com/css?family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display');

				html {
					
				}

				html {
					margin: 40px 75px;
				}

				p {font-family: 'Open Sans', sans-serif; font-size: 16px;}
									
				.title {
					display: block;
					margin-bottom: 75px;
					font-size: 32px;
					font-weight: 700;
					text-align: center;
				}

				.title i {
					font-weight: 400;
				}

			</style>
		</head>
		<body>

			<p class='title'>Risposte - " . $test->title . "</p>
	";

	// html body
	foreach ($survey->questions as $key => $question) {

		$html .= '
			<p>
				<strong>' . ($key + 1) . '.</strong> ' . $question[0] . '<br>
				<strong>Risposta:</strong> <i>' . $survey->answers[$result[$key]] . '</i>
			</p>
		';
	}

	// closing html
	$html .= "
		</body>
		</HTML>
	";

	// generate pdf
	$dompdf = new Dompdf\Dompdf();

	$dompdf->loadHtml($html);

	$dompdf->setPaper('A4', 'portrait');
	$dompdf->render();
	$dompdf->stream('Risposte_' . str_replace([' ', '<br>'], '_', str_replace(['<i>', '</i>'], '', $test->title)) . '.pdf');
}
