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
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
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
                Action::make('resetPassword')
                    ->label('Reimposta password')
                    ->color(Color::Red)
                    ->icon('icon-key_vertical')
                    ->action(function (User $record) {
                        $newPassword = strtolower(str()->random(8));
                        $record->password = Hash::make($newPassword);
                        $record->save();

                        Notification::make()
                            ->title('Password generata')
                            ->body('La nuova password per '.$record->inverted_full_name.' è (cliccala per copiarla):<br><span class="font-bold text-blue-600 js-password transition-colors block mt-2 text-lg text-center cursor-pointer underline data-[copied=true]:text-primary-400">'.$newPassword.'</span>')
                            ->info()
                            ->iconColor(Color::Blue)
                            ->duration(20000)
                            ->send();
                    })
                    ->size(Size::Small)
                    ->requiresConfirmation()
                    ->modalHeading('Reimpostare la password?')
                    ->modalDescription('La nuova password verrà mostrata una sola volta, assicurati di annotarla.'),
                EditAction::make(),
                Action::make('login')
                    ->icon(Heroicon::OutlinedArrowRightEndOnRectangle)
                    ->color('warning')
                    ->action(function (User $record) {
                        Auth::login($record);

                        return redirect()->route('home');
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
