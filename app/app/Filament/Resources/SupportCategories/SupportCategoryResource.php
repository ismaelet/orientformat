<?php

namespace App\Filament\Resources\SupportCategories;

use App\Filament\Resources\SupportCategories\Pages\CreateSupportCategory;
use App\Filament\Resources\SupportCategories\Pages\EditSupportCategory;
use App\Filament\Resources\SupportCategories\Pages\ListSupportCategories;
use App\Filament\Resources\SupportCategories\Schemas\SupportCategoryForm;
use App\Filament\Resources\SupportCategories\Tables\SupportCategoriesTable;
use App\Models\Support\SupportCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SupportCategoryResource extends Resource {

	/**
	 * Property: The model class to be used for the resource
	 */
	protected static ?string $model = SupportCategory::class;

	/**
	 * Property: The icon to be used for the navigation item
	 */
	protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

	/**
	 * Property: The label of a singular resource
	 */
	protected static ?string $label = 'Categoria';

	/**
	 * Property: The label of a plural resource
	 */
	protected static ?string $pluralLabel = 'Categorie';

	/**
	 * Property: The title attribute of a record
	 */
	protected static ?string $recordTitleAttribute = 'name';

	/**
	 * Property: The group the resource should be displayed in the navigation
	 */
	protected static string|UnitEnum|null $navigationGroup = 'Supporto';

	public static function form(Schema $schema): Schema {
		return SupportCategoryForm::configure($schema);
	}

	public static function table(Table $table): Table {
		return SupportCategoriesTable::configure($table);
	}

	public static function getRelations(): array {
		return [
			//
		];
	}

	public static function getPages(): array {
		return [
			'index' => ListSupportCategories::route('/'),
			'create' => CreateSupportCategory::route('/create'),
			'edit' => EditSupportCategory::route('/{record}/edit'),
		];
	}
}
