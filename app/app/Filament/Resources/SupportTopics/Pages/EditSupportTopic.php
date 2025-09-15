<?php

namespace App\Filament\Resources\SupportTopics\Pages;

use App\Filament\Resources\SupportTopics\SupportTopicResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSupportTopic extends EditRecord
{
    protected static string $resource = SupportTopicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
