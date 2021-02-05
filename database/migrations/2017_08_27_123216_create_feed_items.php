<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);

        Schema::create('feed_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('feed_id');
            $table->boolean('is_read')->default(false);
            $table->string('url');
            $table->string('title');
            $table->string('author');
            $table->text('content');
            $table->string('image_url')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('feed_id')->references('id')->on('feeds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_items');
    }
}
