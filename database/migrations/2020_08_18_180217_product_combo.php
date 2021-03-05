<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductCombo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combo_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('combo_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('combo_id')->references('id')->on('combos');
            $table->foreign('product_id')->references('id')->on('products');
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
