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
            $table->string('uuid',45);
            $table->text('json')->nullable();
            $table->string('name',45)->nullable();
            $table->string('lastname',45)->nullable();
            $table->string('email')->unique();
            $table->string('mobile',45)->nullable();
            $table->string('displayName', 100)->nullable();
            $table->mediumText('LastMs')->nullable();
            $table->string('slug', 70)->nullable();
            $table->string('status',45)->nullable();
            $table->string('nicname',45)->nullable();
            $table->string('about',45)->nullable();
            $table->string('temporalTocken')->nullable();
            $table->tinyInteger('onlyDelete')->nullable();
            $table->integer('town')->nullable();
            $table->string('photo')->nullable();
            $table->char('language')->nullable();
            $table->char('especialParam')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',45)->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
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
