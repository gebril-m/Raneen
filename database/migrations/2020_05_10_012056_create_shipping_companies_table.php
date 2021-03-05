<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('fuel');
            $table->string('post');
            $table->string('vat');
            $table->string('cod');
            $table->integer('first_kg_number')->default(1);
            $table->timestamps();
        });
        
        Schema::create('shipping_zones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('zone_name');
            $table->text('areas');
            $table->integer('first_kg');
            $table->integer('additional_kg');
            $table->integer('company_id');
            $table->string('cod_values');
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
        Schema::dropIfExists('shipping_companies');
        Schema::dropIfExists('shipping_zones');
    }
}
