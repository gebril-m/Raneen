<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->float('weight')->default(0);
            $table->float('length')->default(0);
            $table->float('width')->default(0);
            $table->float('height')->default(0);
            $table->integer('brand_id')->nullable();
            $table->boolean('is_bundle')->default(0);
            $table->boolean('is_combo')->default(0);
            $table->string('combo_discounts')->nullable();
            $table->string('item_id')->nullable();
            $table->string('axapta_code')->nullable();
            $table->string('barcode')->nullable();
            $table->string('primary_vendor_id')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('manufacturer_id')->nullable();
            $table->integer('stock');
            $table->integer('minimum_stock')->default(0);
            $table->double('price');

            $table->boolean('is_active')->default(true);
            $table->boolean('is_point')->default(true);

            $table->boolean('up_selling')->default(false); # Combo price //TODO
            $table->boolean('on_sale')->default(false);
            $table->double('before_price')->default(0);
            $table->boolean('is_hot')->default(false);
            $table->double('hot_price')->default(0);
            $table->timestamp('hot_starts_at')->nullable();
            $table->timestamp('hot_ends_at')->nullable();
            $table->timestamp('sale_ends_at')->nullable();

            $table->boolean('return_allowed')->default(false);
            $table->integer('return_duration')->default(0);
            $table->string('return_policy')->nullable();

            $table->integer('reward_points')->default(0);
            $table->timestamp('bundle_start')->nullable();
            $table->timestamp('bundle_end')->nullable();
            // Combo Fields
            $table->integer('combo_2')->nullable();
            $table->integer('combo_3')->nullable();
            $table->integer('combo_4')->nullable();
            $table->integer('combo_5')->nullable();
            $table->integer('combo_5_free')->nullable();

            $table->timestamps();
        });
        Schema::create('product_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale');

            $table->integer('product_id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->longText('description');

            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();

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
        Schema::dropIfExists('product_translations');
        Schema::dropIfExists('products');
    }
}
