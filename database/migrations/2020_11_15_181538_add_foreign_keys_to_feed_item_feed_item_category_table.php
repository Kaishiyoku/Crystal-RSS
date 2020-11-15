<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFeedItemFeedItemCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('feed_item_feed_item_category')->delete();

        Schema::table('feed_item_feed_item_category', function (Blueprint $table) {
            $table->foreign('feed_item_id')->references('id')->on('feed_items');
            $table->foreign('feed_item_category_id')->references('id')->on('feed_item_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feed_item_feed_item_category', function (Blueprint $table) {
            $table->dropForeign('feed_item_feed_item_category_feed_item_category_id_foreign');
            $table->dropForeign('feed_item_feed_item_category_feed_item_id_foreign');
            $table->dropIndex('feed_item_feed_item_category_feed_item_category_id_foreign');
            $table->dropIndex('feed_item_feed_item_category_feed_item_id_foreign');
        });
    }
}
