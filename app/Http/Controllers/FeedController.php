<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessFeedItems;
use App\Libraries\ManualPaginator;
use App\Models\Feed;
use App\Models\FeedItem;
use App\Models\UpdateLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        $readFeedItems = auth()->user()->feedItems()->read()->with('categories')->paginate(env('NUMBER_OF_ITEMS_PER_PAGE'));

        return view('feed.history', compact('totalCountReadFeedItems', 'readFeedItems'));
    }

    public function details(FeedItem $feedItem)
    {
        return view('feed.details', compact('feedItem'));
    }

    public function markAllAsRead($categoryId = null)
    {
        $unreadFeedItems = $this->getUnreadFeedItems($categoryId);
        $minNumber = (int) env('DEFERRED_MIN_NUMBER');
        $date = Carbon::now();

        if (env('DEFERRED_MARK_AS_READ') && $unreadFeedItems->count() > $minNumber) {
            $unreadFeedItems = new ManualPaginator($unreadFeedItems->get(), (int) env('DEFERRED_PER_PAGE'));

            foreach($unreadFeedItems->pages() as $items) {
                ProcessFeedItems::dispatch($items, $date);
            }
        } else {
            foreach ($unreadFeedItems->get() as $feedItem) {
                $feedItem->read_at = $date;

                $feedItem->save();
            }
        }

        flash()->success(__('feed.mark_all_as_read.success'));

        return redirect()->route('feed.index');
    }

    public function toggleFeedItemStatus(Request $request)
    {
        $ids = $request->get('feedIds') ?? [];

        $feedItems = auth()->user()->feedItems()->whereIn('id', $ids);

        foreach ($feedItems->get() as $feedItem) {
            if (empty($feedItem->read_at)) {
                $feedItem->read_at = Carbon::now();
            } else {
                $feedItem->read_at = null;
            }

            $feedItem->save();
        }

        flash()->success(__('feed.index.toggle_status.success'));

        return redirect()->back();
    }

    public function searchShow()
    {
        return view('feed.search_show');
    }

    public function searchResult(Request $request)
    {
        $foundFeedItemsFromIndex = FeedItem::search($request->get('query'))->where('user_id', auth()->user()->id)->orderBy('date', 'desc')->paginate(env('NUMBER_OF_ITEMS_PER_PAGE'));

        return view('feed.search_result', compact('foundFeedItemsFromIndex'));
    }

    private function baseIndex($categoryId = null)
    {
        $unreadFeedItemsBase = $this->getUnreadFeedItems($categoryId);

        $totalCountUnreadFeedItems = $categoryId == null ? $unreadFeedItemsBase->count() : $this->getUnreadFeedItems()->count();
        $unreadFeedItems = $unreadFeedItemsBase->paginate(env('NUMBER_OF_ITEMS_PER_PAGE'));

        $categories = auth()->user()->categories();
        $currentCategoryId = $categoryId;
        $latestUpdateLog = UpdateLog::orderBy('created_at', 'asc')->first();

        return view('feed.index', compact('totalCountUnreadFeedItems', 'unreadFeedItems', 'categories', 'currentCategoryId', 'latestUpdateLog'));
    }

    private function getUnreadFeedItems($categoryId = null)
    {
        $feedIds = Feed::when($categoryId == null, function ($query) {
            return $query;
        }, function ($query) use ($categoryId) {
            return $query->whereCategoryId($categoryId);
        })->pluck('id');

        $feedItems = auth()->user()->feedItems()->unread()->whereIn('feed_id', $feedIds)->with('categories');

        return $feedItems;
    }
}