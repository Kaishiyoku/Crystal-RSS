<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustTitleUniquenessAtFeedItemCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feed_item_categories', function (Blueprint $table) {
            $table->dropUnique(['title']);

            $table->unique(['user_id', 'title']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feed_item_categories', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'title']);

            $table->unique(['title']);
        });
    }
}
