<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('vouchers', function($table) {
            $table->increments('id');
            $table->integer('check_id');
            $table->string('issued_to');
            $table->decimal('amount',5,2);
            $table->tinyInt('redeemed')->default(0);
            $table->timestamps();
        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
