<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{

    public function up()
    {
        Schema::create('logs', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('msg', 255);
            $table->string('model', 255)->nullable()->default(null);
            $table->unsignedBigInteger('model_id')->nullable()->default(null);
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
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
        Schema::dropIfExists('logs');
    }
    
}
