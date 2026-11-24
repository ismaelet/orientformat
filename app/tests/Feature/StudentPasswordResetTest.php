<?php

use App\Livewire\Administrator\Student\Table;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use App\Models\User\Student;
use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

test('student table resets passwords to twelve lowercase letters and digits', function (): void {
    $this->actingAs(User::factory()->create(['admin_level' => 2]));
    $class = SchoolClass::factory()->create();
    $user = User::factory()->create();
    $student = Student::create([
        'id' => $user->id,
        'userId' => $user->id,
        'schoolClassId' => $class->id,
    ]);
    $oldRememberToken = $user->remember_token;

    Livewire::test(Table::class, ['class' => $class])
        ->callAction(TestAction::make('resetPassword')->table($student));

    $notifications = session('filament.claimed_notifications') ?? session('filament.notifications');
    $body = collect($notifications)->firstWhere('title', 'Password generata')['body'];
    preg_match('/<span[^>]*>(.*?)<\/span>/', $body, $matches);
    $password = $matches[1];

    expect($password)->toMatch('/\A[a-z0-9]{12}\z/')
        ->toMatch('/[a-z]/')
        ->toMatch('/[0-9]/')
        ->and(Hash::check($password, $user->fresh()->password))->toBeTrue()
        ->and($user->fresh()->remember_token)->not->toBe($oldRememberToken);
});
