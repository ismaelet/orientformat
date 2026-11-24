<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Email')
                    ->disabled(fn (string $operation): bool => $operation === 'edit' && ! is_admin())
                    ->required()
                    ->suffixIcon('heroicon-o-envelope')
                    ->maxLength(255),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->visible(fn (): bool => is_admin())
                    ->afterStateHydrated(fn (TextInput $component) => $component->state(null))
                    ->minLength(8)
                    ->maxLength(30)
                    ->helperText('Lascia vuoto per mantenere la password attuale.')
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => is_admin() && filled($state)),
            ]);
    }
}
