<?php

namespace App\Filament\Resources\Schools\Tables;

use App\Filament\Exports\SchoolExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchoolsTable {
    public static function configure(Table $table): Table {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('has_high_school')
                    ->label('Scuola Superiore')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('classes_count')
                    ->label('# Classi')
                    ->counts('classes')
                    ->sortable(),
                TextColumn::make('teachers_count')
                    ->label('# Insegnanti')
                    ->counts('teachers')
                    ->sortable(),
                TextColumn::make('students_count')
                    ->label('# Studenti')
                    ->counts('students')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(SchoolExporter::class)
                    ->columnMappingColumns(2)
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
