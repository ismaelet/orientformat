<?php

namespace App\Livewire\Administrator\Student;

use App\Models\Schools\School;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use App\Models\User\Student;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Table extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    /**
     * Property: The school being managed
     */
    public ?School $school = null;

    /**
     * Property: The class being managed (if any)
     */
    public ?SchoolClass $class = null;

    /**
     * Property: Whether to display placeholders for testing
     */
    public bool $displayPlaceholders = false;

    /**
     * Lifecycle method: Initialize component
     */
    public function mount()
    {
        if ($this->class) {
            $this->school = $this->class->school;
        }

        $this->displayPlaceholders = display_placeholders();
    }

    /**
     * Filament method: Define the table
     */
    public function table(FilamentTable $table): FilamentTable
    {
        return $table
            ->defaultSort('id', 'desc')
            ->defaultPaginationPageOption(25)
            ->query(fn () => $this->class ?
                // Class view
                Student::query()
                    ->where('schoolClassId', $this->class->id)
                    ->with('user', 'class', 'school_class.referent.user') :

                // School view
                Student::query()
                    ->whereHas('school_class', function ($query) {
                        $query->where('schoolId', $this->school->id);
                    })
                    ->with('user', 'class', 'school_class.referent.user'))
            ->columns([
                TextColumn::make('user.last_name')
                    ->label('Cognome')
                    ->searchable()
                    ->getStateUsing(fn (Student $record) => $this->displayPlaceholders ? 'Cognome test' : $record->user->last_name)
                    ->sortable(),
                TextColumn::make('user.first_name')
                    ->label('Nome')
                    ->searchable()
                    ->getStateUsing(fn (Student $record) => $this->displayPlaceholders ? 'Nome test' : $record->user->first_name)
                    ->sortable(),
                TextColumn::make('school_class.name')
                    ->label('Classe')
                    ->searchable()
                    ->getStateUsing(fn (Student $record) => $this->displayPlaceholders ? 'Classe test' : $record->school_class?->name)
                    ->sortable(),
                TextColumn::make('school_class.referent.inverted_full_name')
                    ->label('Tutor di classe')
                    ->visible(fn (): bool => ! $this->class),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->getStateUsing(fn (Student $record) => $this->displayPlaceholders ? 'studente.test@iprase.tn.it' : $record->user->email)
                    ->sortable(),
                TextColumn::make('user.created_at')
                    ->label('Registrato/a il')
                    ->date()
                    ->sortable(),
            ])
            ->searchable($this->class ? ['user.last_name', 'user.first_name', 'user.email'] : ['user.last_name', 'user.first_name', 'user.email', 'school_class.name', 'school_class.referent.user.first_name', 'school_class.referent.user.last_name'])
            ->filters([])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->label('Modifica')
                        ->color(Color::Blue)
                        ->modalHeading(fn (Student $record): string => "Modifica: {$record->user->inverted_full_name}")
                        ->schema([
                            Fieldset::make('Dati personali')
                                ->columns(2)
                                ->relationship('user')
                                ->schema([
                                    TextInput::make('first_name')
                                        ->required()
                                        ->label('Nome')
                                        ->maxLength(255),
                                    TextInput::make('last_name')
                                        ->required()
                                        ->label('Cognome')
                                        ->maxLength(255),
                                    TextInput::make('email')
                                        ->required()
                                        ->email()
                                        ->label('Email')
                                        ->maxLength(255)
                                        ->unique(
                                            table: User::class,
                                            column: 'email',
                                            ignoreRecord: true,
                                        )
                                        ->validationMessages([
                                            'unique' => 'Questo indirizzo email è già utilizzato da un altro utente.',
                                        ]),
                                ]),
                            Select::make('classId')
                                ->label('Classe')
                                ->preload()
                                ->helperText('Puoi assegnare lo/a studente/ssa ad una classe diversa, per esempio in caso di studenti ripetenti o che hanno cambiato classe rispetto all\'anno scorso. ATTENZIONE: Cambiare la classe di uno/a studente/ssa lo/a rimuoverà dalla classe attuale.')
                                ->relationship(
                                    name: 'school_class',
                                    modifyQueryUsing: fn ($query) => $query
                                        ->where('schoolId', $this->school->id)
                                        ->where('ended', false)
                                        ->with('referent.user')
                                        ->orderBy('name'),
                                )
                                ->getOptionLabelFromRecordUsing(fn (SchoolClass $record) => "{$record->name} - {$record->referent?->inverted_full_name}")
                                ->getOptionLabelUsing(
                                    fn ($value): ?string => optional(
                                        SchoolClass::with('referent.user')->find($value)
                                    )?->name.' - '.optional(
                                        SchoolClass::with('referent.user')->find($value)?->referent
                                    )?->inverted_full_name
                                )
                                ->searchable()
                                ->required(),
                        ]),
                    Action::make('view-results')
                        ->label('Visualizza risultati')
                        ->color(Color::Cyan)
                        ->icon(Heroicon::ArrowTopRightOnSquare)
                        ->url(fn (Student $record) => route('class.students.results.show', ['class' => $record->class, 'student' => $record]))
                        ->openUrlInNewTab(),
                    Action::make('view-poi')
                        ->label('Visualizza POI')
                        ->color(Color::Green)
                        ->icon(Heroicon::ArrowTopRightOnSquare)
                        ->url(fn (Student $record) => route('class.students.poi.show', ['class' => $record->class, 'student' => $record]))
                        ->openUrlInNewTab(),
                    Action::make('view-self-evaluations')
                        ->label('Visualizza autovalutazioni')
                        ->color(Color::Orange)
                        ->icon(Heroicon::ArrowTopRightOnSquare)
                        ->url(fn (Student $record) => route('class.students.self-evaluations.show', ['class' => $record->class, 'student' => $record]))
                        ->openUrlInNewTab(),
                    Action::make('resetPassword')
                        ->label('Reimposta password')
                        ->color(Color::Purple)
                        ->icon('icon-key_vertical')
                        ->action(function (Student $record) {
                            $newPassword = strtolower(str()->random(8));
                            $record->user->password = Hash::make($newPassword);
                            $record->user->save();

                            Notification::make()
                                ->title('Password generata')
                                ->body('La nuova password per '.$record->user->inverted_full_name.' è (cliccala per copiarla):<br><span class="font-bold text-blue-600 js-password transition-colors block mt-2 text-lg text-center cursor-pointer underline data-[copied=true]:text-primary-400">'.$newPassword.'</span>')
                                ->info()
                                ->iconColor(Color::Blue)
                                ->duration(20000)
                                ->send();
                        })
                        ->size(Size::Small)
                        ->requiresConfirmation()
                        ->modalHeading('Reimpostare la password?')
                        ->modalDescription('La nuova password verrà mostrata una sola volta, assicurati di annotarla.'),
                    Action::make('removeFromClass')
                        ->label('Rimuovi dalla classe')
                        ->color(Color::Red)
                        ->icon(Heroicon::UserMinus)
                        ->action(function (Student $record) {
                            $record->schoolClassId = null;
                            $record->save();

                            Notification::make()
                                ->title('Studente rimosso dalla classe')
                                ->body($record->user->inverted_full_name.' è stato rimosso dalla classe '.$record->school_class?->name.'.')
                                ->info()
                                ->iconColor(Color::Red)
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Rimuovere lo/a studente/ssa dalla classe?')
                        ->modalDescription('Questa azione rimuoverà lo/a studente/ssa dalla classe attuale, ma non eliminerà il suo account né i suoi dati. Questa operazione è da eseguire in caso di studenti che hanno cambiato scuola, NON in caso di studenti ripetenti o che hanno cambiato classe all\'interno della stessa scuola (in quel caso è sufficiente modificare la classe dello/a studente/ssa).'),
                ]),
            ])
            ->toolbarActions([]);
    }

    /**
     * Lifecycle method: Render the component
     */
    public function render()
    {
        return view('livewire.administrator.student.table');
    }
}
