@props(['title'])

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>{{ $title }}</title>

	<style>
		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
		}

		ul {
			list-style: none;
			padding-left: 0;
			margin: 0;
		}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6,
		p,
		li {
			font-family: Helvetica, sans-serif !important;
		}

		h1 {
			font-size: 2.25rem;
			line-height: 2.5rem;
		}

		h2 {
			font-size: 1.875rem;
			line-height: 2.25rem;
		}

		h3 {
			font-size: 1.5rem;
			line-height: 2rem;
		}

		h4 {
			font-size: 1.125rem;
			line-height: 1.5rem;
		}

		table {
			table-layout: fixed;
			border-collapse: collapse;
			width: 768px;
		}

		html {
			font-size: 12px;
		}

		.items-center {
			align-items: center;
		}

		.w-full {
			width: 100%;
		}

		.max-w-\[960px\] {
			max-width: 960px;
		}

		.py-4 {
			padding-top: 1rem;
			padding-bottom: 1rem;
		}

		.px-4 {
			padding-left: 1rem;
			padding-right: 1rem;
		}

		.p-4 {
			padding: 1rem;
		}

		.pb-4 {
			padding-bottom: 1rem;
		}

		.pt-4 {
			padding-top: 1rem;
		}

		.pt-8 {
			padding-top: 2rem;
		}

		.pt-12 {
			padding-top: 3rem;
		}

		.pl-4 {
			padding-left: 1rem;
		}

		.last\:pb-0:last-child {
			padding-bottom: 0;
		}

		.mx-auto {
			margin-left: auto;
			margin-right: auto;
		}

		.mt-4 {
			margin-top: 1rem;
		}

		.mb-4 {
			margin-bottom: 1rem;
		}

		.mb-20 {
			margin-bottom: 5rem;
		}

		.border {
			border-width: 1px;
			border-style: solid;
		}

		.border-t {
			border-top-width: 1px;
			border-top-style: solid;
		}

		.border-neutral-200 {
			border-color: #E5E7EB;
		}

		.rounded {
			border-radius: 0.5rem;
		}

		.text-center {
			text-align: center;
		}

		.text-lg {
			font-size: 1.125rem;
			line-height: 1.75rem;
			font-weight: 700;
		}

		.text-xl {
			font-size: 1.25rem;
			line-height: 1.75rem;
			font-weight: 700;
		}

		.text-2xl {
			font-size: 1.5rem;
			line-height: 2rem;
			font-weight: 700;
		}

		.text-4xl {
			font-size: 2.25rem;
			line-height: 2.5rem;
			font-weight: 700;
		}

		.font-medium {
			font-weight: 500;
		}

		.font-semibold {
			font-weight: 600;
		}
	</style>
</head>

<body>
	{{ $slot }}
</body>

</html>
