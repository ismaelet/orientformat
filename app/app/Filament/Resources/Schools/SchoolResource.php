<?php

namespace App\Filament\Resources\Schools;

use App\Filament\Resources\Schools\Pages\CreateSchool;
use App\Filament\Resources\Schools\Pages\EditSchool;
use App\Filament\Resources\Schools\Pages\ListSchools;
use App\Filament\Resources\Schools\Schemas\SchoolForm;
use App\Filament\Resources\Schools\Tables\SchoolsTable;
use App\Models\Schools\School;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SchoolResource extends Resource {

	/**
	 * Property: The model class to be used for the resource
	 */
	protected static ?string $model = School::class;

	/**
	 * Property: The icon to be used for the navigation item
	 */
	protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

	/**
	 * Property: The label of a singular resource
	 */
	protected static ?string $label = 'Scuola';

	/**
	 * Property: The label of a plural resource
	 */
	protected static ?string $pluralLabel = 'Scuole';

	/**
	 * Property: The title attribute of a record
	 */
	protected static ?string $recordTitleAttribute = 'name';

	/**
	 * Property: The group the resource should be displayed in the navigation
	 */
	protected static string|UnitEnum|null $navigationGroup = 'Struttura';

	public static function form(Schema $schema): Schema {
		return SchoolForm::configure($schema);
	}

	public static function table(Table $table): Table {
		return SchoolsTable::configure($table);
	}

	public static function getRelations(): array {
		return [
			//
		];
	}

	public static function getPages(): array {
		return [
			'index' => ListSchools::route('/'),
			'create' => CreateSchool::route('/create'),
			'edit' => EditSchool::route('/{record}/edit'),
		];
	}
}
