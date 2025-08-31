<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UsersTable {
	public static function configure(Table $table): Table {
		return $table
			->defaultSort('id', 'desc')
			->columns([
				TextColumn::make('id')
					->searchable()
					->sortable()
					->numeric()
					->label('ID'),
				TextColumn::make('first_name')
					->searchable()
					->sortable()
					->label('Nome'),
				TextColumn::make('last_name')
					->searchable()
					->sortable()
					->label('Cognome'),
				TextColumn::make('created_at')
					->searchable()
					->sortable()
					->dateTime('d/m/Y H:i')
					->label('Registrato il'),
			])
			->filters([
				TrashedFilter::make(),
			])
			->recordActions([
				EditAction::make(),
				Action::make('login')
					->icon(Heroicon::OutlinedArrowRightEndOnRectangle)
					->color('warning')
					->action(function (User $record) {
						Auth::login($record);

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
