<?php

// homepage
RouteOld::add(['', '/', '/index.php', '/home'], function () {

	if (admin()) {
		redirect_old('/admin');
	} else if (isTeacher()) {
		$page = 'teacher/home';
		$middlewares = ['public', 'teacher', 'required-email'];
	} else if (isStudent()) {
		add_grade_style();

		$page = 'home';
		$middlewares = ['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'];
	}

	ViewOld::setPage($page)
		->setMiddlewares($middlewares)
		->show();
});

// support
RouteOld::add(['/tutorial', '/help'], function () {
	ViewOld::setPage('support')
		->setTitle('Supporto')
		->show();
});
