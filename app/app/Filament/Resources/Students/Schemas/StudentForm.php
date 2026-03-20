<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Models\Schools\SchoolClass;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class StudentForm {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Select::make('schoolClassId')
                    ->label('Classe')
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => SchoolClass::where('name', 'like', "%{$search}%")
                        ->orWhereHas('school', fn($query) => $query->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('referent', fn($query) => $query->whereHas('user', fn($query) => $query->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%")))
                        ->limit(50)
                        ->with('school', 'referent.user')
                        ->get()
                        ->mapWithKeys(fn(SchoolClass $schoolClass): array => [$schoolClass->id => ($schoolClass->ended ? 'x' : '') . " {$schoolClass->name} ({$schoolClass->referent?->user?->first_name} {$schoolClass->referent?->user?->last_name}) - {$schoolClass->school?->name}"])
                        ->toArray())

                    ->getOptionLabelUsing(function ($value): ?string {
                        $schoolClass = SchoolClass::with('school', 'referent.user')->find($value);

                        if (!$schoolClass) {
                            return null;
                        }
                        return "{$schoolClass->name} ({$schoolClass->referent?->user?->first_name} {$schoolClass->referent?->user?->last_name}) - {$schoolClass->school->name}";
                    })
                    ->placeholder('Seleziona una classe'),
            ]);
    }
}
