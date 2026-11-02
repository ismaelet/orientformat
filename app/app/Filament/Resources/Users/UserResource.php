<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class UserResource extends Resource
{
    /**
     * Property: The model class to be used for the resource
     */
    protected static ?string $model = User::class;

    /**
     * Property: The icon to be used for the navigation item
     */
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    /**
     * Property: The label of a singular resource
     */
    protected static ?string $label = 'Utente';

    /**
     * Property: The label of a plural resource
     */
    protected static ?string $pluralLabel = 'Utenti';

    /**
     * Property: The title attribute of a record
     */
    protected static ?string $recordTitleAttribute = 'full_name';

    /**
     * Property: The group the resource should be displayed in the navigation
     */
    protected static string|UnitEnum|null $navigationGroup = 'Utenti';

    /**
     * Property: The order the resource should be displayed in the navigation
     */
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
