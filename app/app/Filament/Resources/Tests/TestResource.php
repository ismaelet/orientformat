<?php

namespace App\Filament\Resources\Tests;

use App\Filament\Resources\Tests\Pages\CreateTest;
use App\Filament\Resources\Tests\Pages\EditTest;
use App\Filament\Resources\Tests\Pages\ListTests;
use App\Filament\Resources\Tests\Schemas\TestForm;
use App\Filament\Resources\Tests\Tables\TestsTable;
use App\Models\Activities\Test;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestResource extends Resource {

	/**
	 * Property: The model class to be used for the resource
	 */
	protected static ?string $model = Test::class;

	/**
	 * Property: The icon to be used for the navigation item
	 */
	protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

	/**
	 * Property: The label of a singular resource
	 */
	protected static ?string $label = 'Attività';

	/**
	 * Property: The label of a plural resource
	 */
	protected static ?string $pluralLabel = 'Attività';

	/**
	 * Property: The title attribute of a record
	 */
	protected static ?string $recordTitleAttribute = 'title';

	public static function form(Schema $schema): Schema {
		return TestForm::configure($schema);
	}

	public static function table(Table $table): Table {
		return TestsTable::configure($table);
	}

	public static function getRelations(): array {
		return [
			//
		];
	}

	public static function getPages(): array {
		return [
			'index' => ListTests::route('/'),
			'create' => CreateTest::route('/create'),
			'edit' => EditTest::route('/{record}/edit'),
		];
	}

	public static function getRecordRouteBindingEloquentQuery(): Builder {
		return parent::getRecordRouteBindingEloquentQuery()
			->withoutGlobalScopes([
				SoftDeletingScope::class,
			]);
	}
}
