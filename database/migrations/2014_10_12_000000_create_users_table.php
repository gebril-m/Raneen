<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('verification_code')->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_admin')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(0);
            $table->string('gender')->nullable()->default(null);
            $table->date('dob')->nullable()->default(null);
            $table->string('contact_number')->nullable()->default(null);
            $table->string('provider')->nullable()->default(null);
            $table->string('order_status_permissions')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
