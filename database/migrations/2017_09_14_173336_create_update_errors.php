<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateErrors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('update_errors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('feed_id');
            $table->text('content');

            $table->timestamp('created_at')->nullable();

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
        Schema::dropIfExists('update_errors');
    }
}
