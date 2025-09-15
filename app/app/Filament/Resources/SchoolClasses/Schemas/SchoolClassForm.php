<?php

namespace App\Filament\Resources\SchoolClasses\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Schemas\Schema;

class SchoolClassForm {
	public static function configure(Schema $schema): Schema {
		return $schema
			->components([
				Checkbox::make('ended')
					->label('Ha terminato il percorso')
					->default(true)
					->columnSpanFull(),
			]);
	}
}
