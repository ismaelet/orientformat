<?php

// homepage
Route::add(['/', '/index.php', ''], function () {
	switch (ActiveUser::getInstance()->groupId) {
		case 1:
			$page = 'teacher/home';
			$middlewares = ['public', 'teacher', 'required-email'];
			break;
		case 2:
			redirect('/admin');
		default:
			add_grade_style();

			$page = 'home';
			$middlewares = ['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'];
			break;
	}

	View::setPage($page)
		->setMiddlewares($middlewares)
		->show();
});

// support
Route::add(['/tutorial', '/help'], function () {
	View::setPage('support')
		->setTitle('Supporto')
		->show();
});
