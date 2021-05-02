<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('file');
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->dateTime('expiration')->nullable();
            $table->enum('type_file', ['csv', 'pdf', 'doc', 'docx', 'pps', 'ppt', 'xls', 'xlsx',
                                        'pptx', 'jpg', 'jpeg', 'gif', 'png', 'bmp', 'tiff', 'psd', 'mp3', 'mp4',
                                        '3gp','ogg', 'tar', 'zip', 'rar', '7z', 'sql'])->nullable();
            $table->string('file_location');
            $table->string('selecction');
            $table->string('storage');
            $table->integer('parent')->nullable()->unsigned();
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
        Schema::dropIfExists('files');
    }
}
