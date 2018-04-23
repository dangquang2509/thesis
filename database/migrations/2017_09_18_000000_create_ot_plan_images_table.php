<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtPlanImagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ot_plan_images', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title', 100);
			$table->string('image_url', 200);
			$table->text('description');
			$table->string('created_by')->nullable();
			$table->string('updated_by')->nullable();
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
		Schema::dropIfExists('ot_plan_images');
	}
}
