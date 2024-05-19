<?php

// login student
\Legacy\System\Classes\LegacyRoute::add(['/login'], function () {
	\Legacy\System\Classes\LegacyView::setPage('access/login')
		->setMiddlewares(['not-logged'])
		->setTitle('Accesso')
		->show();
});

// logout
\Legacy\System\Classes\LegacyRoute::add('/logout', function () {
	\Legacy\System\Classes\LegacyView::setPage('access/logout')
		->setTemplate('form')
		->setMiddlewares(['logged'])
		->setTitle('Logout')
		->show();
});

// register success
\Legacy\System\Classes\LegacyRoute::add('/register/success', function () {
	\Legacy\System\Classes\LegacyView::setPage('access/register-success')
		->setMiddlewares(['public', 'logged'])
		->setTitle('Successo')
		->show();
});

// wait
\Legacy\System\Classes\LegacyRoute::add('/wait', function () {
	if (user()->status) redirect_old('/');

	\Legacy\System\Classes\LegacyView::setPage('access/wait')
		->setMiddlewares(['public', 'logged'])
		->setTitle('Attendi')
		->show();
});

// offline
\Legacy\System\Classes\LegacyRoute::add('/offline', function () {
	\Legacy\System\Classes\LegacyView::setPage('errors/offline')
		->setTemplate('void')
		->setMiddlewares([])
		->setTitle('Offline')
		->show();
});

// maintenance page
\Legacy\System\Classes\LegacyRoute::add('/maintenance', function () {
	\Legacy\System\Classes\LegacyView::setPage('errors/maintenance')
		->setTitle('Mantenimento')
		->setTemplate('void')
		->setMiddlewares([])
		->show();
});

// recover
\Legacy\System\Classes\LegacyRoute::add('/recover', function () {
	\Legacy\System\Classes\LegacyView::setPage('access/recover')
		->setTitle('Recupera i dati di accesso')
		->setTemplate('form')
		->setMiddlewares(['not-logged'])
		->show();
});

// reset
\Legacy\System\Classes\LegacyRoute::add('/reset', function () {
	$userId = $_GET['id'] ?? false;
	$security = $_GET['security'] ?? false;

	if (!\Legacy\System\Classes\LegacyDB::exists('user_resets WHERE userId=? AND security=?', [$userId, $security])) redirect_old('/recover');

	\Legacy\System\Classes\LegacyView::setPage('access/reset')
		->setTitle('Reimposta la password')
		->setTemplate('form')
		->setMiddlewares(['not-logged'])
		->show();
});

// Add email
\Legacy\System\Classes\LegacyRoute::add('/add-email', function () {
	if (user()->email) {
		redirect_old('/');
	}

	\Legacy\System\Classes\LegacyView::setPage('access/add-email')
		->setTemplate('form')
		->setMiddlewares(['public', 'logged'])
		->setTitle('Aggiungi il tuo indirizzo e-mail')
		->show();
});
