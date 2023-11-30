<?php

// content
$footer['columns'] = [
	[
		'title' => 'Informazioni',
		'links' => [
			['Home', html_link('')],
			['Spedizioni e ritiro', html_link('')],
			['Nota legale', html_link('')],
			['Chi siamo', html_link('')],
			['Pagamento sicuro', html_link('')],
			['Privacy policy', html_link('')],
			['FAQ', html_link('')],
		],
	],
	[
		'title' => 'Il mio profilo',
		'links' => [
			['Il mio profilo', html_link('')],
			['I miei buoni', html_link('')],
			['Wishlist', html_link('')],
		],
	],
	[
		'title' => 'Riferimenti',
		'links' => [
			['Loc. Giare 14/a<br>38050, Imèr (TN)', 'https://www.google.com/maps/place/Via+delle+Giare,+14,+38050+Mezzano+TN/data=!4m2!3m1!1s0x4778f7272e560bf1:0xec41345a156c12af?sa=X&ved=2ahUKEwjH5veTsPb3AhXfR7gEHf-GACYQ8gF6BAgVEAE', true],
			[sysConfig('cont-call'), sysConfig('cont-call-link')],
			[sysConfig('cont-mail'), sysConfig('cont-mail-link')],
		],
	],
];
