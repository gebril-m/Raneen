<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('areas')->nullable();
            $table->timestamps();
        });
        Schema::create('inventory_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('locale');

            $table->bigInteger('inventory_id');
            $table->string('name');

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
        Schema::dropIfExists('inventory_translations');
        Schema::dropIfExists('inventories');
    }
}
