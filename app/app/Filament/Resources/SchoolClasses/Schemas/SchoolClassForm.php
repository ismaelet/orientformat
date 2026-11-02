<?php

namespace App\Filament\Resources\SchoolClasses\Schemas;

use App\Models\User;
use App\Models\User\Teacher;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SchoolClassForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome della classe')
                    ->required()
                    ->readonly()
                    ->maxLength(255),

                Select::make('schoolId')
                    ->label('Istituto')
                    ->required()
                    ->relationship('school', 'name')
                    ->searchable(),

                Select::make('referentId')
                    ->label('Docente tutor')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search): array => Teacher::whereHas('user', fn ($query) => $query->where('full_name', 'like', "%{$search}%")
                        ->orWhere('inverted_full_name', 'like', "%{$search}%")
                        ->orWhere('email', $search))
                        ->limit(50)
                        ->with('user')
                        ->get()
                        ->mapWithKeys(fn (Teacher $teacher): array => [$teacher->id => $teacher->full_name.' ('.$teacher->user->email.')'])
                        ->toArray())
                    ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->full_name ?? null),

                TextInput::make('code')
                    ->label('Codice classe')
                    ->required()
                    ->readOnly()
                    ->maxLength(255),

                Checkbox::make('ended')
                    ->label('Ha terminato il percorso')
                    ->default(true)
                    ->columnSpanFull(),
            ]);
    }
}
