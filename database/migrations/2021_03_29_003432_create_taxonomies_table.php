<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonomiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('slug', 70)->nullable();
            $table->string('taxonomy');
            $table->text('description')->nullable();
            $table->text('meta')->nullable();
            $table->enum('type', ['category', 'item', 'tag', 'publicity', 'external', 'landingpage'])->nullable();
            $table->integer('parent')->nullable();
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
        Schema::dropIfExists('taxonomies');
    }
}
