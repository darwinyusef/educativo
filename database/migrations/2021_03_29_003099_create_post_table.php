<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('slug',100)->nullable();
            $table->string('excerpt',100)->nullable();
            $table->string('title');
            $table->text('content');
            $table->integer('views')->nullable();
            $table->string('password')->nullable();
            $table->string('url')->nullable();
            $table->enum('context', ['attachment','page','post','revision','portfolio','directory','publicity','course','homework','reading','leader','poadcast','video']);
            $table->enum('state', ['published', 'draft', 'pending review'])->nullable();
            $table->dateTime('time_in')->nullable();
            $table->dateTime('time_out')->nullable();
            $table->integer('parent')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('notification',100)->nullable();
            $table->text('meta')->nullable();
            $table->text('json')->nullable();
            $table->text('html')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('parent')->nullable();
            $table->string('language')->nullable();

            $table->timestamps();
            $table->softDeletes();


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
        Schema::dropIfExists('post');
    }
}
