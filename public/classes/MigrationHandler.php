<?php


namespace Palasthotel\WordPress\MigrateToGutenberg;


use Palasthotel\WordPress\MigrateToGutenberg\Interfaces\Migration;
use Palasthotel\WordPress\MigrateToGutenberg\Migrations\WPBakeryMigration;

class MigrationHandler extends _Component {

	/**
	 * @var Migration[]
	 */
	private array $migrations = [];

	function onCreate() {
		add_action("admin_init", function(){
			do_action(Plugin::ACTION_REGISTER_MIGRATIONS, $this);
			$this->register(new WPBakeryMigration());
		});
	}

	public function register(Migration $migration): bool {
		if(isset($this->migrations[$migration->id()])){
			error_log("Migration id is already registered: ".$migration->id());
			return false;
		}
		$this->migrations[$migration->id()] = $migration;
		return true;
	}

	/**
	 * @return Migration[]
	 */
	public function getMigrations(): array {
		return $this->migrations;
	}
}