<?php

namespace App\Livewire\Teachers;

use App\Models\Schools\SchoolClass;
use App\Models\User\Teacher;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table as FilamentTable;
use Livewire\Component;

class Table extends Component implements HasTable, HasActions, HasSchemas {

    use InteractsWithTable;
    use InteractsWithSchemas;
    use InteractsWithActions;

    /**
     * Property: Current user's teacher model
     */
    public Teacher $teacher;

    /**
     * Property: The class being managed
     */
    public SchoolClass $class;

    /**
     * Property: Whether the current user is the referent of the class
     */
    public bool $isReferent = false;

    /**
     * Lifecycle method: Initialize component
     */
    public function mount() {
        $this->isReferent = $this->teacher->id == $this->class->referentId;
    }

    /**
     * Filament method: Define the table
     */
    public function table(FilamentTable $table): FilamentTable {
        return $table
            ->query(Teacher::query()
                ->whereHas('school_classes', function ($query) {
                    $query->where('school_classes.id', $this->class->id);
                })
                ->with('user'))
            ->columns([
                TextColumn::make('user.first_name')
                    ->label('Nome')
                    ->sortable(),
                TextColumn::make('user.last_name')
                    ->label('Cognome')
                    ->sortable(),
                IconColumn::make('is_referent')
                    ->label('Tutor')
                    ->state(fn(Teacher $record): bool => $record->id === $this->class->referentId)
                    ->boolean(),
                TextColumn::make('user.created_at')
                    ->label('Registrato/a il')
                    ->date()
            ])
            ->searchable(['user.first_name', 'user.last_name'])
            ->filters([])
            ->recordActions([
                Action::make('removeFromClass')
                    ->action(function (Teacher $record) {
                        $record->school_classes()->detach($this->class->id);

                        Notification::make()
                            ->title('Docente rimosso/a dalla classe con successo')
                            ->success()
                            ->send();
                    })
                    ->color('danger')
                    ->size(Size::ExtraSmall)
                    ->label('Rimuovi dalla classe')
                    ->requiresConfirmation()
                    ->modalHeading('Rimuovi docente dalla classe')
                    ->modalDescription('Sei sicuro di voler rimuovere questo/a docente dalla classe?')
                    ->visible(fn(Teacher $record): bool => $this->isReferent && $this->teacher->id !== $record->id)
                    ->successRedirectUrl(route('class.teachers.index', ['class' => $this->class->id])),
                Action::make('removeSelfFromClass')
                    ->action(function (Teacher $record) {
                        $this->teacher->school_classes()->detach($this->class->id);
                    })
                    ->color('danger')
                    ->size(Size::ExtraSmall)
                    ->label('Esci dalla classe')
                    ->requiresConfirmation()
                    ->modalHeading('Esci dalla classe')
                    ->modalDescription('Sei sicuro di voler rimuoverti dalla gestione di questa classe? Per riaccedervi dovrai chiedere al tutor di aggiungerti nuovamente.')
                    ->visible(fn(Teacher $record): bool => $this->teacher->id === $record->id)
                    ->disabled(fn(): bool => $this->isReferent)
                    ->successRedirectUrl(route('class.teachers.index', ['class' => $this->class->id])),
                Action::make('makeReferent')
                    ->action(function (Teacher $record) {
                        $this->class->referentId = $record->id;
                        $this->class->save();
                    })
                    ->color(Color::Blue)
                    ->size(Size::ExtraSmall)
                    ->label('Rendi tutor')
                    ->requiresConfirmation()
                    ->modalHeading('Imposta docente come tutor')
                    ->modalDescription('Sei sicuro di voler impostare questo/a docente come tutor della classe? Sarai rimosso/a da questa posizione.')
                    ->visible(fn(Teacher $record): bool => $this->isReferent && $this->teacher->id !== $record->id)
                    ->successRedirectUrl(route('class.teachers.index', ['class' => $this->class->id])),
            ])
            ->toolbarActions([]);
    }

    /**
     * Lifecycle method: Render the component
     */
    public function render() {
        return view('livewire.teachers.table');
    }
}
