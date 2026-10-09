<?php

namespace App\Filament\Resources\Administrators\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class AdministratorForm {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Fieldset::make('user')
                    ->columnSpanFull()
                    ->label('Dati Utente')
                    ->relationship('user')
                    ->visibleOn('edit')
                    ->schema([
                        TextInput::make('first_name')
                            ->label('Nome')
                            ->required()
                            ->suffixIcon('heroicon-o-user')
                            ->maxLength(255),
                        TextInput::make('last_name')
                            ->label('Cognome')
                            ->required()
                            ->suffixIcon('heroicon-o-user')
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->required()
                            ->suffixIcon('heroicon-o-envelope')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

                Fieldset::make('user')
                    ->columnSpanFull()
                    ->label('Dati referente')
                    ->schema([
                        Select::make('user_id')
                            ->label('Docente')
                            ->required()
                            ->searchable()
                            ->searchDebounce(350)
                            ->placeholder('Cerca per nome, cognome o email')
                            ->suffixIcon('heroicon-o-user-circle')
                            ->visibleOn('create')
                            ->columnSpanFull()
                            ->getSearchResultsUsing(function (string $search): array {
                                $terms = preg_split('/\s+/', trim($search));

                                if (strlen(trim($search)) < 2) {
                                    return [];
                                }

                                return User::query()
                                    ->select(['id', 'first_name', 'last_name', 'email'])
                                    ->whereHas('teacher')
                                    ->whereDoesntHave('administrator')
                                    ->whereNotNull('email')
                                    ->where('email', '!=', '')
                                    ->where(function (Builder $query) use ($terms) {
                                        foreach ($terms as $term) {
                                            $query->where(function (Builder $query) use ($term) {
                                                $query
                                                    ->where('email', 'like', "%{$term}%")
                                                    ->orWhere('first_name', 'like', "%{$term}%")
                                                    ->orWhere('last_name', 'like', "%{$term}%");
                                            });
                                        }
                                    })
                                    ->limit(20)
                                    ->get()
                                    ->mapWithKeys(fn(User $user) => [
                                        $user->id => "{$user->last_name} {$user->first_name} ({$user->email})",
                                    ])
                                    ->all();
                            })
                            ->getOptionLabelUsing(function ($value): ?string {
                                $user = User::find($value);

                                return $user
                                    ? "{$user->last_name} {$user->first_name} ({$user->email})"
                                    : null;
                            }),

                        Select::make('school_id')
                            ->label('Scuola')
                            ->required()
                            ->preload()
                            ->relationship('school', 'name')
                            ->searchable()
                            ->placeholder('Seleziona una scuola')
                            ->suffixIcon('heroicon-o-academic-cap')
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
