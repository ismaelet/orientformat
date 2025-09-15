<?php

namespace App\Filament\Resources\Sections\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GradesRelationManager extends RelationManager {
	protected static string $relationship = 'grades';

	public function form(Schema $schema): Schema {
		return $schema
			->components([]);
	}

	public function table(Table $table): Table {
		return $table
			->recordTitleAttribute('absolute_number')
			->recordTitle(fn($record) => $record->full_name)
			->defaultSort('absolute_number', 'asc')
			->columns([
				TextColumn::make('full_name')
					->label('Anno'),
			])
			->filters([
				//
			])
			->headerActions([
				AttachAction::make(),
			])
			->recordActions([
				EditAction::make(),
				DetachAction::make(),
				DeleteAction::make(),
			])
			->toolbarActions([
				BulkActionGroup::make([
					DetachBulkAction::make(),
					DeleteBulkAction::make(),
				]),
			]);
	}
}
