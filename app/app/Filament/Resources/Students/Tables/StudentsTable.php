<?php

namespace App\Filament\Resources\Students\Tables;

use App\Models\User\Student;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class StudentsTable {
	public static function configure(Table $table): Table {
		return $table
			->defaultSort('id', 'desc')
			->columns([
				TextColumn::make('id')
					->label('ID')
					->numeric()
					->searchable()
					->sortable(),
				TextColumn::make('user.first_name')
					->label('Nome')
					->searchable()
					->sortable(),
				TextColumn::make('user.last_name')
					->label('Cognome')
					->searchable()
					->sortable(),
				TextColumn::make('school_class.school.name')
					->label('Scuola')
					->wrap()
					->searchable()
					->sortable(),
				TextColumn::make('school_class.name')
					->label('Classe')
					->searchable()
					->sortable(),
				TextColumn::make('created_at')
					->label('Registrato/a il')
					->date()
					->sortable(),
			])
			->filters([
				TrashedFilter::make(),
			])
			->recordActions([
				// EditAction::make(),
				DeleteAction::make(),
				Action::make('login')
					->icon(Heroicon::OutlinedArrowRightEndOnRectangle)
					->color('warning')
					->action(function (Student $record) {
						$user = $record->user;

						Auth::login($user);

						return redirect()->route('home');
					}),
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
