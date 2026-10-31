<?php

use App\Legacy\ScriptLoader;
use Illuminate\Foundation\Vite;

test('login renders without jQuery imports', function (): void {
    $this->withoutVite();
    $this->get(route('login'))->assertOk()
        ->assertDontSee('code.jquery.com', false)
        ->assertDontSee('jquery-ui', false);
});

test('retired AJAX and arbitrary legacy API endpoints return not found', function (string $path): void {
    $this->withoutVite();
    $this->get($path)->assertNotFound();
})->with([
    '/ajax/grade-list',
    '/api-old/search-table/users',
    '/api-old/call-function/example',
    '/api-old/get-class-properties/Example',
    '/api-old/call-class-method/Example',
]);

test('legacy exercise rendering loads native Vite modules once and keeps plain scripts available', function (): void {
    $property = new ReflectionProperty(ScriptLoader::class, 'list');
    $previous = $property->getValue();
    $property->setValue(null, []);
    $hotFile = tempnam(sys_get_temp_dir(), 'exercise-vite-');
    file_put_contents($hotFile, 'http://localhost:5173');
    app(Vite::class)->useHotFile($hotFile);

    try {
        ScriptLoader::add('skills/leggere/intreccio', 'page');
        ScriptLoader::add('skills/leggere/intreccio', 'page');
        ScriptLoader::add('test', 'template');
        ScriptLoader::add('teacher/simulation', 'page');
        $html = ScriptLoader::load();

        expect($html)->toContain('type="module"');
        expect(substr_count($html, 'resources/js/exercises/pages/skills/leggere/intreccio.js'))->toBe(1);
        expect($html)->toContain('resources/js/exercises/templates/test.js');
        expect($html)->toContain('/legacy/pages/scripts/teacher/simulation.js');
        expect($html)->not->toContain('jquery');
    } finally {
        unlink($hotFile);
        $property->setValue(null, $previous);
    }
});
