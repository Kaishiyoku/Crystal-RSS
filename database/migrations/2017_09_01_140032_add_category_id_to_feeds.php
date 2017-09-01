<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryIdToFeeds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feeds', function (Blueprint $table) {
            $table->integer('category_id')->nullable()->unsigned();
        });

        // create a default category for each user to select this as the default one for existing feeds
        $users = User::all();

        foreach ($users as $user) {
            $category = new Category();
            $category->title = trans('category.default_title');
            $user->categories()->save($category);

            $feeds = $user->feeds();

            foreach ($feeds->get() as $feed) {
                $feed->category_id = $category->id;
                $feed->save();
            }
        }

        Schema::table('feeds', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->change();

            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feeds', function (Blueprint $table) {
            $table->dropForeign(['category_id']);

            $table->dropColumn('category_id');
        });
    }
}
