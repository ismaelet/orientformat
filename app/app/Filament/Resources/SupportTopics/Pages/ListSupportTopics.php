<?php

namespace App\Filament\Resources\SupportTopics\Pages;

use App\Filament\Resources\SupportTopics\SupportTopicResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSupportTopics extends ListRecords
{
    protected static string $resource = SupportTopicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
