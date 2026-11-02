<?php

namespace App\Filament\Resources\Teachers;

use App\Filament\Resources\Teachers\Pages\CreateTeacher;
use App\Filament\Resources\Teachers\Pages\EditTeacher;
use App\Filament\Resources\Teachers\Pages\ListTeachers;
use App\Filament\Resources\Teachers\Schemas\TeacherForm;
use App\Filament\Resources\Teachers\Tables\TeachersTable;
use App\Models\User\Teacher;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TeacherResource extends Resource
{
    /**
     * Property: The model class to be used for the resource
     */
    protected static ?string $model = Teacher::class;

    /**
     * Property: The icon to be used for the navigation item
     */
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    /**
     * Property: The label of a singular resource
     */
    protected static ?string $label = 'Docente';

    /**
     * Property: The label of a plural resource
     */
    protected static ?string $pluralLabel = 'Docenti';

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
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return TeacherForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeachersTable::configure($table);
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
            'index' => ListTeachers::route('/'),
            'create' => CreateTeacher::route('/create'),
            'edit' => EditTeacher::route('/{record}/edit'),
        ];
    }
}
