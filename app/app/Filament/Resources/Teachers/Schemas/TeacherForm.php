<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class TeacherForm {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Select::make('school_id')
                    ->label('Scuola')
                    ->relationship('school', 'name')
                    ->searchable()
                    ->required(),
            ]);
    }
}
