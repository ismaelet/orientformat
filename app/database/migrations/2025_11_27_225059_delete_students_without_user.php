<?php

use App\Models\User\Student;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        $students = Student::doesntHave('user')->get();

        foreach ($students as $student) {
            $student->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        //
    }
};
