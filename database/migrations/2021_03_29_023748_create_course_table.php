<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug',100)->nullable();
            $table->string('excerpt',100)->nullable();
            $table->string('course',100)->nullable();
            $table->text('description')->nullable();
            $table->string('room',100)->nullable();
            $table->string('level',100)->nullable();
            $table->string('descriptionTask',100)->nullable();
            $table->string('amountTask',100)->nullable();
            $table->integer('calification')->nullable();
            $table->text('json')->nullable();
            $table->integer('subject',255)->nullable();
            $table->string('parentId',100)->nullable();
            $table->string('notification',100)->nullable();
            $table->boolean('status')->nullable();
            $table->string('language')->nullable();
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
        Schema::dropIfExists('course');
    }
}
