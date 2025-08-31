<?php

namespace App\Filament\Resources\Notifications;

use App\Filament\Resources\Notifications\Pages\CreateNotification;
use App\Filament\Resources\Notifications\Pages\EditNotification;
use App\Filament\Resources\Notifications\Pages\ListNotifications;
use App\Filament\Resources\Notifications\Schemas\NotificationForm;
use App\Filament\Resources\Notifications\Tables\NotificationsTable;
use App\Models\Notification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class NotificationResource extends Resource {

	/**
	 * Property: The model class to be used for the resource
	 */
	protected static ?string $model = Notification::class;

	/**
	 * Property: The icon to be used for the navigation item
	 */
	protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBellAlert;

	/**
	 * Property: The label of a singular resource
	 */
	protected static ?string $label = 'Notifica';

	/**
	 * Property: The label of a plural resource
	 */
	protected static ?string $pluralLabel = 'Notifiche';

	/**
	 * Property: The title attribute of a record
	 */
	protected static ?string $recordTitleAttribute = 'snippet';

	/**
	 * Property: The group the resource should be displayed in the navigation
	 */
	protected static string|UnitEnum|null $navigationGroup = 'Altro';

	public static function form(Schema $schema): Schema {
		return NotificationForm::configure($schema);
	}

	public static function table(Table $table): Table {
		return NotificationsTable::configure($table);
	}

	public static function getRelations(): array {
		return [
			//
		];
	}

	public static function getPages(): array {
		return [
			'index' => ListNotifications::route('/'),
			'create' => CreateNotification::route('/create'),
			'edit' => EditNotification::route('/{record}/edit'),
		];
	}
}
