<?php

namespace App\Livewire\Administrator\Class;

use App\Models\Schools\School;
use App\Models\Schools\SchoolClass;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\FusedGroup;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Colors\Color;
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
	 * Property: The school being managed
	 */
	public School $school;

	/**
	 * Filament method: Define the table
	 */
	public function table(FilamentTable $table): FilamentTable {
		return $table
			->defaultSort('created_at', 'desc')
			->query(SchoolClass::query()
				->where('schoolId', $this->school->id)
				->with('referent.user'))
			->columns([
				TextColumn::make('name')
					->label('Nome')
					->sortable(['letter', 'grade']),
				TextColumn::make('referent.inverted_full_name')
					->label('Referente'),
				TextColumn::make('students_count')
					->label('Studenti iscritti')
					->counts('students')
					->sortable(),
				TextColumn::make('code')
					->label('Codice identificativo')
					->icon('heroicon-o-clipboard-document-list')
					->iconPosition('after')
					->iconColor(Color::Gray)
					->weight('semibold')
					->copyable()
					->searchable()
					->sortable(),
				IconColumn::make('ended')
					->label('Ha terminato il percorso')
					->boolean()
					->sortable(),
				TextColumn::make('created_at')
					->label('Registrata il')
					->date()
					->sortable(),
			])
			->searchable(['referent.user.first_name', 'referent.user.last_name'])
			->filters([])
			->recordActions([
				Action::make('openDashboard')
					->label('Apri dashboard')
					->url(fn(SchoolClass $record): string => route('class.show', ['class' => $record]))
					->icon('heroicon-o-arrow-top-right-on-square')
					->color(Color::Blue)
					->openUrlInNewTab()
			])
			->toolbarActions([
				Action::make('createClass')
					->label('Aggiungi una classe')
					->outlined()
					->icon('heroicon-o-plus')
					->color(Color::Blue)
					->action(function (array $data, array $arguments): void {
						$response = SchoolClass::createFromData(array_merge($data, [
							'schoolId' => $this->school->id,
						]));

						Notification::make()
							->title('Classe creata con successo.')
							->success()
							->send();
					})
					->schema([
						FusedGroup::make([
							Select::make('grade')
								->label('Anno')
								->options($this->school->has_high_school ? [
									'4' => '1',
									'5' => '2',
									'6' => '3',
									'7' => '4',
									'8' => '5',
								] : [
									'1' => '1',
									'2' => '2',
									'3' => '3',
								])
								->required()
								->searchable()
								->placeholder('Seleziona l\'anno'),
							TextInput::make('letter')
								->label(fn(): string => $this->school->has_high_school ? 'Nome' : 'Lettera identificativa')
								->placeholder('Inserisci la lettera identificativa')
								->autocapitalize()
								->required(),
						])->columns(2)
							->belowContent(fn(): string => $this->school->has_high_school ? 'Il nome della classe, è ad es. "3BS", "L1B" o "A4F". Nonostante il nome della classe contiene l\'anno di corso, è importante selezionare anche l\'anno, per motivi tecnici.' : 'La lettera che identifica la classe, è, per esempio, la lettera è "B", se la classe è una "3B", oppure "A" se la classe è una "2A" etc.')
							->label('Nominativo della classe'),

						Select::make('professional')
							->label('Tipologia di indirizzo')
							->required()
							->visible(fn(): bool => $this->school->has_high_school)
							->options([
								0 => 'Istituto Tecnico, Professionale o Liceo',
								1 => 'Istituto di Istruzione e Formazione Professionale',
							])
					])
			]);
	}

	/**
	 * Lifecycle method: Render the component
	 */
	public function render() {
		return view('livewire.administrator.class.table');
	}
}
