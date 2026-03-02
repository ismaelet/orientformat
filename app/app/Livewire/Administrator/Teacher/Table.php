<?php

namespace App\Livewire\Administrator\Teacher;

use App\Models\Schools\School;
use App\Models\User\Teacher;
use Dom\Text;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\EditAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
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
     * Property: The school being managed
     */
    public School $school;

    /**
     * Filament method: Define the table
     */
    public function table(FilamentTable $table): FilamentTable {
        return $table
            ->defaultSort('id', 'desc')
            ->query(Teacher::query()
                ->where('school_id', $this->school->id)
                ->with('user', 'school_classes'))
            ->columns([
                TextColumn::make('user.last_name')
                    ->label('Cognome')
                    ->sortable(),
                TextColumn::make('user.first_name')
                    ->label('Nome')
                    ->sortable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->sortable(),
                TextColumn::make('school_classes.name')
                    ->label('Classi assegnate')
                    ->state(fn($record) => $record->school_classes->map(fn($class) => $class->fullName()))
                    ->listWithLineBreaks()
                    ->default('Nessuna'),
                TextColumn::make('user.created_at')
                    ->label('Registrato/a il')
                    ->date()
                    ->sortable(),
            ])
            ->searchable(['user.first_name', 'user.last_name'])
            ->filters([])
            ->recordActions([
                Action::make('detach-from-school')
                    ->label('Rimuovi dall\'Istituto')
                    ->color('danger')
                    ->icon(Heroicon::XMark)
                    ->action(fn(Teacher $record) => $record->update(['school_id' => null]))
                    ->requiresConfirmation()
                    ->modalHeading('Rimuovi dall\'Istituto')
                    ->modalDescription('Questa operazione è da usare in caso il/la docente non sia più parte dell\'istituto. Non eliminerà l\'account, ma lo/a dissocerà dalla scuola.')
                    ->modalSubmitActionLabel('Sì, rimuovi'),
            ])
            ->toolbarActions([]);
    }

    /**
     * Lifecycle method: Render the component
     */
    public function render() {
        return view('livewire.administrator.teacher.table');
    }
}
