<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\FeedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;

class FeedController extends Controller
{
    public function index()
    {
        return $this->baseIndex();
    }

    public function category($id)
    {
        return $this->baseIndex($id);
    }

    public function history()
    {
        $totalCountReadFeedItems = auth()->user()->feedItems()->read()->count();
        $readFeedItems = auth()->user()->feedItems()->read()->paginate(env('NUMBER_OF_ITEMS_PER_PAGE'));

        return view('feed.history', compact('totalCountReadFeedItems', 'readFeedItems'));
    }

    public function markAllAsRead($categoryId = null)
    {
        $unreadFeedItems = $this->getUnreadFeedItems($categoryId);

        foreach ($unreadFeedItems->get() as $unreadFeedItem) {
            $unreadFeedItem->is_read = true;
            $unreadFeedItem->read_at = Carbon::now();

            $unreadFeedItem->save();
        }

        flash()->success(trans('feed.mark_all_as_read.success'));

        return redirect()->back();
    }

    public function toggleFeedItemStatus(Request $request)
    {
        $ids = $request->get('feedIds') ?? [];

        $feedItems = auth()->user()->feedItems()->whereIn('id', $ids);

        foreach ($feedItems->get() as $feedItem) {
            $feedItem->is_read = !$feedItem->is_read;

            if ($feedItem->is_Read) {
                $feedItem->read_at = Carbon::now();
            } else {
                $feedItem->read_at = null;
            }

            $feedItem->save();
        }

        flash()->success(trans('feed.index.toggle_status.success'));

        return redirect()->back();
    }

    public function searchShow()
    {
        return view('feed.search_show');
    }

    public function searchResult(Request $request)
    {
        $foundFeedItemsFromIndex = FeedItem::search($request->get('query'))->where('user_id', auth()->user()->id)->paginate(env('NUMBER_OF_ITEMS_PER_PAGE'));

        return view('feed.search_result', compact('foundFeedItemsFromIndex'));
    }

    private function baseIndex($categoryId = null)
    {
        $unreadFeedItemsBase = $this->getUnreadFeedItems($categoryId);

        $totalCountUnreadFeedItems = $categoryId == null ? $unreadFeedItemsBase->count() : $this->getUnreadFeedItems()->count();
        $unreadFeedItems = $unreadFeedItemsBase->paginate(env('NUMBER_OF_ITEMS_PER_PAGE'));

        $categories = auth()->user()->categories();
        $currentCategoryId = $categoryId;

        return view('feed.index', compact('totalCountUnreadFeedItems', 'unreadFeedItems', 'categories', 'currentCategoryId'));
    }

    private function getUnreadFeedItems($categoryId = null)
    {
        $feedIds = Feed::when($categoryId == null, function ($query) {
            return $query;
        }, function ($query) use ($categoryId) {
            return $query->whereCategoryId($categoryId);
        })->pluck('id');

        $feedItems = auth()->user()->feedItems()->unread()->whereIn('feed_id', $feedIds);

        return $feedItems;
    }
}