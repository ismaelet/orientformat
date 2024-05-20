<?php

// login student
\App\Legacy\LegacyRoute::add(['/login'], function () {
	\App\Legacy\LegacyView::setPage('access/login')
		->setMiddlewares(['not-logged'])
		->setTitle('Accesso')
		->show();
});

// logout
\App\Legacy\LegacyRoute::add('/logout', function () {
	\App\Legacy\LegacyView::setPage('access/logout')
		->setTemplate('form')
		->setMiddlewares(['logged'])
		->setTitle('Logout')
		->show();
});

// register success
\App\Legacy\LegacyRoute::add('/register/success', function () {
	\App\Legacy\LegacyView::setPage('access/register-success')
		->setMiddlewares(['public', 'logged'])
		->setTitle('Successo')
		->show();
});

// wait
\App\Legacy\LegacyRoute::add('/wait', function () {
	if (user()->status) redirect_old('/');

	\App\Legacy\LegacyView::setPage('access/wait')
		->setMiddlewares(['public', 'logged'])
		->setTitle('Attendi')
		->show();
});

// recover
\App\Legacy\LegacyRoute::add('/recover', function () {
	\App\Legacy\LegacyView::setPage('access/recover')
		->setTitle('Recupera i dati di accesso')
		->setTemplate('form')
		->setMiddlewares(['not-logged'])
		->show();
});

// reset
\App\Legacy\LegacyRoute::add('/reset', function () {
	$userId = $_GET['id'] ?? false;
	$security = $_GET['security'] ?? false;

	if (!\App\Legacy\LegacyDB::exists('user_resets WHERE userId=? AND security=?', [$userId, $security])) redirect_old('/recover');

	\App\Legacy\LegacyView::setPage('access/reset')
		->setTitle('Reimposta la password')
		->setTemplate('form')
		->setMiddlewares(['not-logged'])
		->show();
});

// Add email
\App\Legacy\LegacyRoute::add('/add-email', function () {
	if (user()->email) {
		redirect_old('/');
	}

	\App\Legacy\LegacyView::setPage('access/add-email')
		->setTemplate('form')
		->setMiddlewares(['public', 'logged'])
		->setTitle('Aggiungi il tuo indirizzo e-mail')
		->show();
});
