<?php

use app\Models\Activities\Section;
use app\Models\Activities\Test;

$section = Section::newFromSlug('imparare');

$stepId = 5;

if (!Test::newFromStep($section->id(), $stepId)) {
	Test::newEmpty()
		->prepare('areaId', $section->areaId())
		->prepare('sectionId', $section->id())
		->prepare('step', $stepId)
		->prepare('title', 'Mappa concettuale')
		->prepare('description', "Completa la mappa concettuale riportando nei riquadri vuoti le informazioni elencate in fondo alla pagina.")
		->prepare('shortDescription', 'Completa la mappa')
		->prepare('slug', 'racconto-eveline-1')
		->prepare('template', 'test-next')
		->prepare('reviewResult', true)
		->up();
}

$asd = Test::newFromStep($section->id(), $stepId)->prepare('slug', 'mappa')->post();
