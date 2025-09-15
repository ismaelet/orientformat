<?php

namespace App\Filament\Resources\SchoolClasses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
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
				$query->with(['school', 'referent.user', 'teachers.user'])
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
				TextColumn::make('teachers.full_name')
					->label('Docenti')
					->listWithLineBreaks()
					->state(fn($record) => $record->teachers->map(fn($teacher) => $teacher->full_name)),
			])
			->searchable(['referent.user.first_name', 'referent.user.last_name', 'teachers.user.first_name', 'teachers.user.last_name', 'school.name', 'name', 'code'])
			->filters([
				TrashedFilter::make(),
			])
			->recordActions([
				EditAction::make(),
				DeleteAction::make(),
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
