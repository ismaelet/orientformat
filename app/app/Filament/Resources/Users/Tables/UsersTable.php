<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->modifyQueryUsing(fn ($query) => $query->with(['student', 'teacher', 'administrator']))
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->numeric()
                    ->label('ID'),
                TextColumn::make('first_name')
                    ->searchable()
                    ->sortable()
                    ->label('Nome'),
                TextColumn::make('last_name')
                    ->searchable()
                    ->sortable()
                    ->label('Cognome'),
                TextColumn::make('category')
                    ->label('Categoria')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Admin' => 'danger',
                        'Referente' => 'warning',
                        'Docente' => 'info',
                        'Studente' => 'success',
                        default => 'gray',
                    })
                    ->getStateUsing(fn ($record): string => $record->categoryLabel()),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('Email'),
                TextColumn::make('created_at')
                    ->searchable()
                    ->sortable()
                    ->dateTime('d/m/Y H:i')
                    ->label('Registrato il'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('resetPassword')
                    ->label('Reimposta password')
                    ->color(Color::Purple)
                    ->icon(Heroicon::Key)
                    ->authorize(fn (): bool => is_admin())
                    ->requiresConfirmation()
                    ->modalHeading('Reimpostare la password?')
                    ->modalDescription('La nuova password verrà mostrata una sola volta, assicurati di annotarla.')
                    ->action(function (User $record): void {
                        $newPassword = Str::lower(Str::password(12, symbols: false));
                        DB::transaction(function () use ($record, $newPassword): void {
                            $record->forceFill([
                                'password' => Hash::make($newPassword),
                                'remember_token' => Str::random(60),
                            ])->save();

                            /** @var PasswordBroker $broker */
                            $broker = Password::broker();
                            $broker->deleteToken($record);
                        });

                        Notification::make()
                            ->title('Password generata')
                            ->body('La nuova password per '.e($record->inverted_full_name).' è: <strong>'.e($newPassword).'</strong>')
                            ->info()
                            ->iconColor(Color::Blue)
                            ->duration(20000)
                            ->send();
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
