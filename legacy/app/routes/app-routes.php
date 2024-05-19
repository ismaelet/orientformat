<?php

// homepage

use Illuminate\Support\Facades\Auth;

\App\Legacy\LegacyRoute::add(['', '/orientamento', '/', '/index.php', '/home'], function () {

	if (is_admin()) {
		redirect_old(route('admin.dashboard'));
	} else if (is_teacher()) {
		$page = 'teacher/home';
		$middlewares = ['public', 'teacher', 'required-email'];
	} else if (isStudent()) {
		add_grade_style();

		$page = 'home';
		$middlewares = ['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'];
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
