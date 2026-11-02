<?php

namespace App\Livewire\Masterpieces;

use App\Models\Masterpiece;
use App\Models\User\Student;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table as FilamentTable;
use Livewire\Component;

class Table extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    /**
     * Property: The student whose masterpieces are being displayed
     */
    public Student $student;

    /**
     * Filament method: Define the table
     */
    public function table(FilamentTable $table): FilamentTable
    {
        return $table
            ->query(Masterpiece::query()
                ->where('student_id', $this->student->id))
            ->columns([
                TextColumn::make('title')
                    ->label('Titolo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('setting')
                    ->label('Ambito')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => Masterpiece::SETTINGS[$state] ?? $state)
                    ->sortable(),
                TextColumn::make('mode')
                    ->label('Modalità')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => Masterpiece::MODES[$state] ?? $state)
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tipologia')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => Masterpiece::TYPES[$state] ?? $state)
                    ->sortable(),
                TextColumn::make('skill')
                    ->label('Competenze sviluppate')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => Masterpiece::SKILLS[$state] ?? $state)
                    ->wrap()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Data di inserimento')
                    ->date()
                    ->sortable(),
            ])
            ->searchable(['title', 'setting', 'mode', 'type', 'skill'])
            ->filters([])
            ->recordActions([
                Action::make('download')
                    ->label('Scarica PDF')
                    ->color(Color::Green)
                    ->size(Size::Small)
                    ->url(fn (Masterpiece $record) => $record->url())
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([]);
    }

    /**
     * Lifecycle method: Render the component
     */
    public function render()
    {
        return view('livewire.masterpieces.table');
    }
}
