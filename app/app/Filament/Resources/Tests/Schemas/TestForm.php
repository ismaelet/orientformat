<?php

namespace App\Filament\Resources\Tests\Schemas;

use App\Models\Activities\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Titolo')
                    ->placeholder('Inserisci il titolo')
                    ->required(),
                TextInput::make('slug')
                    ->label('Slug')
                    ->placeholder('Inserisci lo slug')
                    ->required(),
                Select::make('sectionId')
                    ->label('Sezione')
                    ->placeholder('Seleziona la sezione')
                    ->relationship('section', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Section $record) => $record->name.' ('.$record->slug.')')
                    ->preload()
                    ->searchable()
                    ->required(),
                Select::make('template')
                    ->label('Template')
                    ->options([
                        'blade' => 'Default',
                        'test' => '[Vecchio] Test',
                        'test-next' => '[Vecchio] Test 2.0',
                        'survey' => '[Vecchio] Questionario',
                        'survey-results' => '[Vecchio] Risultati Questionario',
                    ])
                    ->default('blade')
                    ->required(),
                TextInput::make('step')
                    ->label('Ordine')
                    ->placeholder('Inserisci l\'ordine di visualizzazione')
                    ->numeric(),
                Checkbox::make('reviewResult')
                    ->label('Richiede revisione')
                    ->helperText('Se selezionato, una volta completata l\'attività, la pagina verrà ricaricata per mostrare i risultati.'),
            ]);
    }
}
