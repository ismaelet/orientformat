<?php

namespace Database\Factories\User;

use App\Models\Schools\SchoolClass;
use App\Models\User;
use App\Models\User\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'id' => $user->id,
            'userId' => $user->id,
            'schoolClassId' => SchoolClass::factory(),
        ];
    }
}
