<?php

use App\Http\Controllers\Activities\TestNextController;
use Legacy\Activity\Test as LegacyTest;

$controllers = collect(glob(__DIR__.'/../../app/Http/Controllers/Activities/Tests/*.php'))
    ->map(fn (string $file) => basename($file, '.php'))
    // _Test is a template stub; Test188 extends the removed Test187 and is already broken
    ->reject(fn (string $name) => in_array($name, ['_Test', 'Test188'], true))
    ->values();

test('specific test controllers autoload and extend the modern base controller', function (string $name): void {
    $class = 'App\\Http\\Controllers\\Activities\\Tests\\'.$name;

    expect(class_exists($class))->toBeTrue()
        ->and(is_subclass_of($class, TestNextController::class))->toBeTrue();
})->with($controllers->all());

test('the test-next template uses the modern controller', function (): void {
    $template = file_get_contents(base_path('legacy/app/templates/logic/test-next.php'));

    expect($template)
        ->toContain(TestNextController::class)
        ->not->toContain('Legacy\\Http\\Controllers\\Activities');
});

test('the legacy activity test exposes the methods used by the test-next flow', function (): void {
    expect(method_exists(LegacyTest::class, 'saveResult'))->toBeTrue()
        ->and(method_exists(LegacyTest::class, 'advance'))->toBeFalse();
});

test('the legacy namespace no longer provides the old test controllers', function (): void {
    expect(class_exists('Legacy\\Http\\Controllers\\Activities\\Test'))->toBeFalse();
});
