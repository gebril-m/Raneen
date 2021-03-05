<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('in_header')->default(true);

            $table->string('icon')->nullable();
            $table->string('banner')->nullable();
            $table->string('return_policy')->nullable();
            $table->integer('arrange')->default(0);
            $table->integer('shipping_value')->default(0);
            $table->integer('shipping_type')->default(0);
            $table->timestamps();
        });

        Schema::create('category_translations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('category_id')->unsigned();
            $table->string('locale');

            $table->string('slug');

            $table->unique(['locale', 'slug']);

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

//            $table->foreign('category_id')
//                ->references('id')->on('categories')
//                ->onDelete('cascade')
//            ;

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
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('categories');
    }
}
