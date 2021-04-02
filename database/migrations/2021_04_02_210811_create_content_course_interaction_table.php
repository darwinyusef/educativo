<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentCourseInteractionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_course_interaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('courses_id');
            $table->foreign('courses_id')->references('id')->on('courses')->nullable();
            $table->unsignedBigInteger('contents_id');
            $table->foreign('contents_id')->references('id')->on('contents')->nullable();
            $table->unsignedBigInteger('interactions_id');
            $table->foreign('interactions_id')->references('id')->on('interactions')->nullable();
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
        Schema::dropIfExists('content_course_interaction');
    }
}
