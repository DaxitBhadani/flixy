<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('title');
            $table->integer('content_type');
            $table->string('desc');
            $table->string('duration');
            $table->integer('year');
            $table->float('rating');
            $table->integer('language');
            $table->string('genres');
            $table->string('trailer_id');
            $table->string('verticle_poster');
            $table->string('horizontal_poster');
            $table->integer('feature')->default('0');
            $table->integer('view_count')->default('0');
            $table->integer('share_count')->default('0');
            $table->integer('download_count')->default('0');
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
        Schema::dropIfExists('contents');
    }
};
