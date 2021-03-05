<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('price');
            $table->integer('duration');
            $table->boolean('is_active');
            $table->timestamps();
        });
        Schema::create('package_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale');
            $table->string('name');
            $table->text('description');
            $table->integer('package_id');
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
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
        Schema::dropIfExists('packages');
        Schema::dropIfExists('package_translations');

    }
}
