<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');

			$table->string('sku', 255);
			$table->string('name', 255);
			$table->float('price');
			$table->integer('quantity');
			$table->integer('user_id');

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
		Schema::drop('products');
	}

}
