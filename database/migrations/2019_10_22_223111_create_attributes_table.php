<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->boolean('is_active')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::create('attribute_translations', function (Blueprint $table) {
            $table->string('locale');
            $table->unsignedBigInteger('attribute_id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('attribute_product', function (Blueprint $table) {
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('product_id');
            $table->text('quantity')->nullable();
            $table->string('picture')->nullable();
            $table->string('code')->nullable();
            $table->float('price')->default(0);
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
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('attribute_translations');
        Schema::dropIfExists('attribute_product');
    }
}
