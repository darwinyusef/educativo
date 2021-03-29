<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('content')->nullable();
            $table->text('description')->nullable();
            $table->string('slug',100)->nullable();
            $table->string('password',100)->nullable();
            $table->string('calification')->nullable();
            $table->string('excerpt',100)->nullable();
            $table->string('view',100)->nullable();
            $table->string('state',100)->nullable();
            $table->integer('views')->nullable();
            $table->integer('order')->nullable();
            $table->integer('urlInbox',255)->nullable();
            $table->text('meta')->nullable();
            $table->text('json')->nullable();
            $table->boolean('status')->nullable();
            $table->string('language')->nullable();


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
        Schema::dropIfExists('content');
    }
}
