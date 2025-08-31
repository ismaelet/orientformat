<?php

namespace App\Filament\Resources\SchoolClasses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SchoolClassesTable {
	public static function configure(Table $table): Table {
		return $table
			->modifyQueryUsing(
				fn($query) =>
				$query->with(['school', 'referent.user'])
			)
			->defaultSort('id', 'desc')
			->columns([
				TextColumn::make('id')
					->searchable()
					->sortable()
					->numeric()
					->label('ID'),
				TextColumn::make('name')
					->sortable(['grade', 'letter'])
					->label('Nome'),
				TextColumn::make('school.name')
					->searchable()
					->wrap()
					->sortable()
					->label('Scuola'),
				TextColumn::make('referent.full_name')
					->sortable(['referent.first_name', 'referent.last_name'])
					->label('Referente'),
			])
			->searchable(['referent.user.first_name', 'referent.user.last_name'])
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
