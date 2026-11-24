<?php

use App\Filament\Resources\Administrators\Pages\EditAdministrator;
use App\Filament\Resources\Students\Pages\EditStudent;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\Schools\Grade;
use App\Models\Schools\School;
use App\Models\User;
use App\Models\User\Administrator;
use App\Models\User\Student;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;

beforeEach(function (): void {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
});

test('verified platform admins can access the panel but other users cannot', function (): void {
    $admin = User::factory()->create(['admin_level' => 1]);
    $superadmin = User::factory()->create(['admin_level' => 2]);
    $unverifiedAdmin = User::factory()->create(['admin_level' => 1, 'email_verified_at' => null]);
    $user = User::factory()->create(['admin_level' => 0]);
    $panel = Filament::getPanel('admin');

    expect($admin->canAccessPanel($panel))->toBeTrue()
        ->and($superadmin->canAccessPanel($panel))->toBeTrue()
        ->and($unverifiedAdmin->canAccessPanel($panel))->toBeFalse()
        ->and($user->canAccessPanel($panel))->toBeFalse()
        ->and($admin->categoryLabel())->toBe('Admin');

    $this->actingAs($admin)->get(route('home'))->assertRedirect('/admin');
    $this->get(route('filament.admin.resources.users.index'))->assertOk();
});

test('only superadmins can delete records from filament resources', function (): void {
    $admin = User::factory()->create(['admin_level' => 1]);
    $superadmin = User::factory()->create(['admin_level' => 2]);
    $target = User::factory()->create();

    $this->actingAs($admin);
    foreach (Filament::getPanel('admin')->getResources() as $resource) {
        expect($resource::canDeleteAny())->toBeFalse()
            ->and($resource::canForceDeleteAny())->toBeFalse()
            ->and($resource::canDelete(new ($resource::getModel())))->toBeFalse()
            ->and($resource::canForceDelete(new ($resource::getModel())))->toBeFalse();
    }
    expect(\Filament\get_authorization_response('delete', Grade::class)->allowed())->toBeFalse()
        ->and(\Filament\get_authorization_response('deleteAny', Grade::class)->allowed())->toBeFalse();

    Livewire::test(ListUsers::class)
        ->assertActionHidden(TestAction::make('delete')->table($target))
        ->assertActionHidden(TestAction::make('delete')->table()->bulk())
        ->assertActionHidden(TestAction::make('forceDelete')->table()->bulk())
        ->mountAction(TestAction::make('delete')->table($target))
        ->call('callMountedAction');
    Livewire::test(EditUser::class, ['record' => $target->getRouteKey()])
        ->assertActionHidden('delete')
        ->mountAction('delete')
        ->call('callMountedAction');
    expect($target->fresh()->trashed())->toBeFalse();

    $this->actingAs($superadmin);
    Livewire::test(ListUsers::class)
        ->assertActionVisible(TestAction::make('delete')->table($target))
        ->assertActionVisible(TestAction::make('delete')->table()->bulk());
    $target->delete();
    $this->actingAs($admin);
    Livewire::test(EditUser::class, ['record' => $target->getRouteKey()])
        ->assertActionHidden('forceDelete')
        ->mountAction('forceDelete')
        ->call('callMountedAction');
    expect(User::withTrashed()->find($target->id))->not->toBeNull();
});

test('only superadmins can change an existing user email in filament', function (): void {
    $admin = User::factory()->create(['admin_level' => 1]);
    $superadmin = User::factory()->create(['admin_level' => 2]);
    $target = User::factory()->create();
    $email = $target->email;

    $this->actingAs($admin);
    Livewire::test(EditUser::class, ['record' => $target->getRouteKey()])
        ->assertFormFieldIsDisabled('email')
        ->fillForm(['email' => 'changed@example.test'])
        ->call('save');
    expect($target->fresh()->email)->toBe($email);

    $this->actingAs($superadmin);
    Livewire::test(EditUser::class, ['record' => $target->getRouteKey()])
        ->assertFormFieldIsEnabled('email')
        ->fillForm(['email' => 'changed@example.test'])
        ->call('save')
        ->assertHasNoFormErrors();
    expect($target->fresh()->email)->toBe('changed@example.test');
});

