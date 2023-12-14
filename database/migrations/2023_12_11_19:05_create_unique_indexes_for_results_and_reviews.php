<?php

return new class {

	/**
	 * Run the migration
	 */
	public function up(): void {
		DB::execute('DELETE t1 FROM results_sections t1 INNER JOIN (SELECT studentId, sectionId, MAX(id) AS max_id FROM results_sections GROUP BY studentId, sectionId) t2 ON t1.studentId = t2.studentId AND t1.sectionId = t2.sectionId AND t1.id < t2.max_id');

		DB::execute('CREATE UNIQUE INDEX studentId_testId_index ON results_tests (studentId, testId)');
		DB::execute('CREATE UNIQUE INDEX testId_studentId_index ON results_tests (testId, studentId)');
		DB::execute('CREATE UNIQUE INDEX studentId_sectionId_index ON results_sections (studentId, sectionId)');
		DB::execute('CREATE UNIQUE INDEX sectionId_studentId_index ON results_sections (sectionId, studentId)');
		DB::execute('CREATE UNIQUE INDEX student_id_section_id_index ON results_sections_condensed (student_id, section_id)');
		DB::execute('CREATE UNIQUE INDEX section_id_student_id_index ON results_sections_condensed (section_id, student_id)');
		DB::execute('CREATE UNIQUE INDEX studentId_gradeId_index ON results_grades (studentId, gradeId)');
		DB::execute('CREATE UNIQUE INDEX gradeId_studentId_index ON results_grades (gradeId, studentId)');
		DB::execute('CREATE UNIQUE INDEX studentId_reviewId_index ON review_results (studentId, reviewId)');
		DB::execute('CREATE UNIQUE INDEX reviewId_studentId_index ON review_results (reviewId, studentId)');
	}

	/**
	 * Reverse the migration
	 */
	public function down(): void {
		DB::execute('DROP INDEX studentId_testId_index ON results_tests');
		DB::execute('DROP INDEX testId_studentId_index ON results_tests');
		DB::execute('DROP INDEX studentId_sectionId_index ON results_sections');
		DB::execute('DROP INDEX sectionId_studentId_index ON results_sections');
		DB::execute('DROP INDEX student_id_section_id_index ON results_sections_condensed');
		DB::execute('DROP INDEX section_id_student_id_index ON results_sections_condensed');
		DB::execute('DROP INDEX studentId_gradeId_index ON results_grades');
		DB::execute('DROP INDEX gradeId_studentId_index ON results_grades');
		DB::execute('DROP INDEX studentId_reviewId_index ON review_results');
		DB::execute('DROP INDEX reviewId_studentId_index ON review_results');
	}
};
