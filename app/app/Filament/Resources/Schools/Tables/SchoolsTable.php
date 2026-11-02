<?php

namespace App\Filament\Resources\Schools\Tables;

use App\Models\Schools\School;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchoolsTable
{
    public static function configure(Table $table): Table
    {
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
                Action::make('download')
                    ->label('Esporta Scuole')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->action(function () {
                        $schools = School::all();

                        $schools->each(function (School &$school) {
                            $school->count_classes = $school->classes()->count();
                            $school->count_teachers = $school->teachers()->count();
                            $school->count_students = $school->students()->count();
                        });

                        $schoolData = $schools->map(function (School $school) {
                            return [
                                'ID' => $school->id,
                                'Nome' => $school->name,
                                'Numero di Classi' => $school->count_classes,
                                'Numero di Insegnanti' => $school->count_teachers,
                                'Numero di Studenti' => $school->count_students,
                            ];
                        })->toArray();

                        $fileName = 'scuole_export_'.now()->format('Y_m_d_H_i_s').'.csv';
                        $path = storage_path('app/'.$fileName);

                        $handle = fopen($path, 'w');
                        fputcsv($handle, ['ID', 'Nome', 'Numero di Classi', 'Numero di Insegnanti', 'Numero di Studenti']);

                        foreach ($schoolData as $row) {
                            fputcsv($handle, $row);
                        }

                        fclose($handle);

                        return response()->download($path)->deleteFileAfterSend(true);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
