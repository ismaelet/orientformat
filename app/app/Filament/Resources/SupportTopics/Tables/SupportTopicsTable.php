<?php

namespace App\Filament\Resources\SupportTopics\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SupportTopicsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->defaultPaginationPageOption(25)
            ->reorderable('sort')
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->numeric()
                    ->label('ID'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->wrap()
                    ->label('Domanda'),
                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->label('Categoria'),
                TextColumn::make('text')
                    ->label('Risposta')
                    ->searchable()
                    ->wrap()
                    ->limit(150),
            ])
            ->filters([
                SelectFilter::make('categoryId')
                    ->label('Categoria')
                    ->relationship('category', 'name'),
            ], layout: FiltersLayout::AboveContent)
            ->deferFilters(false)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
