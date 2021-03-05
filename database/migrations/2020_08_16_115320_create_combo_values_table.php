<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComboValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combo_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('num');
            $table->bigInteger('percentage');
            $table->bigInteger('combo_id')->unsigned();
            $table->foreign('combo_id')->references('id')->on('combos');
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
        Schema::dropIfExists('combo_values');
    }
}
