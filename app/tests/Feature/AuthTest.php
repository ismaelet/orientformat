<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

beforeEach(fn () => Cache::flush());

test('student can login', function (): void {
    $user = User::factory()->create([
        'password' => bcrypt('password123'),
    ]);

    Student::create([
        'id' => $user->id,
        'userId' => $user->id,
    ]);

    $response = $this->post(route('login.auth'), [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    // Check that there are no validation errors
    $response->assertSessionHasNoErrors();

    // Check that the user is redirected to the home page
    $response->assertStatus(302);
    $response->assertRedirectToRoute('home');

    // Check that the user is authenticated
    $this->assertAuthenticatedAs($user);

    // Check that the authenticated user is a student
    expect(is_student())->toBeTrue();
});

test('teacher can login', function (): void {
    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    Teacher::create([
        'id' => $user->id,
        'user_id' => $user->id,
    ]);

    $response = $this->post(route('login.auth'), [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    // Check that there are no validation errors
    $response->assertSessionHasNoErrors();

    // Check that the user is redirected to the home page
    $response->assertStatus(302);
    $response->assertRedirectToRoute('home');

    // Check that the user is authenticated
    $this->assertAuthenticatedAs($user);

    // Check that the authenticated user is a teacher
    expect(is_teacher())->toBeTrue();
});

test('student registration', function (): void {
    $teacherUser = User::factory()->create();

    $teacher = Teacher::create([
        'id' => $teacherUser->id,
        'user_id' => $teacherUser->id,
    ]);

    $class = SchoolClass::factory()
        ->withReferent($teacher)
        ->create();

    $response = $this->post(route('register.store'), [
        'type' => 'student',
        'email' => 'studentuser@example.com',
        'first_name' => 'Student',
        'last_name' => 'Test',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'birthdate' => '2005-05-15',
        'class' => $class->code,
    ]);

    $user = User::where('email', 'studentuser@example.com')->first();

    // Check that there are no validation errors
    $response->assertSessionHasNoErrors();

    // Check that the user is redirected to the home page
    $response->assertStatus(302);
    $response->assertRedirectToRoute('home');

    // Check that the user is authenticated
    $this->assertAuthenticatedAs($user);
    expect(is_student())->toBeTrue();
});

test('teacher registration', function (): void {
    Notification::fake();

    $email = 'teacheruser@'.(RegisterController::AVAILABLE_EMAIL_DOMAINS[array_rand(RegisterController::AVAILABLE_EMAIL_DOMAINS)]);

    $response = $this->post(route('register.store'), [
        'type' => 'teacher',
        'email' => $email,
        'first_name' => 'Teacher',
        'last_name' => 'Test',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $user = User::where('email', $email)->first();

    // Check that there are no validation errors
    $response->assertSessionHasNoErrors();

    // Check that the user is redirected to the home page
    $response->assertStatus(302);
    $response->assertRedirectToRoute('verification.notice');

    // Check that the user is authenticated
    $this->assertAuthenticatedAs($user);
    expect(is_teacher())->toBeTrue();
    Notification::assertSentTo($user, VerifyEmail::class);

    $this->get(route('teacher.school.show'))
        ->assertRedirectToRoute('verification.notice');

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(30),
        ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
    );

    $this->get($verificationUrl)->assertRedirectToRoute('home');
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

test('student registration and login do not require email verification', function (): void {
    Notification::fake();

    $teacherUser = User::factory()->create();
    $teacher = Teacher::create([
        'id' => $teacherUser->id,
        'user_id' => $teacherUser->id,
    ]);
    $class = SchoolClass::factory()->withReferent($teacher)->create();

    $email = 'unverified.student@example.com';

    $this->post(route('register.store'), [
        'type' => 'student',
        'email' => $email,
        'first_name' => 'Unverified',
        'last_name' => 'Student',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'birthdate' => '2005-05-15',
        'class' => $class->code,
    ])->assertRedirectToRoute('home');

    $user = User::where('email', $email)->firstOrFail();
    expect($user->requiresEmailVerification())->toBeFalse();
    Notification::assertNothingSent();

    $this->get(route('home'))->assertRedirectToRoute('student');
});
