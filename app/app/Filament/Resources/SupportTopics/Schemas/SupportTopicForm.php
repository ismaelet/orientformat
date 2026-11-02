<?php

namespace App\Filament\Resources\SupportTopics\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SupportTopicForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Domanda')
                    ->required()
                    ->maxLength(255),
                Select::make('categoryId')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->required(),
                Textarea::make('text')
                    ->label('Risposta')
                    ->required()
                    ->autosize()
                    ->columnSpanFull(),
            ]);
    }
}
