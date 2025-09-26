<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase {

	use RefreshDatabase;

	/**
	 * Test that a student can log in successfully
	 */
	public function test_student_can_login(): void {
		$user = User::factory()->create([
			'password' => bcrypt('password123'),
		]);

		Student::factory()->create([
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
		$this->assertTrue(is_student());
	}

	/**
	 * Test that a teacher can log in successfully
	 */
	public function test_teacher_can_login(): void {
		$user = User::factory()->create([
			'password' => Hash::make('password123'),
		]);

		Teacher::factory()->create([
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
		$this->assertTrue(is_teacher());
	}

	/**
	 * Test student registration
	 */
	public function test_student_registration(): void {
		$class = SchoolClass::factory()->create();

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
		$this->assertTrue(is_student());
	}

	/**
	 * Test teacher registration
	 */
	public function test_teacher_registration(): void {
		$email = 'teacheruser@' . (RegisterController::AVAILABLE_EMAIL_DOMAINS[array_rand(RegisterController::AVAILABLE_EMAIL_DOMAINS)]);

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
		$response->assertRedirectToRoute('home');

		// Check that the user is authenticated
		$this->assertAuthenticatedAs($user);
		$this->assertTrue(is_teacher());
	}
}
