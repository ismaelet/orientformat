<?php

use App\Models\Reviews\Review;

return new class {

	/**
	 * Run the migration
	 */
	public function up(): void {
		Review::findWhere(['slug' => 'start-middleschool'])
			->set(['title' => 'Questionario iniziale di prima o seconda'])
			->save();

		Review::findWhere(['slug' => 'other-highschool'])
			->set(['title' => 'Nuovo questionario iniziale'])
			->save();
	}

	/**
	 * Reverse the migration
	 */
	public function down(): void {
		Review::findWhere(['slug' => 'start-middleschool'])
			->set(['title' => 'Questionario iniziale'])
			->save();

		Review::findWhere(['slug' => 'other-highschool'])
			->set(['title' => 'Questionario iniziale'])
			->save();
	}
};
