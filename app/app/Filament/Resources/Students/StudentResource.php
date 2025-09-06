<?php

namespace App\Filament\Resources\Students;

use App\Filament\Resources\Students\Pages\CreateStudent;
use App\Filament\Resources\Students\Pages\EditStudent;
use App\Filament\Resources\Students\Pages\ListStudents;
use App\Filament\Resources\Students\Schemas\StudentForm;
use App\Filament\Resources\Students\Tables\StudentsTable;
use App\Models\User\Student;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class StudentResource extends Resource {

	/**
	 * Property: The model class to be used for the resource
	 */
	protected static ?string $model = Student::class;

	/**
	 * Property: The icon to be used for the navigation item
	 */
	protected static string|BackedEnum|null $navigationIcon = 'icon-students';

	/**
	 * Property: The label of a singular resource
	 */
	protected static ?string $label = 'Studente';

	/**
	 * Property: The label of a plural resource
	 */
	protected static ?string $pluralLabel = 'Studenti';

	/**
	 * Property: The title attribute of a record
	 */
	protected static ?string $recordTitleAttribute = 'user.full_name';

	/**
	 * Property: The group the resource should be displayed in the navigation
	 */
	protected static string|UnitEnum|null $navigationGroup = 'Utenti';

	/**
	 * Property: The order the resource should be displayed in the navigation
	 */
	protected static ?int $navigationSort = 2;

	public static function form(Schema $schema): Schema {
		return StudentForm::configure($schema);
	}

	public static function table(Table $table): Table {
		return StudentsTable::configure($table);
	}

	public static function getRelations(): array {
		return [
			//
		];
	}

	public static function getPages(): array {
		return [
			'index' => ListStudents::route('/'),
			'create' => CreateStudent::route('/create'),
			'edit' => EditStudent::route('/{record}/edit'),
		];
	}

	public static function getRecordRouteBindingEloquentQuery(): Builder {
		return parent::getRecordRouteBindingEloquentQuery()
			->withoutGlobalScopes([
				SoftDeletingScope::class,
			]);
	}
}
