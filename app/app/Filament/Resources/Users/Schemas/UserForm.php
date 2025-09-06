<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm {
	public static function configure(Schema $schema): Schema {
		return $schema
			->components([
				TextInput::make('email')
					->label('Email')
					->required()
					->suffixIcon('heroicon-o-envelope')
					->maxLength(255),
			]);
	}
}
