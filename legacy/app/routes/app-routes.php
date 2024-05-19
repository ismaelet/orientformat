<?php

// homepage

use Illuminate\Support\Facades\Auth;

\App\Legacy\LegacyRoute::add(['', '/orientamento', 'orientamento/', '/', '/index.php', '/home'], function () {

	if (is_teacher()) {
		$page = 'teacher/home';
		$middlewares = ['public', 'teacher', 'required-email'];
	} else if (isStudent()) {
		add_grade_style();

		$page = 'home';
		$middlewares = ['public', 'logged', 'active', 'beginner-review', 'required-email'];
	}

	\App\Legacy\LegacyView::setPage($page)
		->setMiddlewares($middlewares)
		->show();
});

// support
\App\Legacy\LegacyRoute::add(['/tutorial', '/help'], function () {
	\App\Legacy\LegacyView::setPage('support')
		->setTitle('Supporto')
		->show();
});
