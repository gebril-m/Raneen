<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{

    public function up()
    {

        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email');
            $table->integer('country_id');
            $table->string('address');
            $table->string('lat')->nullable()->default(null);
            $table->string('lng')->nullable()->default(null);
            $table->integer('city_id');
            $table->string('state');
            $table->string('ship_to');
            $table->integer('location_id')->nullable();
            $table->integer('postal_code');
            $table->integer('status_id')->nullable()->default(1);
            $table->unsignedBigInteger('user_id');
            $table->integer('company_id')->nullable();
            $table->integer('zone_id')->nullable();
            $table->string('shipping_amount')->nullable();
            $table->timestamps('shipped_at')->nullable();
            $table->timestamps();
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->string('attribute_id')->default(0);
            $table->integer('quantity');
            $table->float('price');
            $table->float('total');
            $table->float('price_after')->nullable()->default(null);
            $table->string('cupon')->nullable()->default(null);
            $table->float('discount')->nullable()->default(0);
            $table->string('discount_type')->nullable()->default(null);
            $table->integer('reward_points')->default(0);
            $table->integer('is_return')->nullable();
            $table->integer('return_reason_id')->nullable();
            $table->timestamp('return_date')->nullable();
            $table->integer('return_bank')->default(0);
            $table->timestamps();
        });

        Schema::create('order_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale');
            $table->string('name');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('order_status');
    }

}
