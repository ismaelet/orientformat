<?php

namespace Database\Factories\User;

use App\Models\User;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TeacherFactory extends Factory {

	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Teacher::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition() {
		return [
			'user_id' => User::factory(),
		];
	}
}
