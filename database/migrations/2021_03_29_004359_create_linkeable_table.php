<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkeableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linkeable', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->integer('links_id')->unsigned()->nullable();
            $table->integer('linkeable_id')->nullable();
            $table->string('linkeable_type')->nullable();
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
        Schema::dropIfExists('linkeable');
    }
}
