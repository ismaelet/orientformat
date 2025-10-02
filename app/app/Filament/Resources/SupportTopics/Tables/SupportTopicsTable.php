<?php

namespace App\Filament\Resources\SupportTopics\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SupportTopicsTable {
	public static function configure(Table $table): Table {
		return $table
			->defaultSort('id', 'desc')
			->columns([
				TextColumn::make('id')
					->searchable()
					->sortable()
					->numeric()
					->label('ID'),
				TextColumn::make('name')
					->searchable()
					->sortable()
					->wrap()
					->label('Domanda'),
				TextColumn::make('category.name')
					->searchable()
					->sortable()
					->label('Categoria'),
				TextColumn::make('text')
					->label('Risposta')
					->wrap()
					->limit(150),
			])
			->filters([
				//
			])
			->recordActions([
				EditAction::make(),
			])
			->toolbarActions([
				BulkActionGroup::make([
					DeleteBulkAction::make(),
				]),
			]);
	}
}
