<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('results_tests_archive', function (Blueprint $table) {
            $table->bigIncrements('archive_id');
            $table->integer('id');
            $table->integer('studentId');
            $table->integer('testId');
            $table->boolean('completed')->default(false);
            $table->string('result', 2500);
            $table->integer('percentage');
            $table->integer('speed')->default(0);
            $table->timestamp('time')->useCurrent();
            $table->timestamps();
            $table->index(['studentId', 'testId']);
        });

        $columns = ['id', 'studentId', 'testId', 'completed', 'result', 'percentage', 'speed', 'time', 'created_at', 'updated_at'];
        DB::table('results_tests_archive')->insertUsing(
            $columns,
            DB::table('results_tests as result')
                ->select(array_map(fn ($column) => 'result.'.$column, $columns))
                ->whereExists(function ($query) {
                    $query->selectRaw('1')
                        ->from('results_tests as newer')
                        ->whereColumn('newer.studentId', 'result.studentId')
                        ->whereColumn('newer.testId', 'result.testId')
                        ->whereColumn('newer.id', '>', 'result.id');
                })
        );

        DB::table('results_tests')->whereIn('id', DB::table('results_tests_archive')->select('id'))->delete();

        Schema::table('results_tests', function (Blueprint $table) {
            $table->unique(['studentId', 'testId'], 'results_tests_student_test_unique');
        });
    }

    public function down(): void
    {
        Schema::table('results_tests', function (Blueprint $table) {
            $table->dropUnique('results_tests_student_test_unique');
        });

        $columns = ['studentId', 'testId', 'completed', 'result', 'percentage', 'speed', 'time', 'created_at', 'updated_at'];
        DB::table('results_tests')->insertUsing($columns, DB::table('results_tests_archive')->select($columns));
        Schema::drop('results_tests_archive');
    }
};
