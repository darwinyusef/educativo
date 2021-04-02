<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('content')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
            $table->string('password',100)->nullable();
            $table->string('calification')->nullable();
            $table->string('excerpt',100)->nullable();
            $table->string('view',100)->nullable();
            $table->integer('order')->nullable();
            $table->integer('urlInbox')->nullable();
            $table->dateTime('timeIn')->nullable();
            $table->dateTime('timeOut')->nullable();
            $table->text('confParameter')->nullable();
            $table->string('assing')->nullable();
            $table->string('classroom')->nullable();
            $table->string('classroomText')->nullable();
            $table->string('address')->nullable();
            $table->integer('timeLine')->nullable();
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
        Schema::dropIfExists('contents');
    }
}
