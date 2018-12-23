<?php

namespace App\Http\Controllers;

use App\Enums\VoteStatus;
use App\Jobs\ProcessFeedItems;
use App\Libraries\ManualPaginator;
use App\Models\Category;
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
        // check if there are any unread feed items
        $feedItems = $this->getUnreadFeedItems($id);

        if ($feedItems->count() == 0) {
            return redirect()->route('feed.index');
        }

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
        $this->authorize('viewDetails', $feedItem);

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
        $feeds = $this->getFeedsForSelect();
        $feedIds = auth()->user()->feeds()->pluck('id');

        return view('feed.search_show', compact('feeds', 'feedIds'));
    }

    public function searchResult(Request $request)
    {
        $rules = [
            'term' => ['required'],
            'feed_ids' => ['array'],
            'date_from' => ['nullable', 'date_format:' . __('common.date_formats.date')],
            'date_till' => ['nullable', 'date_format:' . __('common.date_formats.date')],
        ];

        $request->validate($rules);

        $dateFrom = createDateFromStr($request->get('date_from'));
        $dateTill = createDateFromStr($request->get('date_till'));

        $feeds = $this->getFeedsForSelect();

        $requestFeedIds = $request->get('feed_ids') ?? [];

        $filteredFeedIds = auth()->user()->feeds()->pluck('id')->toArray();
        $filteredFeedIds = array_filter($requestFeedIds, function ($requestFeedId) use ($filteredFeedIds) {
            return in_array($requestFeedId, $filteredFeedIds);
        });
        $feedIds = $filteredFeedIds;

        $filteredFeedItems = auth()->user()->feedItems()
            ->whereIn('feed_id', $filteredFeedIds);

        if ($dateFrom) {
            $filteredFeedItems = $filteredFeedItems->where('date', '>=', $dateFrom->startOfDay());
        }

        if ($dateTill) {
            $filteredFeedItems = $filteredFeedItems->where('date', '<=', $dateTill->endOfDay());
        }

        $foundFeedItemsFromIndex = FeedItem::search($request->get('term'))
            ->constrain($filteredFeedItems)
            ->orderBy('date', 'desc')
            ->paginate(env('NUMBER_OF_ITEMS_PER_PAGE'));

        return view('feed.search_result', compact('feeds', 'foundFeedItemsFromIndex', 'feedIds'));
    }

    public function voteUp(Request $request, FeedItem $feedItem)
    {
        return $this->vote($request, $feedItem, VoteStatus::Up);
    }

    public function voteDown(Request $request, FeedItem $feedItem)
    {
        return $this->vote($request, $feedItem, VoteStatus::Down);
    }

    private function vote(Request $request, FeedItem $feedItem, string $voteStatus)
    {
        $this->authorize('vote', $feedItem);

        if ($feedItem->vote_status == $voteStatus) {
            $voteStatus = VoteStatus::None;
        }

        $feedItem->vote_status = $voteStatus;
        $feedItem->save();

        if ($request->ajax()) {
            return response()->json(['vote_status' => $voteStatus]);
        }

        flash(__('feed.vote.success'))->success();

        return redirect()->back();
    }

    private function baseIndex($categoryId = null)
    {
        $unreadFeedItemsBase = $this->getUnreadFeedItems($categoryId);

        $totalCountUnreadFeedItems = $categoryId == null ? $unreadFeedItemsBase->count() : $this->getUnreadFeedItems()->count();
        $unreadFeedItems = $unreadFeedItemsBase->paginate(env('NUMBER_OF_ITEMS_PER_PAGE'));

        $categories = auth()->user()->categories();
        $currentCategoryId = $categoryId;
        $latestUpdateLog = UpdateLog::orderBy('created_at', 'asc')->first();

        $categoryDropdownTranslation = $currentCategoryId == null ? __('feed.index.all_categories') : auth()->user()->categories()->find($currentCategoryId)->title;

        return view('feed.index', compact('totalCountUnreadFeedItems', 'unreadFeedItems', 'categories', 'currentCategoryId', 'latestUpdateLog', 'categoryDropdownTranslation'));
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

    private function getFeedsForSelect()
    {
        return auth()->user()->categories()->with('feeds')->get()->mapWithKeys(function (Category $category) {
            return [
                $category->title => $category->feeds()->orderBy('title')->get()->mapWithKeys(function (Feed $feed) {
                    return [$feed->id =>  $feed->title];
                })->toArray(),
            ];
        })->toArray();
    }
}