<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ComboCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_combo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('combo_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('combo_id')->references('id')->on('combos');
            $table->foreign('category_id')->references('id')->on('categories');
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
