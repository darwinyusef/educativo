<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametreableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameterable', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->integer('parameters_id')->unsigned()->nullable();
            $table->integer('parameterable_id')->nullable();
            $table->string('parameterable_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameterable');
    }
}
