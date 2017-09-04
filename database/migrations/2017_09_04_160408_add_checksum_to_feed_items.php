<?php

use App\Models\FeedItem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChecksumToFeedItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);

        // adding a checksum as a unique key is a breaking change and therefor all existing feed items must be deleted
        FeedItem::truncate();

        Schema::table('feed_items', function (Blueprint $table) {
            $table->string('checksum');

            $table->unique(['feed_id', 'checksum']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feed_items', function (Blueprint $table) {
            $table->dropColumn('checksum');
        });
    }
}
