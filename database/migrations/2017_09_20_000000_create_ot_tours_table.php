<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtToursTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ot_tours', function (Blueprint $table) {
			$table->increments('id')->unsigned()->unique();
			$table->string('tour_key', 50)->unique()->nullable();
			$table->integer('plan_image_id')->unsigned()->nullable();
			$table->string('title', 100);
			$table->string('view_url', 200);
			$table->string('xml_url', 200);
			$table->text('description');
			$table->text('config');
			$table->boolean('is_public');
			$table->string('created_by')->nullable();
			$table->string('updated_by')->nullable();
			$table->timestamps();
			$table->foreign('plan_image_id')->references('id')->on('ot_plan_images')->onDelete('set null')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ot_tours');
	}
}
