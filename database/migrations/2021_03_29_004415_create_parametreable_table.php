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
        Schema::create('parametreable', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->integer('parameters_id')->unsigned()->nullable();
            $table->integer('parameteable_id');
            $table->string('parameteable_type');
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
        Schema::dropIfExists('parametreable');
    }
}
