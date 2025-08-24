<?php

namespace App\Filament\Resources\Sections\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SectionForm {
	public static function configure(Schema $schema): Schema {
		return $schema
			->components([
				TextInput::make('name')
					->label('Nome')
					->placeholder('Inserisci il nome')
					->required(),
				TextInput::make('slug')
					->label('Slug')
					->placeholder('Inserisci lo slug')
					->required(),
				Textarea::make('description')
					->label('Descrizione')
					->placeholder('Inserisci la descrizione')
					->rows(5)
					->required(),
				Select::make('evaluation_test_id')
					->label('Test di valutazione')
					->placeholder('Seleziona il test di valutazione')
					->options(function ($record) {
						return $record->tests()->pluck('title', 'id')->toArray();
					}),
			]);
	}
}
