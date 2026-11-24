<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_publications', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('platform_id');
            $table->unsignedInteger('file_id');
            $table->text('comment')->nullable();
            $table->dateTime('publication_date');
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
        Schema::dropIfExists('file_publications');
    }
}
