<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key');
            $table->string('value');
            $table->timestamps();
        });
        // DB::table('main_settings')->insert([
        //     'key' => 'point_value',
        //     'value' => '0.02'
        // ],[
        //     'key' => 'free_shipping',
        //     'value' => '1000'
        // ],[
        //     'key' => 'cancel_orders_status',
        //     'value' => ''
        // ]
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_settings');
    }
}
