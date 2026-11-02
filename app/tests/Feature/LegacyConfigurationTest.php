<?php

use App\Legacy\LegacyConfig;

beforeEach(function (): void {
    config([
        'app.name' => 'Test application',
        'app.url' => 'https://example.test/orientamento',
        'app.timezone' => 'Europe/Rome',
        'app.locales' => ['it' => 'Italiano', 'de' => 'Deutsch'],
        'app.fallback_locale' => 'de',
        'custom.meta_data.full_name' => 'Full application name',
        'custom.meta_data.description' => 'Application description',
        'custom.meta_data.short_description' => 'Short description',
        'custom.meta_data.default_color_scheme' => 'dark',
    ]);
});

test('legacy helpers read laravel configuration without stale values', function (): void {
    $legacy = LegacyConfig::getInstance();

    expect($legacy->name)->toBe('Test application');
    expect($legacy->fullName)->toBe('Full application name');
    expect($legacy->description)->toBe('Application description');
    expect($legacy->shortDescription)->toBe('Short description');
    expect($legacy->websiteUrl)->toBe('https://example.test/orientamento');
    expect($legacy->timezone)->toBe('Europe/Rome');
    expect($legacy->languages)->toBe(['it' => 'Italiano', 'de' => 'Deutsch']);
    expect($legacy->defaultLanguage)->toBe('de');
    expect($legacy->themeColor)->toBe('dark');
    expect($legacy->hasDatabase)->toBeTrue();
    expect($legacy->cookiesWarning)->toBeFalse();
    expect($legacy->loggedRedirectUrl)->toBe('/');
    expect($legacy->unknownSetting)->toBeNull();

    config(['app.name' => 'Updated application']);
    expect($legacy->name)->toBe('Updated application');
});

test('legacy page metadata uses laravel configuration', function (): void {
    try {
        request()->attributes->set('legacy.title', null);
        expect(legacy_page_title())->toBe('Test application | Short description');
        expect(legacy_page_description())->toBe('Application description');

        request()->attributes->set('legacy.title', 'Page title');
        expect(legacy_page_title())->toBe('Page title | Test application');

        config(['custom.meta_data.short_description' => '']);
        request()->attributes->set('legacy.title', null);
        expect(legacy_page_title())->toBe('Test application');
    } finally {
        request()->attributes->remove('legacy.title');
    }
});

test('legacy page data is stored in the current request', function (): void {
    legacy_set_view_data('answers', ['first']);
    legacy_set_view_data('answers', 'second', 1);

    expect(legacy_view_data())->toBe([
        'answers' => ['first', 'second'],
    ]);

    request()->attributes->remove('legacy.data');

    expect(legacy_view_data())->toBe([]);
});

test('support page renders with request-scoped page metadata', function (): void {
    $this->get(route('help'))
        ->assertOk()
        ->assertSee('<title>Supporto | '.config('app.name').'</title>', false);
});
