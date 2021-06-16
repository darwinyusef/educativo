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
            $table->integer('rating')->nullable();
            $table->mediumText('confParameter')->nullable(); // expone el tipo de interacción ej(Notas, preguntas, calificaciones, respuesta, ver|archivo, ver|video, ver|leer, ver|comunicar, ver|reunion, descargar, leer, contenido,  )
            $table->string('rol')->nullable();
            $table->string('notification', 100)->nullable();
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
        Schema::dropIfExists('interactions');
    }
}
