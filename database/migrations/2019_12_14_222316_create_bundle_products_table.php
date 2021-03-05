<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBundleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundle_products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('bundle_id');
            $table->bigInteger('product_id');
            $table->bigInteger('quantity');
            $table->bigInteger('discount');

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
        Schema::dropIfExists('bundle_products');
    }
}
