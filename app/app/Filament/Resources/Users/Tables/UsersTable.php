<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->modifyQueryUsing(fn ($query) => $query->with(['student', 'teacher', 'administrator']))
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
                TextColumn::make('category')
                    ->label('Categoria')
                    ->badge()
                    ->getStateUsing(fn ($record): string => $record->categoryLabel()),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('Email'),
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
