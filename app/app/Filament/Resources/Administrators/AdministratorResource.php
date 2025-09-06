<?php

namespace App\Filament\Resources\Administrators;

use App\Filament\Resources\Administrators\Pages\CreateAdministrator;
use App\Filament\Resources\Administrators\Pages\EditAdministrator;
use App\Filament\Resources\Administrators\Pages\ListAdministrators;
use App\Filament\Resources\Administrators\Schemas\AdministratorForm;
use App\Filament\Resources\Administrators\Tables\AdministratorsTable;
use App\Models\User\Administrator;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AdministratorResource extends Resource {

	/**
	 * Property: The model class to be used for the resource
	 */
	protected static ?string $model = Administrator::class;

	/**
	 * Property: The icon to be used for the navigation item
	 */
	protected static string|BackedEnum|null $navigationIcon = 'icon-admin';

	/**
	 * Property: The label of a singular resource
	 */
	protected static ?string $label = 'Amministratore';

	/**
	 * Property: The label of a plural resource
	 */
	protected static ?string $pluralLabel = 'Amministratori';

	/**
	 * Property: The title attribute of a record
	 */
	protected static ?string $recordTitleAttribute = 'user.full_name';

	/**
	 * Property: The group the resource should be displayed in the navigation
	 */
	protected static string|UnitEnum|null $navigationGroup = 'Utenti';

	public static function form(Schema $schema): Schema {
		return AdministratorForm::configure($schema);
	}

	public static function table(Table $table): Table {
		return AdministratorsTable::configure($table);
	}

	public static function getRelations(): array {
		return [
			//
		];
	}

	public static function getPages(): array {
		return [
			'index' => ListAdministrators::route('/'),
			'create' => CreateAdministrator::route('/create'),
			'edit' => EditAdministrator::route('/{record}/edit'),
		];
	}
}
