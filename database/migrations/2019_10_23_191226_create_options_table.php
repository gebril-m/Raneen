<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    public function up()
    {
        
        Schema::create('fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('options_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('option_id');
            $table->string('value');
            $table->timestamps();
        });

        Schema::create('options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('field_id');
            $table->string('name');
            $table->boolean('required')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::create('option_product', function (Blueprint $table) {
            $table->unsignedBigInteger('option_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('option_value_id')->nullable();
        });

    }

    public function down()
    {
        Schema::dropIfExists('fields');
        Schema::dropIfExists('options_values');
        Schema::dropIfExists('options');
        Schema::dropIfExists('option_product');
    }
}
