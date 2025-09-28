<?php

namespace App\Filament\Resources\Sections\Schemas;

use App\Models\Activities\Area;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
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
				Select::make('areaId')
					->label('Area')
					->placeholder('Seleziona l\'area')
					->options(function () {
						return Area::pluck('name', 'id')->toArray();
					})
					->required(),
				Select::make('evaluation_test_id')
					->label('Test di valutazione')
					->placeholder('Seleziona il test di valutazione')
					->visibleOn('edit')
					->options(function ($record) {
						return $record->tests()->pluck('title', 'id')->toArray();
					}),
				TextInput::make('result_label')
					->label('Descrizione del risultato')
					->placeholder('Inserisci la descrizione del risultato'),
				Checkbox::make('isStandard')
					->label('Sezione standard')
					->helperText('Indica se questa sezione è una sezione standard che gli studenti devono completare per superare l\'anno')
					->default(true)
					->columnSpanFull(),
			]);
	}
}
