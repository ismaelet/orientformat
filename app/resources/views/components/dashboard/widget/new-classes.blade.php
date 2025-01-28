@php
	use App\Models\Schools\SchoolClass;

	$newUsersCount = SchoolClass::where('time', '>=', now()->subYear())->where('time', '<=', now())->count();
	$oldUsersCount = SchoolClass::where('time', '>=', now()->subYear()->subYear())
	    ->where('time', '<', now()->subYear())
	    ->count();

	$difference = $newUsersCount - $oldUsersCount;
	$differencePercentage = $oldUsersCount > 0 ? ($difference / $oldUsersCount) * 100 : 0;
	$formattedDifferencePercentage = number_format($differencePercentage, 2, ',', '.');
@endphp

<x-dashboard.widget
	title="Nuove Classi"
	subtitle="negli ultimi 365 giorni"
	icon="school-classes"
>

	<x-slot name="value">
		{{ $newUsersCount > 0 ? '+' . $newUsersCount : 0 }}
	</x-slot>

	<x-slot name="footerNotes">
		<span class="{{ $difference >= 0 ? 'text-success' : 'text-error' }}">
			{{ $difference >= 0 ? '+' . $formattedDifferencePercentage : $formattedDifferencePercentage }}%
		</span>

		rispetto all'anno precedente
	</x-slot>

</x-dashboard.widget>
