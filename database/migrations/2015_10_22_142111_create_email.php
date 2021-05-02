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
            $table->increments('id');
            $table->string('asunto');
            $table->longText('contenido');
            $table->integer('sent');
            $table->string('from');
            $table->string('to');
            $table->string('cc');
            $table->string('idType');
            $table->enum('type', ['service','assigned', 'problem', 'new_user', 'create', 'edit', 'delete','calendar', 'comment']);
            $table->integer('user_id')->unsigned()->nullable();
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
