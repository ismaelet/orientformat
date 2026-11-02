<?php

namespace App\Filament\Resources\Notifications\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NotificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('text')
                    ->label('Testo')
                    ->placeholder('Inserisci il testo')
                    ->rows(5)
                    ->required()
                    ->columnSpanFull(),
                // TextInput::make('created_at')
                // 	->label('Data')
                // 	->placeholder('YYYY-MM-DD')
                // 	->columnSpanFull(),
            ]);
    }
}
