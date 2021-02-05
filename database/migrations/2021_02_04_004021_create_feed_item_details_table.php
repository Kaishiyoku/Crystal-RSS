<?php

use App\Models\FeedItem;
use App\Models\FeedItemDetail;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateFeedItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_item_details', function (Blueprint $table) {
            $table->id('feed_item_id');
            $table->longText('content');
            $table->longText('raw_json')->nullable();
        });

        $consoleOutput = new ConsoleOutput();

        FeedItem::orderBy('id')->select(['id', 'content', 'raw_json'])->chunk(500, function ($feedItems) use ($consoleOutput) {
            foreach ($feedItems as $feedItem) {
                $feedItemDetail = new FeedItemDetail();
                $feedItemDetail->feed_item_id = $feedItem->id;
                $feedItemDetail->content = $feedItem->content;
                $feedItemDetail->raw_json = $feedItem->raw_json;

                $feedItemDetail->save();
            }

            $consoleOutput->writeln("<info>  Copied feed item details until ID {$feedItems->last()->id}</info>");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_item_details');
    }
}
