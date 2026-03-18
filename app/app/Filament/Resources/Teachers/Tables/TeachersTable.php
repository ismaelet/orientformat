<?php

namespace App\Filament\Resources\Teachers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeachersTable {
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
                TextColumn::make('school.name')
                    ->label('Scuola')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('school_classes.name')
                    ->label('Classi assegnate')
                    ->state(fn($record) => $record->school_classes->map(fn($class) => $class->fullName()))
                    ->listWithLineBreaks()
                    ->default('Nessuna'),
                TextColumn::make('created_at')
                    ->label('Registrato/a il')
                    ->date()
                    ->sortable(),
            ])
            ->searchable(['id', 'user.first_name', 'user.last_name', 'user.email', 'school.name'])
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
