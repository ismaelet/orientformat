<?php

namespace App\Filament\Resources\SchoolClasses\Pages;

use App\Filament\Resources\SchoolClasses\SchoolClassResource;
use App\Models\User\Teacher;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditSchoolClass extends EditRecord
{
    protected static string $resource = SchoolClassResource::class;

    protected function beforeSave(): void
    {
        $currentReferentId = $this->record->referentId;
        $newReferentId = $this->data['referentId'] ?? null;

        if ($currentReferentId !== $newReferentId && $newReferentId !== null) {
            $this->record->teachers()->detach($currentReferentId);
            $this->record->teachers()->attach(Teacher::find($newReferentId));
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
