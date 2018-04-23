<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtImagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ot_images', function (Blueprint $table) {
			$table->increments('id');
			$table->string('spherical_id', 50)->unique();
			$table->integer('tour_id')->unsigned()->nullable();
			$table->string('title', 100);
			$table->string('image_url', 200);
			$table->text('description');
			$table->boolean('is_public');
			$table->string('view_url', 200);
			$table->string('created_by')->nullable();
			$table->string('updated_by')->nullable();
			$table->timestamps();
			$table->foreign('tour_id')->references('id')->on('ot_tours')->onDelete('set null')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ot_images');
	}
}
