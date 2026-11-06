<?php

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

uses(TestCase::class);

test('buttons preserve their submit action and render valid attributes', function (): void {
    $html = Blade::render('<x-button type="submit" size="xs" variant="secondary" color="success" formaction="/classes/join/accept/42">Accetta</x-button>');
    $document = new DOMDocument;
    @$document->loadHTML($html);
    $button = $document->getElementsByTagName('button')->item(0);

    expect($button)->not->toBeNull();
    expect($button->getAttribute('type'))->toBe('submit');
    expect($button->getAttribute('formaction'))->toBe('/classes/join/accept/42');
    expect($button->getAttribute('data-color'))->toBe('success');
    expect($html)->not->toContain('""');
});
