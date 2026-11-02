<?php

namespace App\Filament\Resources\Tests\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->reorderable('step')
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
                TextColumn::make('step')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->label('Ordine'),
                IconColumn::make('active')
                    ->boolean()
                    ->label('Attiva')
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->searchable(['title', 'section.name', 'section.slug', 'slug', 'step'])
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
