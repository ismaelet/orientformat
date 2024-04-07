<?php

// home
Route::add('/', function () {
	View::getInstance()->setPage('home')
		->setTemplate('admin')
		->addMiddlewares(['admin'])
		->show();
});
