<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->string('color')->nullable();

//            $table->integer('agent_id')->unsigned();
//            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
//            $table->integer('customer_id')->unsigned();
//            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
