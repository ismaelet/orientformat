<?php

namespace App\Filament\Resources\Sections;

use App\Filament\Resources\Sections\Pages\CreateSection;
use App\Filament\Resources\Sections\Pages\EditSection;
use App\Filament\Resources\Sections\Pages\ListSections;
use App\Filament\Resources\Sections\Schemas\SectionForm;
use App\Filament\Resources\Sections\Tables\SectionsTable;
use App\Models\Activities\Section;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SectionResource extends Resource {

	/**
	 * Property: The model class to be used for the resource
	 */
	protected static ?string $model = Section::class;

	/**
	 * Property: The icon to be used for the navigation item
	 */
	protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

	/**
	 * Property: The label of a singular resource
	 */
	protected static ?string $label = 'Sezione';

	/**
	 * Property: The label of a plural resource
	 */
	protected static ?string $pluralLabel = 'Sezioni';

	public static function form(Schema $schema): Schema {
		return SectionForm::configure($schema);
	}

	public static function table(Table $table): Table {
		return SectionsTable::configure($table);
	}

	public static function getRelations(): array {
		return [
			//
		];
	}

	public static function getPages(): array {
		return [
			'index' => ListSections::route('/'),
			'create' => CreateSection::route('/create'),
			'edit' => EditSection::route('/{record}/edit'),
		];
	}

	public static function getRecordRouteBindingEloquentQuery(): Builder {
		return parent::getRecordRouteBindingEloquentQuery()
			->withoutGlobalScopes([
				SoftDeletingScope::class,
			]);
	}
}
