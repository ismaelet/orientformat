@props(['title', 'body', 'footer', 'method' => null, 'action' => null, 'size' => 'default'])

<x-layouts.main :$title>
	<x-form
		:$title
		:$body
		:$footer
		:$action
		:$method
		:$size
	/>
</x-layouts.main>
