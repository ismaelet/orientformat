<?php

namespace App\Filament\Resources\Notifications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NotificationsTable {
	public static function configure(Table $table): Table {
		return $table
			->defaultSort('id', 'desc')
			->columns([
				TextColumn::make('id')
					->searchable()
					->sortable()
					->numeric()
					->label('ID'),
				TextColumn::make('text')
					->searchable()
					->wrap()
					->html()
					->label('Testo'),
				TextColumn::make('created_at')
					->sortable()
					->label('Data'),
			])
			->filters([
				//
			])
			->recordActions([
				EditAction::make(),
				DeleteAction::make(),
			])
			->toolbarActions([
				BulkActionGroup::make([
					DeleteBulkAction::make(),
				]),
			]);
	}
}
