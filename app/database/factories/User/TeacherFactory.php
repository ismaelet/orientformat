<?php

namespace Database\Factories\User;

use App\Models\User;
use App\Models\User\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition(): array
    {
        return [];
    }

    public function forUser(User $user): static
    {
        return $this->state([
            'id' => $user->id,
            'user_id' => $user->id,
        ]);
    }
}
