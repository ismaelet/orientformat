@php
	use App\Models\User\Teacher;

	$newUsersCount = Teacher::where('created_at', '>=', now()->subYear())->where('created_at', '<=', now())->count();
	$oldUsersCount = Teacher::where('created_at', '>=', now()->subYear()->subYear())
	    ->where('created_at', '<', now()->subYear())
	    ->count();

	$difference = $newUsersCount - $oldUsersCount;
	$differencePercentage = $oldUsersCount > 0 ? ($difference / $oldUsersCount) * 100 : 0;
	$formattedDifferencePercentage = number_format($differencePercentage, 2, ',', '.');
@endphp

<x-dashboard.widget
	title="Nuovi Docenti"
	subtitle="negli ultimi 365 giorni"
	icon="teachers"
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
