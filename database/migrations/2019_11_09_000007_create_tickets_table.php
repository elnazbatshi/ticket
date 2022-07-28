<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
           $table->integer('author_id')->unsigned();
           $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->longText('content')->nullable();
//            $table->string('author_name')->nullable();
//            $table->string('author_email')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