test('only superadmins can edit passwords in the user form', function (): void {
    $admin = User::factory()->create(['admin_level' => 1]);
    $superadmin = User::factory()->create(['admin_level' => 2]);
    $target = User::factory()->create();
    $oldPassword = $target->password;

    $this->actingAs($admin);
    Livewire::test(EditUser::class, ['record' => $target->getRouteKey()])
        ->assertFormFieldIsHidden('password')
        ->fillForm(['password' => 'ChangedPassword123!'])
        ->call('save')
        ->assertHasNoFormErrors();
    expect($target->fresh()->password)->toBe($oldPassword);

    $this->actingAs($superadmin);
    $form = Livewire::test(EditUser::class, ['record' => $target->getRouteKey()])
        ->assertFormFieldIsVisible('password')
        ->assertFormSet(['password' => null])
        ->fillForm(['password' => ''])
        ->call('save')
        ->assertHasNoFormErrors();
    expect($target->fresh()->password)->toBe($oldPassword);

    $form->fillForm(['password' => 'short'])
        ->call('save')
        ->assertHasFormErrors(['password' => 'min']);
    expect($target->fresh()->password)->toBe($oldPassword);

    $form->fillForm(['password' => 'ChangedPassword123!'])
        ->call('save')
        ->assertHasNoFormErrors();
    expect(Hash::check('ChangedPassword123!', $target->fresh()->password))->toBeTrue();
});

test('level one admins cannot change emails through related user forms', function (): void {
    $admin = User::factory()->create(['admin_level' => 1]);
    $superadmin = User::factory()->create(['admin_level' => 2]);
    $studentUser = User::factory()->create();
    $referentUser = User::factory()->create();
    Student::create(['id' => $studentUser->id, 'userId' => $studentUser->id]);
    $student = Student::where('userId', $studentUser->id)->firstOrFail();
    $referent = Administrator::create([
        'user_id' => $referentUser->id,
        'school_id' => School::factory()->create()->id,
    ]);

    $this->actingAs($admin);
    Livewire::test(EditStudent::class, ['record' => $student->getRouteKey()])
        ->assertOk()
        ->assertFormFieldIsDisabled('user.email')
        ->fillForm(['user.email' => 'changed-student@example.test'])
        ->call('save');
    Livewire::test(EditAdministrator::class, ['record' => $referent->getRouteKey()])
        ->assertFormFieldIsDisabled('user.email')
        ->fillForm(['user.email' => 'changed-referent@example.test'])
        ->call('save');

    expect($studentUser->fresh()->email)->toBe($studentUser->email)
        ->and($referentUser->fresh()->email)->toBe($referentUser->email);

    $this->actingAs($superadmin);
    Livewire::test(EditStudent::class, ['record' => $student->getRouteKey()])
        ->assertFormFieldIsEnabled('user.email')
        ->fillForm(['user.email' => 'changed-student@example.test'])
        ->call('save')
        ->assertHasNoFormErrors();
    Livewire::test(EditAdministrator::class, ['record' => $referent->getRouteKey()])
        ->assertFormFieldIsEnabled('user.email')
        ->fillForm(['user.email' => 'changed-referent@example.test'])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($studentUser->fresh()->email)->toBe('changed-student@example.test')
        ->and($referentUser->fresh()->email)->toBe('changed-referent@example.test');
});

test('only superadmins can reset passwords from the users table', function (): void {
    $admin = User::factory()->create(['admin_level' => 1]);
    $superadmin = User::factory()->create(['admin_level' => 2]);
    $target = User::factory()->create();
    $oldPassword = $target->password;
    $oldRememberToken = $target->remember_token;
    $token = Password::broker()->createToken($target);

    $this->actingAs($admin);
    Livewire::test(ListUsers::class)
        ->assertActionHidden(TestAction::make('resetPassword')->table($target))
        ->mountAction(TestAction::make('resetPassword')->table($target))
        ->call('callMountedAction');
    expect($target->fresh()->password)->toBe($oldPassword);

    $this->actingAs($superadmin);
    Livewire::test(ListUsers::class)
        ->assertActionVisible(TestAction::make('resetPassword')->table($target))
        ->callAction(TestAction::make('resetPassword')->table($target));

    $target->refresh();
    $notifications = session('filament.claimed_notifications') ?? session('filament.notifications');
    $body = collect($notifications)->firstWhere('title', 'Password generata')['body'];
    preg_match('/<strong>(.*?)<\/strong>/', $body, $matches);
    $newPassword = html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5);

    expect($newPassword)->toMatch('/\A[a-z0-9]{12}\z/')
        ->toMatch('/[a-z]/')
        ->toMatch('/[0-9]/')
        ->and($target->password)->not->toBe($oldPassword)
        ->and(Hash::check($newPassword, $target->password))->toBeTrue()
        ->and($target->remember_token)->not->toBe($oldRememberToken)
        ->and(Password::broker()->tokenExists($target, $token))->toBeFalse();
});
