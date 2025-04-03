<?php

// elements
$f_comp['logo'] = false;
$f_comp['contacts'] = true;

// links
$f_columns = [
	[
		'title' => __('Explore'),
		'links' => [
			['Home', client_url('/')],
			['Supporto', client_url('/help')],
		]
	],
	[
		'title' => __('Legal Information'),
		'links' => [
			['C.F. 96023310228'],
		]
	],
	[
		'title' => __('Useful Links'),
		'links' => [
			['Indire', 'http://www.indire.it'],
			['Invalsi', 'http://www.invalsi.it'],
			['Miur', 'http://www.miur.gov.it'],
			['Pat', 'http://www.provincia.tn.it'],
			['Vivoscuola', 'http://www.vivoscuola.it/'],
		]
	],
];

// contacts
$f_contacts = ['inst', 'fb', 'mail'];
