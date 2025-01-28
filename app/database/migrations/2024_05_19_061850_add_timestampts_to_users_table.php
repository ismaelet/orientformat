<?php

use App\Models\User;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTimestamptsToUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('users', function (Blueprint $table) {
			$table->timestamps();
		});

		User::query()->update([
			'created_at' => DB::raw('time'),
		]);

		Schema::table('students', function (Blueprint $table) {
			$table->timestamps();
		});

		Student::join('users', 'students.userId', '=', 'users.id')
			->update([
				'students.created_at' => DB::raw('users.created_at'),
			]);

		Schema::table('teachers', function (Blueprint $table) {
			$table->timestamps();
		});

		Teacher::join('users', 'teachers.userId', '=', 'users.id')
			->update([
				'teachers.created_at' => DB::raw('users.created_at'),
			]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('users', function (Blueprint $table) {
			$table->dropTimestamps();
		});

		Schema::table('students', function (Blueprint $table) {
			$table->dropTimestamps();
		});

		Schema::table('teachers', function (Blueprint $table) {
			$table->dropTimestamps();
		});
	}
}
