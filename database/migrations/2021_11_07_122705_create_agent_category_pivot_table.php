<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentCategoryPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_category', function (Blueprint $table) {
            $table->unsignedInteger('agent_id');
            $table->unsignedInteger('category_id');

            $table->foreign('agent_id','agent_id_fk_513249')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id','category_id_fk_583549')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_category');
    }
}
