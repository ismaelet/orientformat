<?php

namespace App\Support\Database;

use LegacyModels\Framework\Migration;

class MigrationHandler {

	/**
	 * Execute all the committed migrations
	 */
	public static function migrateAll() {
		if (!Migration::tableExists()) {
			self::createMigrationsTable();
		}

		$batchId = Migration::max('batch_id') + 1;

		foreach (scan('/database/migrations', 'php') as $migrationModule) {
			$migrationModuleName = basename(explode('.php', $migrationModule)[0]);

			if (!Migration::findWhere(['name' => $migrationModuleName])) {
				$migration = include_once($migrationModule);
				$migration->up();

				Migration::add([
					'name' => $migrationModuleName,
					'batch_id' => $batchId,
				]);
			}
		}

		self::disableMigrate();
	}

	/**
	 * Execute a rollback of the last batch
	 */
	public static function rollback() {
		$batchId = Migration::max('batch_id');

		if ($batchId) {

			$batchMigrations = Migration::where(['batch_id' => $batchId]);

			foreach ($batchMigrations as $migration) {
				$migrationFile = server_path('/database/migrations/' . $migration->name . '.php');
				$migrationModule = include_once($migrationFile);
				$migrationModule->down();
				$migration->delete();
			}
		}

		self::disableRollback();
	}

	/**
	 * Create the migrations table
	 */
	private static function createMigrationsTable(): void {
		Migration::create(function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->int('batch_id');
			$table->timestamp();
		});
	}

	/**
	 * Set the migrate status to false
	 */
	private static function disableMigrate() {
		$envFilePath = server_path('/.env');
		$envContent = preg_replace('/^MIGRATE=.*$/m', 'MIGRATE=false', file_get_contents($envFilePath));

		file_put_contents($envFilePath, $envContent);
	}

	/**
	 * Set the rollback status to false
	 */
	private static function disableRollback() {
		$envFilePath = server_path('/.env');
		$envContent = preg_replace('/^ROLLBACK=.*$/m', 'ROLLBACK=false', file_get_contents($envFilePath));

		file_put_contents($envFilePath, $envContent);
	}
}
