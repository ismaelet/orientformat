<?php

namespace App\Livewire\Tests\Capolavori;

use App\Helpers\FileHelper;
use App\Models\Masterpiece;
use Faker\Core\File;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Icon;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Table extends Component implements HasTable, HasActions, HasSchemas {

    use InteractsWithTable;
    use InteractsWithSchemas;
    use InteractsWithActions;

    /**
     * Property: Count of masterpieces
     */
    public $masterpieceCount = 0;

    /**
     * Lifecycle hook: Mount the component
     */
    public function mount() {
        $this->masterpieceCount = student()->masterpieces()->count();
    }

    /**
     * Lifecycle hook: Render the component view
     */
    public function render() {
        return view('livewire.tests.capolavori.table');
    }

    public function table(FilamentTable $table): FilamentTable {
        return $table
            ->defaultSort('id', 'asc')
            ->paginated(false)
            ->query(fn() => student()->masterpieces())
            ->columns([
                TextColumn::make('title')
                    ->label('Titolo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Data di caricamento')
                    ->date('d/m/Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Modifica')
                    ->modalHeading(fn($record) => "Modifica il capolavoro: {$record->title}")
                    ->color('info')
                    ->schema([
                        Select::make('setting')
                            ->label('Nato in ambito')
                            ->options(Masterpiece::SETTINGS),
                        Select::make('mode')
                            ->label('In modalità')
                            ->options(Masterpiece::MODES),
                        Select::make('type')
                            ->label('Tipologia di attività')
                            ->options(Masterpiece::TYPES),
                        Select::make('skill')
                            ->label('Competenza sviluppata')
                            ->options(Masterpiece::SKILLS),
                    ]),
                DeleteAction::make()
                    ->label('Elimina')
                    ->modalHeading(fn(Masterpiece $record): string => "Elimina il capolavoro: {$record->title}")
                    ->color('danger')
                    ->after(function (Masterpiece $record) {
                        FileHelper::delete($record->storageFilePath());

                        $this->masterpieceCount = student()->masterpieces()->count();

                        $this->dispatch('masterpieceDeleted');
                    }),
                Action::make('download')
                    ->label('Scarica PDF')
                    ->action(function (Masterpiece $record): BinaryFileResponse {
                        $title = str_replace(['/', '\\'], '-', $record->title);

                        return FileHelper::download($record->storageFilePath(), "{$title}.pdf");
                    })
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray'),
            ]);
    }
}
