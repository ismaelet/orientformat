<?php

namespace Database\Factories\Schools;

use App\Helpers\ClassHelper;
use App\Models\Schools\School;
use App\Models\Schools\SchoolClass;
use App\Models\User\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolClassFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SchoolClass::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $grade = $this->faker->numberBetween(1, 8);
        $isHighSchool = $grade > 3;
        $startingGrade = $grade;
        $year = now()->year;
        $startingYear = $year;
        $professional = $isHighSchool ? $this->faker->boolean() : false;
        $letter = $isHighSchool ? $this->faker->numberBetween(1, $professional ? 4 : 5).$this->faker->randomElement(['A', 'B', 'C', 'D', 'E']) : $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']);
        $name = ClassHelper::generateName($grade, $letter);

        return [
            'schoolId' => School::factory(),
            'referentId' => Teacher::factory(),
            'name' => $name,
            'grade' => $grade,
            'startingGrade' => $startingGrade,
            'letter' => $letter,
            'code' => str()->random(10),
            'startingYear' => $startingYear,
            'year' => $year,
            'ended' => false,
            'professional' => $professional,
        ];
    }

    public function withReferent(Teacher $teacher): static
    {
        return $this->state([
            'referentId' => $teacher->id,
        ]);
    }
}
