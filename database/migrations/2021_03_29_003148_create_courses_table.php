<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('slug',100)->nullable();
            $table->string('excerpt',100)->nullable();
            $table->string('course',100)->nullable();
            $table->text('description')->nullable();
            $table->string('classroom')->nullable();
            $table->string('level',100)->nullable();
            $table->string('descriptionTask',100)->nullable();
            $table->string('amountTask',100)->nullable();
            $table->dateTime('timeOut')->nullable();
            $table->integer('calification')->nullable();
            $table->integer('subject')->nullable();
            $table->string('notification',100)->nullable();
            $table->text('meta')->nullable();
            $table->text('json')->nullable();
            $table->text('html')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('parent')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
