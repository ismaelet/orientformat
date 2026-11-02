<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\FixSignedRoutesProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    FixSignedRoutesProvider::class,
];
