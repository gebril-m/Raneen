<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManufacturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacturers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('logo');

            $table->timestamps();
        });

        Schema::create('manufacturer_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale');

            $table->integer('manufacturer_id');
            $table->string('name');

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
        Schema::dropIfExists('manufacturer_translations');
        Schema::dropIfExists('manufacturers');
    }
}
