<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name', 45)->nullable();
            $table->string('lastname', 45)->nullable();
            $table->integer('cardId')->nullable();
            $table->string('email')->unique();
            $table->string('mobile', 45)->nullable();
            $table->string('displayName', 100)->nullable();
            $table->mediumText('LastMs')->nullable();
            $table->string('slug', 70)->nullable();
            $table->string('nickname', 45)->nullable();
            $table->text('about')->nullable();
            $table->string('temporalTocken')->nullable();
            $table->tinyInteger('onlyDelete')->nullable();
            $table->integer('town')->nullable();
            $table->string('photo')->nullable();
            $table->char('especialParam')->nullable();
            $table->char('pago')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('users');
    }
}
