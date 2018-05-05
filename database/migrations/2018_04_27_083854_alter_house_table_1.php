<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHouseTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ot_tours', function (Blueprint $table) {
            $table->integer('price')->unsigned();
            $table->integer('area')->unsigned();
            $table->integer('num_bedrooms')->unsigned();
            $table->integer('num_toilets')->unsigned();
            $table->integer('district')->unsigned();
            $table->float('latitude', 8, 6);
            $table->float('longitude', 8, 6);
            $table->text('amenities');
            $table->text('project_facility');
            $table->text('traffic');
            $table->text('notice');
            $table->text('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ot_tours', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('area');
            $table->dropColumn('num_bedrooms');
            $table->dropColumn('num_toilets');
            $table->dropColumn('district');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('amenities');
            $table->dropColumn('project_facility');
            $table->dropColumn('traffic');
            $table->dropColumn('notice');
            $table->dropColumn('address');
        });
    }
}
