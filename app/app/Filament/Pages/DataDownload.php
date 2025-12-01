<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class DataDownload extends Page {

    /**
     * The icon of the resource
     */
    protected static string | \BackedEnum | null $navigationIcon = Heroicon::ArrowDownTray;

    /**
     * The group in which the resource's navigation item will be displayed
     */
    protected static string | \UnitEnum | null $navigationGroup = 'Altro';

    /**
     * The title of the page
     */
    protected static ?string $title = 'Scarica Dati';

    protected string $view = 'filament.pages.data-download';
}
