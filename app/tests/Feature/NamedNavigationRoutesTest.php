<?php

use App\Legacy\Exceptions\LegacyRedirectException;
use App\Models\Admin\AdminSection;
use App\Models\User;
use App\Models\User\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Legacy\Activity\Section;

test('navigation URLs resolve to their named GET routes under a subdirectory', function (string $name, array $parameters, string $path): void {
    URL::forceRootUrl('https://example.test/orientamento');
    $url = route($name, $parameters);

    expect(parse_url($url, PHP_URL_PATH))->toBe(rtrim('/orientamento'.$path, '/'));

    $request = Request::create($url.($path === '/' ? '/' : ''), 'GET', server: [
        'SCRIPT_NAME' => '/orientamento/index.php',
        'SCRIPT_FILENAME' => '/var/www/html/public/index.php',
    ]);
    $matched = Route::getRoutes()->match($request);

    expect($matched->getName())->toBe($name);
})->with([
    ['home', [], '/'],
    ['login', [], '/login'],
    ['logout', [], '/logout'],
    ['help', ['category' => 4, 'topic' => 8], '/help'],
    ['help.ticket.open', [], '/help/ticket/open'],
    ['teacher.dashboard', [], '/teacher'],
    ['teacher.simulation', ['type' => 'high-school'], '/teacher/simulation'],
    ['teacher.know-more', [], '/teacher/know-more'],
    ['teacher.documents', [], '/teacher/documents'],
    ['class.show', ['class' => 123], '/class/123'],
    ['class.settings', ['class' => 123], '/class/123/settings'],
    ['class.students.index', ['class' => 123], '/class/123/students/index'],
    ['class.students.results.index', ['class' => 123], '/class/123/students/results'],
    ['class.students.results.show', ['class' => 123, 'student' => 456], '/class/123/students/results/456'],
    ['class.general.progress', ['class' => 123], '/class/123/progress/areas'],
    ['classes.create', [], '/classes/create'],
    ['section', ['section' => 23], '/activities/sections/23'],
    ['test', ['test' => 92, 'student_id' => 456], '/activities/tests/92'],
    ['analysis.student.area', ['area' => 4], '/analysis/student/areas/4'],
    ['interest', ['id' => 2, 'watch' => 1, 'highschool' => 0], '/interest'],
    ['read', ['area-id' => 4], '/read'],
    ['filament.admin.pages.dashboard', [], '/admin'],
    ['filament.admin.resources.users.index', [], '/admin/users'],
]);

test('legacy redirects preserve named route queries and fragments without opening a database connection', function (): void {
    URL::forceRootUrl('https://example.test/orientamento');

    try {
        redirect_old('/read?id=13#comprendere');
        $this->fail('Expected a legacy redirect.');
    } catch (LegacyRedirectException $exception) {
        expect($exception->url)->toBe(route('read', ['id' => 13]).'#comprendere');
    }
});

test('interest and reading route query parameters survive URL generation', function (): void {
    $url = route('interest', ['id' => 2, 'student-id' => 456, 'highschool' => 0]);
    parse_str(parse_url($url, PHP_URL_QUERY), $query);

    expect($query)->toBe(['id' => '2', 'student-id' => '456', 'highschool' => '0']);

    $url = route('read', ['id' => 13]).'#comprendere';
    expect(parse_url($url, PHP_URL_FRAGMENT))->toBe('comprendere');
});

test('old admin section names link to existing Filament pages', function (string $resource, string $action, string $routeName): void {
    $section = new AdminSection(['resource' => $resource, 'action' => $action]);

    expect($section->url())->toBe(route($routeName));
})->with([
    ['users', 'list', 'filament.admin.resources.users.index'],
    ['users', 'add', 'filament.admin.resources.users.create'],
    ['retired-resource', 'list', 'filament.admin.pages.dashboard'],
]);

test('guest navigation links reach real HTTP endpoints', function (): void {
    $this->withoutVite();

    $this->get(route('login'))->assertOk()->assertSee(route('help'), false);
    $this->get(route('teacher.documents'))->assertRedirectToRoute('home');
    $this->get(route('section', ['section' => 23]))->assertRedirectToRoute('login');
});

test('teacher document navigation renders with named links', function (): void {
    $this->withoutVite();
    $user = User::factory()->create();
    Teacher::factory()->forUser($user)->create();

    $this->actingAs($user)->get(route('teacher.documents'))
        ->assertOk()
        ->assertSee(route('teacher.dashboard'), false)
        ->assertSee(route('teacher.simulation', ['type' => 'middle-school']), false);
});

test('the remaining legacy route registration adapter registers native named routes', function (): void {
    require_once base_path('legacy/app/Support/Route.php');

    App\Support\Route::get('/test-native-route-registration', fn () => 'Native route response');

    $this->get(route('legacy.support.get.test-native-route-registration'))
        ->assertOk()
        ->assertSee('Native route response');
});

test('legacy section links preserve the modern model choice between a test and a recap', function (): void {
    $modern = Mockery::mock(App\Models\Activities\Section::class)->makePartial();
    $modern->shouldReceive('url')->once()->andReturn(route('test', ['test' => 92]));

    $legacy = new class($modern) extends Section
    {
        public function __construct(private App\Models\Activities\Section $section) {}

        public function newSection(): ?App\Models\Activities\Section
        {
            return $this->section;
        }
    };

    expect($legacy->clientUrl)->toBe(route('test', ['test' => 92]));
});
