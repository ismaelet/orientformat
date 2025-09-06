<?php

namespace App\Filament\Resources\Administrators\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class AdministratorForm {
	public static function configure(Schema $schema): Schema {
		return $schema
			->components([
				Fieldset::make('user')
					->columnSpanFull()
					->label('Dati Utente')
					->relationship('user')
					->schema([
						TextInput::make('first_name')
							->label('Nome')
							->required()
							->suffixIcon('heroicon-o-user')
							->maxLength(255),
						TextInput::make('last_name')
							->label('Cognome')
							->required()
							->suffixIcon('heroicon-o-user')
							->maxLength(255),
						TextInput::make('email')
							->label('Email')
							->required()
							->suffixIcon('heroicon-o-envelope')
							->maxLength(255)
							->columnSpanFull(),
					]),
				Fieldset::make('user')
					->columnSpanFull()
					->label('Dati Amministratore')
					->schema([
						Select::make('school_id')
							->label('Scuola')
							->required()
							->preload()
							->relationship('school', 'name')
							->searchable()
							->placeholder('Seleziona una scuola')
							->suffixIcon('heroicon-o-academic-cap')
							->columnSpanFull(),
					])
			]);
	}
}
