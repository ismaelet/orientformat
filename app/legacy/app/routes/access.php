<?php

// wait
\App\Legacy\LegacyRoute::add('/wait', function () {
    if (user()->status) redirect_old('/');

    return \App\Legacy\LegacyView::setPage('access/wait')
        ->setMiddlewares(['public', 'logged'])
        ->setTitle('Attendi')
        ->show();
});

// Add email
\App\Legacy\LegacyRoute::add('/add-email', function () {
    if (user()->email) {
        redirect_old('/');
    }

    return \App\Legacy\LegacyView::setPage('access/add-email')
        ->setTemplate('form')
        ->setMiddlewares(['public', 'logged'])
        ->setTitle('Aggiungi il tuo indirizzo e-mail')
        ->show();
});
