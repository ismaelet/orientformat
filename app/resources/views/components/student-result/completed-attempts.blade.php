@props(['attempts'])

@if ($attempts)
	<small>{{ $attempts === 1 ? '(svolta 1 volta)' : "(svolta {$attempts} volte)" }}</small>
@endif
