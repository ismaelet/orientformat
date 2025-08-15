<?php

namespace App\Filament\Resources\Tests\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use League\Uri\UriTemplate\Template;

class TestForm {
	public static function configure(Schema $schema): Schema {
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
				Textarea::make('description')
					->label('Descrizione')
					->placeholder('Inserisci la descrizione')
					->rows(5)
					->required(),
				Textarea::make('shortDescription')
					->label('Descrizione breve')
					->placeholder('Inserisci la descrizione breve')
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
					->required()
			]);
	}
}
