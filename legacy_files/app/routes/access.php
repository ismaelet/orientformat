<?php

// login student
RouteOld::add(['/login'], function () {
	ViewOld::setPage('access/login')
		->setMiddlewares(['not-logged'])
		->setTitle('Accesso')
		->show();
});

// logout
RouteOld::add('/logout', function () {
	ViewOld::setPage('access/logout')
		->setTemplate('form')
		->setMiddlewares(['logged'])
		->setTitle('Logout')
		->show();
});

// register success
RouteOld::add('/register/success', function () {
	ViewOld::setPage('access/register-success')
		->setMiddlewares(['public', 'logged'])
		->setTitle('Successo')
		->show();
});

// wait
RouteOld::add('/wait', function () {
	if (user()->status) redirect_old('/');

	ViewOld::setPage('access/wait')
		->setMiddlewares(['public', 'logged'])
		->setTitle('Attendi')
		->show();
});

// offline
RouteOld::add('/offline', function () {
	ViewOld::setPage('errors/offline')
		->setTemplate('void')
		->setMiddlewares([])
		->setTitle('Offline')
		->show();
});

// maintenance page
RouteOld::add('/maintenance', function () {
	ViewOld::setPage('errors/maintenance')
		->setTitle('Mantenimento')
		->setTemplate('void')
		->setMiddlewares([])
		->show();
});

// recover
RouteOld::add('/recover', function () {
	ViewOld::setPage('access/recover')
		->setTitle('Recupera i dati di accesso')
		->setTemplate('form')
		->setMiddlewares(['not-logged'])
		->show();
});

// reset
RouteOld::add('/reset', function () {
	$userId = $_GET['id'] ?? false;
	$security = $_GET['security'] ?? false;

	if (!\System\Classes\DBOld::exists('user_resets WHERE userId=? AND security=?', [$userId, $security])) redirect_old('/recover');

	ViewOld::setPage('access/reset')
		->setTitle('Reimposta la password')
		->setTemplate('form')
		->setMiddlewares(['not-logged'])
		->show();
});

// Add email
RouteOld::add('/add-email', function () {
	if (user()->email) {
		redirect_old('/');
	}

	ViewOld::setPage('access/add-email')
		->setTemplate('form')
		->setMiddlewares(['public', 'logged'])
		->setTitle('Aggiungi il tuo indirizzo e-mail')
		->show();
});
