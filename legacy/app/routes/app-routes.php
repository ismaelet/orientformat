<?php

// homepage
\Legacy\System\Classes\LegacyRoute::add(['', '/', '/index.php', '/home'], function () {

	if (admin()) {
		redirect_old('/admin');
	} else if (is_teacher()) {
		$page = 'teacher/home';
		$middlewares = ['public', 'teacher', 'required-email'];
	} else if (isStudent()) {
		add_grade_style();

		$page = 'home';
		$middlewares = ['public', 'logged', 'active', 'beginner-review', 'end-review', 'required-email'];
	}

	\Legacy\System\Classes\LegacyView::setPage($page)
		->setMiddlewares($middlewares)
		->show();
});

// support
\Legacy\System\Classes\LegacyRoute::add(['/tutorial', '/help'], function () {
	\Legacy\System\Classes\LegacyView::setPage('support')
		->setTitle('Supporto')
		->show();
});
