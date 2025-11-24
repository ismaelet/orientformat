<?php

namespace App\Filament\Resources\SchoolClasses\Tables;

use App\Filament\Exports\SchoolClassExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
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
                    ->label('Tutor'),
                TextColumn::make('teachers.full_name')
                    ->label('Docenti')
                    ->listWithLineBreaks()
                    ->state(fn($record) => $record->teachers->map(fn($teacher) => $teacher->full_name)),
                IconColumn::make('ended')
                    ->label('Percorso terminato')
                    ->boolean(),
            ])
            ->searchable(['referent.user.first_name', 'referent.user.last_name', 'teachers.user.first_name', 'teachers.user.last_name', 'school.name', 'name', 'code'])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(SchoolClassExporter::class)
                    ->columnMappingColumns(2)
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
