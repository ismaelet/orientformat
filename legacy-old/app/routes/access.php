<?php

// login student
Route::add(['/login'], function () {
	View::setPage('access/login')
		->setMiddlewares(['not-logged'])
		->setTitle('Accesso')
		->show();
});

// logout
Route::add('/logout', function () {
	View::setPage('access/logout')
		->setTemplate('form')
		->setMiddlewares(['logged'])
		->setTitle('Logout')
		->show();
});

// register success
Route::add('/register/success', function () {
	View::setPage('access/register-success')
		->setMiddlewares(['public', 'logged'])
		->setTitle('Successo')
		->show();
});

// wait
Route::add('/wait', function () {
	if (user()->status) redirect('/');

	View::setPage('access/wait')
		->setMiddlewares(['public', 'logged'])
		->setTitle('Attendi')
		->show();
});

// offline
Route::add('/offline', function () {
	View::setPage('errors/offline')
		->setTemplate('void')
		->setMiddlewares([])
		->setTitle('Offline')
		->show();
});

// maintenance page
Route::add('/maintenance', function () {
	View::setPage('errors/maintenance')
		->setTitle('Mantenimento')
		->setTemplate('void')
		->setMiddlewares([])
		->show();
});

// recover
Route::add('/recover', function () {
	View::setPage('access/recover')
		->setTitle('Recupera i dati di accesso')
		->setTemplate('form')
		->setMiddlewares(['not-logged'])
		->show();
});

// reset
Route::add('/reset', function () {
	$userId = $_GET['id'] ?? false;
	$security = $_GET['security'] ?? false;

	if (!DB::exists('user_resets WHERE userId=? AND security=?', [$userId, $security])) redirect('/recover');

	View::setPage('access/reset')
		->setTitle('Reimposta la password')
		->setTemplate('form')
		->setMiddlewares(['not-logged'])
		->show();
});

// Add email
Route::add('/add-email', function () {
	if (user()->email) {
		redirect('/');
	}

	View::setPage('access/add-email')
		->setTemplate('form')
		->setMiddlewares(['public', 'logged'])
		->setTitle('Aggiungi il tuo indirizzo e-mail')
		->show();
});
