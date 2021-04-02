<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteractionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('slug', 100)->nullable();
            $table->text('interaction')->nullable();
            $table->text('response')->nullable();
            $table->text('context')->nullable();
            $table->integer('value')->nullable();
            $table->string('notification', 100)->nullable();
            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users');
            $table->unsignedBigInteger('courses_id')->nullable();
            $table->foreign('courses_id')->references('id')->on('courses');
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
        Schema::dropIfExists('interactions');
    }
}
