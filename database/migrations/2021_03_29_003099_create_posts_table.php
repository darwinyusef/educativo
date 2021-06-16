<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('slug',100)->nullable();
            $table->string('excerpt',100)->nullable();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->integer('views')->nullable();
            $table->string('password')->nullable();
            $table->string('url')->nullable();
            $table->enum('context', ['attachment','page','post','revision','portfolio','directory','publicity','course','homework','reading','leader','poadcast','video'])->nullable();
            $table->enum('state', ['published', 'draft', 'pending review'])->nullable();
            $table->dateTime('time_in')->nullable();
            $table->dateTime('time_out')->nullable();
            $table->string('notification',100)->nullable();
            $table->text('meta')->nullable();
            $table->text('json')->nullable();
            $table->text('html')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('parent')->nullable();
            $table->string('language')->nullable();
            $table->integer('send')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
