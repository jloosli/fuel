<?php

use Illuminate\Database\Migrations\Migration;

class UpdateVouchersUseUuid extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::statement('ALTER TABLE  `vouchers` CHANGE  `id`  `id` CHAR( 13 ) NOT NULL');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB::statement('ALTER TABLE  `vouchers` CHANGE  `id`  `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT');
	}

}
