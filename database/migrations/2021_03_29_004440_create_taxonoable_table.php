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
            $table->uuid('id')->primary();
            $table->integer('taxonoables_id')->unsigned()->nullable();
            $table->integer('taxonoableable_id');
            $table->string('taxonoableable_type');
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
