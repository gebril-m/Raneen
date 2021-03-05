<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('cupons', function (Blueprint $table) {            
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('code');
            $table->enum('type', ['p', 'f']);
            $table->integer('amount');
            $table->date('start');
            $table->date('end');
            $table->integer('usage_times');
            $table->integer('user_usage_times');
            $table->integer('min_order');
            $table->boolean('is_active')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::create('cupon_product', function(Blueprint $table){
            $table->integer('cupon_id');
            $table->integer('product_id');
        });

        Schema::create('cupon_category', function(Blueprint $table){
            $table->integer('cupon_id');
            $table->integer('category_id');
        });

        Schema::create('cupon_bundle', function(Blueprint $table){
            $table->integer('cupon_id');
            $table->integer('bundle_id');
        });

        Schema::create('cupons_logs', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('cupon_id')->nullable();
            $table->string('cupon');
            $table->integer('user_id');
            $table->integer('order_id');
            $table->integer('amount_before');
            $table->integer('amount_after')->nullable();
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
        Schema::dropIfExists('cupons');
        Schema::dropIfExists('cupon_product');
        Schema::dropIfExists('cupon_category');
        Schema::dropIfExists('cupon_bundle');
        Schema::dropIfExists('cupons_logs');
    }
}
