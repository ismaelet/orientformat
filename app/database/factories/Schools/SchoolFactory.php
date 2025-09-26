<?php

namespace Database\Factories\Schools;

use App\Models\Schools\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SchoolFactory extends Factory {

	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = School::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition() {
		return [
			'name' => $this->faker->company,
		];
	}
}
