<?php

use App\Legacy\LegacyConfig;
use App\Legacy\LegacyView;

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
        LegacyView::setTitle('');
        expect(LegacyView::getTabTitle())->toBe('Test application | Short description');
        expect(LegacyView::getDescription())->toBe('Application description');

        LegacyView::setTitle('Page title');
        expect(LegacyView::getTabTitle())->toBe('Page title | Test application');

        config(['custom.meta_data.short_description' => '']);
        LegacyView::setTitle('');
        expect(LegacyView::getTabTitle())->toBe('Test application');
    } finally {
        LegacyView::setTitle('');
    }
});
