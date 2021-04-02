<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('url');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('notes')->nullable();
            $table->string('icon')->nullable();
            $table->enum('location', ['header','footer','nav','mobile','social','social_footer', 'mobile_footer', 'left_admin', 'top_admin', 'rigth_admin'])->nullable();
            $table->string('target')->nullable();
            $table->string('visible')->nullable();
            $table->integer('parent')->nullable();
            $table->string('param')->nullable();
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
        Schema::dropIfExists('links');
    }
}
