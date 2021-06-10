<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonoableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxonoable', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->integer('taxonos_id')->unsigned()->nullable();
            $table->integer('taxonoable_id')->nullable();
            $table->string('taxonoable_type')->nullable();
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
        Schema::dropIfExists('taxonoable');
    }
}
