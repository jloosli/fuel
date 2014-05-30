<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('checks', function($table) {
            $table->increments('id');
            $table->decimal('amount',5,2);
            $table->integer('check_no')->unique();
            $table->decimal('total_issued',5,2);
            $table->decimal('total_redeemed',5,2)->default(0);
            $table->date('date_issued');
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
