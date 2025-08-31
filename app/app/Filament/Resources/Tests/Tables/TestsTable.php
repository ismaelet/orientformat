<?php

namespace App\Filament\Resources\Tests\Tables;

use App\Models\Activities\Test;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TestsTable {
	public static function configure(Table $table): Table {
		return $table
			->defaultSort('id', 'desc')
			->columns([
				TextColumn::make('id')
					->searchable()
					->sortable()
					->numeric()
					->label('ID'),
				TextColumn::make('title')
					->searchable()
					->sortable()
					->label('Nome'),
				TextColumn::make('section.name')
					->searchable()
					->sortable()
					->label('Sezione'),
				TextColumn::make('slug')
					->searchable()
					->sortable()
					->label('Slug'),
			])
			->filters([
				TrashedFilter::make(),
			])
			->recordActions([
				EditAction::make(),
			])
			->toolbarActions([
				BulkActionGroup::make([
					DeleteBulkAction::make(),
					ForceDeleteBulkAction::make(),
					RestoreBulkAction::make(),
				]),
			]);
	}
}
