<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('slogan')->nullable();
            $table->string('description')->nullable();
            $table->string('keywords')->nullable();
            $table->string('author')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('active');
            $table->longText('css')->nullable();
            $table->longText('config')->nullable();
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
        Schema::drop('brands');
    }
}
