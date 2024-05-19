@php
	use App\Models\Results\User\TestResult;

	$months = ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'];
	$activities = [];
	$years = [date('Y') - 1, date('Y')];

	foreach ($years as $key => $year) {
	    $yearlyActivities = [];

	    $monthlyActivities = TestResult::selectRaw('MONTH(time) as month, COUNT(*) as count')
	        ->whereYear('time', $year)
	        ->groupBy('month')
	        ->orderBy('month')
	        ->get();

	    foreach ($months as $key => $month) {
	        $yearlyActivities[] = $monthlyActivities->where('month', $key + 1)->first()->count ?? 0;
	    }

	    $activities[] = $yearlyActivities;
	}
@endphp

@push('scripts')
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('scripts')
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
			const lastYearActivities = @json($activities[0]);
			const currentYearActivities = @json($activities[1]);

			var ctx = document.getElementById('activities-graph').getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: months,
					datasets: [{
						label: {{ $years[0] }},
						backgroundColor: lastYearColor,
						data: lastYearActivities,
						tension: 0.1,
					}, {
						label: {{ $years[1] }},
						backgroundColor: currentYearColor,
						data: currentYearActivities,
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
@endpush

<x-dashboard.widget
	title="Attività svolte"
	subtitle="divise per mese"
	class="col-span-7"
	variant="big"
>

	<x-slot name="content">
		<canvas id="activities-graph"></canvas>
	</x-slot>

</x-dashboard.widget>
