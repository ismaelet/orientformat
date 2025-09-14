<?php

namespace App\Filament\Resources\Tests\Pages;

use App\Filament\Resources\Tests\TestResource;
use App\Models\Activities\Section;
use Filament\Resources\Pages\CreateRecord;

class CreateTest extends CreateRecord {

	protected function mutateFormDataBeforeCreate(array $data): array {
		$sectionId = $data['sectionId'] ?? null;

		if ($sectionId) {
			$section = Section::find($sectionId);
			$data['areaId'] = $section->areaId;
		}

		return $data;
	}

	protected static string $resource = TestResource::class;
}
