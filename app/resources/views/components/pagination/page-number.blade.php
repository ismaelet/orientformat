@props(['page', 'currentPage'])

<x-pagination.page
	:page="$page"
	:currentPage="$currentPage"
>
	{{ $page }}
</x-pagination.page>
