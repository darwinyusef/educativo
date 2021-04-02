<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('params', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('param_key');
            $table->text('param_value');
            $table->string('slug', 70)->nullable();
            $table->text('settings')->nullable();
            $table->string('url')->nullable();
            $table->integer('value')->nullable();
            $table->dateTime('timeIn')->nullable();
            $table->dateTime('timeOut')->nullable();
            $table->enum('context', ['core', 'api', 'structure', 'web', 'mobile', 'state', 'admin', 'enum', 'unique', 'personal', 'frecuency', 'publicity']);
            $table->tinyInteger('autoload')->nullable();
            $table->string('frecuency')->nullable();
            $table->integer('parent')->nullable()->unsigned();
            $table->char('especial')->nullable();
            $table->text('html')->nullable();
            $table->text('json')->nullable();
            $table->string('language')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('params');
    }
}
