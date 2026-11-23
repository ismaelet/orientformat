<?php

use App\Mail\ContactMail;
use App\Models\Masterpiece;
use App\Models\Schools\School;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use App\Models\User\Administrator;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;

beforeEach(fn () => Cache::flush());

test('masterpieces are stored privately and cannot be downloaded for another student', function (): void {
    Storage::fake('local');
    Storage::fake('public');

    $studentUser = User::factory()->create();
    $otherStudentUser = User::factory()->create();
    Student::create(['id' => $studentUser->id, 'userId' => $studentUser->id]);
    Student::create(['id' => $otherStudentUser->id, 'userId' => $otherStudentUser->id]);
    $student = Student::where('userId', $studentUser->id)->firstOrFail();

    $uploadResponse = $this->actingAs($student->user)
        ->post(route('masterpieces.upload'), [
            'title' => 'Portfolio',
            'setting' => 0,
            'mode' => 0,
            'type' => 0,
            'skill' => 0,
            'file' => UploadedFile::fake()->create('portfolio.pdf', 100, 'application/pdf'),
        ]);
    $uploadResponse->assertSessionHasNoErrors();

    $masterpiece = Masterpiece::where('student_id', $studentUser->id)->firstOrFail();
    Storage::disk('local')->assertExists($masterpiece->storageFilePath());
    Storage::disk('public')->assertMissing($masterpiece->storageFilePath());

    $otherMasterpiece = Masterpiece::create([
        'student_id' => $otherStudentUser->id,
        'title' => 'Other portfolio',
        'setting' => 0,
        'mode' => 0,
        'type' => 0,
        'skill' => 0,
    ]);
    Storage::disk('local')->put($otherMasterpiece->storageFilePath(), 'other');

    $this->get(route('masterpieces.download', [
        'student' => $student,
        'masterpiece' => $masterpiece,
    ]))->assertOk();

    $this->get(route('masterpieces.download', [
        'student' => $student,
        'masterpiece' => $otherMasterpiece,
    ]))->assertNotFound();
});

test('password recovery has the same response for known and unknown email addresses', function (): void {
    Notification::fake();
    $user = User::factory()->create();

    $this->post(route('auth.recover'), ['email' => $user->email])
        ->assertRedirectToRoute('auth.recover')
        ->assertSessionHas('submitted', true)
        ->assertSessionMissing('not_found');

    $this->post(route('auth.recover'), ['email' => 'missing@example.com'])
        ->assertRedirectToRoute('auth.recover')
        ->assertSessionHas('submitted', true)
        ->assertSessionMissing('not_found');
});

test('password reset tokens are hashed expiring and single use', function (): void {
    $user = User::factory()->create(['password' => Hash::make('old-password')]);
    $token = Password::broker()->createToken($user);
    $storedToken = DB::table(config('auth.passwords.users.table'))->where('email', $user->email)->value('token');

    expect($storedToken)->not->toBe($token);
    expect(Hash::check($token, $storedToken))->toBeTrue();

    $credentials = [
        'email' => $user->email,
        'token' => $token,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ];

    $this->post(route('auth.reset'), $credentials)
        ->assertSessionHas('submitted', true);
    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();

    $this->post(route('auth.reset'), $credentials)
        ->assertSessionHas('error');

    $expiredToken = Password::broker()->createToken($user);
    DB::table(config('auth.passwords.users.table'))
        ->where('email', $user->email)
        ->update(['created_at' => now()->subMinutes(61)]);

    $this->post(route('auth.reset'), [
        'email' => $user->email,
        'token' => $expiredToken,
        'password' => 'another-password',
        'password_confirmation' => 'another-password',
    ])->assertSessionHas('error');

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

test('password reset requires the same minimum password length as registration', function (): void {
    $user = User::factory()->create();
    $token = Password::broker()->createToken($user);

    $this->post(route('auth.reset'), [
        'email' => $user->email,
        'token' => $token,
        'password' => 'short',
        'password_confirmation' => 'short',
    ])->assertSessionHasErrors('password');
});

test('school administrators can only export their own school and formulas are neutralized', function (): void {
    $ownSchool = School::factory()->create();
    $otherSchool = School::factory()->create();

    $ownTeacherUser = User::factory()->create();
    $otherTeacherUser = User::factory()->create();
    Teacher::create([
        'id' => $ownTeacherUser->id,
        'user_id' => $ownTeacherUser->id,
        'school_id' => $ownSchool->id,
    ]);
    Teacher::create([
        'id' => $otherTeacherUser->id,
        'user_id' => $otherTeacherUser->id,
        'school_id' => $otherSchool->id,
    ]);
    $ownClass = SchoolClass::factory()->create([
        'schoolId' => $ownSchool->id,
        'referentId' => $ownTeacherUser->id,
    ]);
    $otherClass = SchoolClass::factory()->create([
        'schoolId' => $otherSchool->id,
        'referentId' => $otherTeacherUser->id,
    ]);

    $ownStudentUser = User::factory()->create([
        'first_name' => 'Safe',
        'last_name' => '=HYPERLINK("https://evil.test")',
    ]);
    $otherStudentUser = User::factory()->create([
        'first_name' => 'Other',
        'last_name' => 'School',
    ]);
    Student::create([
        'id' => $ownStudentUser->id,
        'schoolClassId' => $ownClass->id,
        'userId' => $ownStudentUser->id,
    ]);
    Student::create([
        'id' => $otherStudentUser->id,
        'schoolClassId' => $otherClass->id,
        'userId' => $otherStudentUser->id,
    ]);

    $administrator = Administrator::create([
        'user_id' => User::factory()->create()->id,
        'school_id' => $ownSchool->id,
    ]);

    $response = $this->actingAs($administrator->user)
        ->get(route('administrator.download.students', ['format' => 'csv']));
    $csv = $response->streamedContent();

    expect($csv)
        ->toContain("'=HYPERLINK")
        ->not->toContain('Other');

    $this->get("/administrator/download/{$otherSchool->id}/students?format=csv")
        ->assertNotFound();
});

test('only superadmins have privileged admin access', function (): void {
    $administrator = User::factory()->create(['admin_level' => 1]);
    $superadmin = User::factory()->create(['admin_level' => 2]);

    expect($administrator->isSuperadmin())->toBeFalse()
        ->and($administrator->is_admin)->toBeFalse()
        ->and($superadmin->isSuperadmin())->toBeTrue()
        ->and($superadmin->is_admin)->toBeTrue();

    $this->actingAs($administrator)
        ->get(route('admin.data-download.details'))
        ->assertRedirectToRoute('login');
});

test('contact submissions are validated and escaped before email rendering', function (): void {
    Mail::fake();

    $this->post(route('help.ticket.store'), [
        'name' => '<img src=x onerror=alert(1)>',
        'email' => 'guest@example.com',
        'message' => '<script>alert("xss")</script>',
    ])->assertRedirectToRoute('help.ticket.open');

    Mail::assertSent(ContactMail::class, function (ContactMail $mail): bool {
        return str_contains($mail->content, '&lt;img')
            && str_contains($mail->content, '&lt;script&gt;')
            && ! str_contains($mail->content, '<script>');
    });

    Mail::fake();
    $this->post(route('help.ticket.store'), [
        'name' => '',
        'email' => 'not-an-email',
        'message' => str_repeat('x', 501),
    ])->assertSessionHasErrors(['name', 'email', 'message']);
    Mail::assertNothingSent();
});
