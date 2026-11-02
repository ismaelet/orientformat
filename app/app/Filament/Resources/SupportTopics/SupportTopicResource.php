<?php

namespace App\Filament\Resources\SupportTopics;

use App\Filament\Resources\SupportTopics\Pages\CreateSupportTopic;
use App\Filament\Resources\SupportTopics\Pages\EditSupportTopic;
use App\Filament\Resources\SupportTopics\Pages\ListSupportTopics;
use App\Filament\Resources\SupportTopics\Schemas\SupportTopicForm;
use App\Filament\Resources\SupportTopics\Tables\SupportTopicsTable;
use App\Models\Support\SupportTopic;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SupportTopicResource extends Resource
{
    /**
     * Property: The model class to be used for the resource
     */
    protected static ?string $model = SupportTopic::class;

    /**
     * Property: The icon to be used for the navigation item
     */
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    /**
     * Property: The label of a singular resource
     */
    protected static ?string $label = 'Domanda';

    /**
     * Property: The label of a plural resource
     */
    protected static ?string $pluralLabel = 'Domande';

    /**
     * Property: The title attribute of a record
     */
    protected static ?string $recordTitleAttribute = 'name';

    /**
     * Property: The group the resource should be displayed in the navigation
     */
    protected static string|UnitEnum|null $navigationGroup = 'Supporto';

    public static function form(Schema $schema): Schema
    {
        return SupportTopicForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SupportTopicsTable::configure($table);
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
            'index' => ListSupportTopics::route('/'),
            'create' => CreateSupportTopic::route('/create'),
            'edit' => EditSupportTopic::route('/{record}/edit'),
        ];
    }
}
