<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ref')->unique();
            $table->decimal('price');
            $table->decimal('discount');
            $table->string('image');
            $table->unsignedBigInteger('category_id');
            $table->decimal('total');
            $table->timestamps();

           $table->foreign('category_id')->references('id')->on('table_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_products');
    }
}
