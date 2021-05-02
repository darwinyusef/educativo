<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComunicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunications', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->datetime('expiration')->nullable();
            $table->string('url')->nullable();
            $table->string('target')->default('_self')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->integer('progress')->nullable();
            $table->string('rol')->nullable();
            $table->string('param')->nullable();
            $table->text('html')->nullable();
            $table->text('json')->nullable();
            $table->string('language')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('comunications');
    }
}
