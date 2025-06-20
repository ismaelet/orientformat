@php
	use App\Models\User\Student;

	$months = ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'];
	$students = [];
	$years = [date('Y') - 1, date('Y')];

	foreach ($years as $key => $year) {
	    $yearlyStudents = [];

	    $monthlyStudents = Student::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
	        ->whereYear('created_at', $year)
	        ->groupBy('month')
	        ->orderBy('month')
	        ->get();

	    foreach ($months as $key => $month) {
	        $yearlyStudents[] = $monthlyStudents->where('month', $key + 1)->first()->count ?? 0;
	    }

	    $students[] = $yearlyStudents;
	}
@endphp

@pushOnce('scripts')
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endPushOnce

@pushOnce('scripts')
	<script defer>
		document.addEventListener("DOMContentLoaded", function() {

			// Get the styling for the graph
			const colorScheme = document.documentElement.getAttribute('data-color-scheme');

			let lastYearColor =
				`hsl(${getComputedStyle(document.documentElement).getPropertyValue('--color-primary-400-hsl')} / 0.5)`;
			let currentYearColor = getComputedStyle(document.documentElement).getPropertyValue(
				'--color-secondary-400');

			if (colorScheme == 'dark') {
				const themeColor = getComputedStyle(document.documentElement).getPropertyValue('--theme-h');
				const themeSaturation = getComputedStyle(document.documentElement).getPropertyValue('--theme-dark-s');
				const barLightness = parseInt(getComputedStyle(document.documentElement).getPropertyValue(
					'--color-background-l')) + 20;

				lastYearColor = `hsl(${themeColor} ${themeSaturation} ${barLightness}%)`;
				currentYearColor = '#fff';
			}

			// Set the data to be used in the graph
			const months = @json($months);
			const lastYearStudents = @json($students[0]);
			const currentYearStudents = @json($students[1]);
			var ctx = document.getElementById('students-graph').getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: months,
					datasets: [{
						label: {{ $years[0] }},
						backgroundColor: lastYearColor,
						data: lastYearStudents,
						tension: 0.1,
					}, {
						label: {{ $years[1] }},
						backgroundColor: currentYearColor,
						data: currentYearStudents,
						tension: 0.1,
					}]
				},
				options: {
					elements: {
						bar: {
							borderRadius: 5,
						}
					},
					scales: {
						y: {
							beginAtZero: true
						}
					},
					plugins: {
						legend: {
							display: true,
						}
					},
				}
			});
		});
	</script>
@endPushOnce

<x-dashboard.widget
	title="Studenti registrati"
	subtitle="divisi per mese"
	class="col-span-5"
	variant="big"
>

	<x-slot name="content">
		<canvas id="students-graph"></canvas>
	</x-slot>

</x-dashboard.widget>
