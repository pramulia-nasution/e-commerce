<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('image_id');
            $table->enum('image_type',['ACTUAL','THUMBNAIL','MEDIUM','LARGE']);
            $table->integer('width');
            $table->integer('height');
            $table->string('path');
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
        Schema::dropIfExists('images_detail');
    }
}
