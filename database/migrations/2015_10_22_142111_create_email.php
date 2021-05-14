<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email', function(Blueprint $table){
            $table->id();
            $table->string('uuid')->unique();
            $table->string('asunto')->nullable();
            $table->longText('contenido')->nullable();
            $table->integer('sent')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('cc')->nullable();
            $table->string('idType')->nullable();
            $table->enum('type', ['service','assigned', 'problem', 'new_user', 'create', 'edit', 'delete','calendar', 'comment'])->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('email');
    }
}
