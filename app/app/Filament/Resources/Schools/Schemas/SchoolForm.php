<?php

namespace App\Filament\Resources\Schools\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SchoolForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->placeholder('Inserisci il nome della scuola')
                    ->required(),
                Checkbox::make('has_high_school')
                    ->label('Scuola superiore'),
            ]);
    }
}
