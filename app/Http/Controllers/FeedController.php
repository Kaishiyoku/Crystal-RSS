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
use Illuminate\Support\Collection;

class FeedController extends Controller
{
    public function index()
    {
        return $this->baseIndex();
    }

    public function category($id)
    {
        // check if there are any unread feed items
        $unreadFeedItemsCount = auth()->user()->feeds()->whereCategoryId($id)->withCount(['feedItems' => function ($query) {
            return $query->unread()->keywordFiltered(auth()->user());
        }])->get()->reduce(function ($carry, Feed $feed) {
            return $carry + $feed->feed_items_count;
        }, 0);

        if ($unreadFeedItemsCount == 0) {
            return redirect()->route('feed.index');
        }

        return $this->baseIndex($id);
    }

    public function history()
    {
        $totalCountReadFeedItems = auth()->user()->feedItems()->with('feed')->whereHas('feed')->read()->keywordFiltered(auth()->user())->count();
        $readFeedItems = auth()->user()->feedItems()->with('feed')->whereHas('feed')->read()->keywordFiltered(auth()->user())->with('categories')->paginate($this->getPerPage());

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
        $minNumber = (int) config('feed.deferred_min_number');
        $date = Carbon::now();

        if (config('feed.deferred_mark_as_read') && $unreadFeedItems->count() > $minNumber) {
            $unreadFeedItems = new ManualPaginator($unreadFeedItems->get(), (int) config('feed.deferred_per_page'));

            $unreadFeedItems->pages()->each(function ($items) use ($date) {
                ProcessFeedItems::dispatch($items, $date);
            });
        } else {
            $unreadFeedItems->get()->each(function ($feedItem) use ($date) {
                $feedItem->read_at = $date;

                $feedItem->save();
            });
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
        $dateFormat = 'Y-m-d';

        /*** @var Collection $feeds */
        $feeds = $this->getFeedsForSelect();

        $allFeedIds = collect($feeds)->map(function ($item) {
            return array_keys($item);
        })->flatten();

        $rules = [
            'term' => ['required'],
            'feed_ids' => ['array'],
            'date_from' => ['nullable', 'date_format:' . $dateFormat],
            'date_till' => ['nullable', 'date_format:' . $dateFormat],
        ];

        $validatedData = $request->validate($rules);

        $term = $validatedData['term'];

        // filter out invalid feed-IDs
        $selectedFeedIds = $allFeedIds->filter(function ($feedId) use ($validatedData) {
            return in_array($feedId, $validatedData['feed_ids']);
        });
        $dateFrom = createDateFromStr($validatedData['date_from'], $dateFormat);
        $dateTill = createDateFromStr($validatedData['date_till'], $dateFormat);

        $foundFeedItemIdsFromIndex = FeedItem::search($request->get('term'))
            ->orderBy('posted_at', 'desc')
            ->keys();

        $foundFeedItemsFromIndex = FeedItem::keywordFiltered(auth()->user())
            ->whereIn('id', $foundFeedItemIdsFromIndex)
            ->whereIn('feed_id', $allFeedIds)
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('posted_at', '>=', $dateFrom);
            })
            ->when($dateTill, function ($query) use ($dateTill) {
                $query->whereDate('posted_at', '<=', $dateTill);
            })
            ->paginate($this->getPerPage());

        return view('feed.search_result', ['feeds' => $feeds, 'foundFeedItemsFromIndex' => $foundFeedItemsFromIndex, 'feedIds' => $selectedFeedIds]);
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

    public function toggleFavorite(Request $request, FeedItem $feedItem)
    {
        $this->authorize('favorite', $feedItem);

        if (empty($feedItem->favorited_at)) {
            $feedItem->favorited_at = now();
        } else {
            $feedItem->favorited_at = null;
        }

        $feedItem->save();

        if ($request->ajax()) {
            return response()->json(['favorited_at' => $feedItem->favorited_at]);
        }

        flash(__('feed.toggle_favorite.success'))->success();

        return redirect()->back();
    }

    private function baseIndex($categoryId = null)
    {
        $unreadFeedItemsBase = $this->getUnreadFeedItems($categoryId);

        $totalCountUnreadFeedItems = $categoryId == null ? $unreadFeedItemsBase->count() : $this->getUnreadFeedItems()->count();
        $unreadFeedItems = $unreadFeedItemsBase->paginate($this->getPerPage());

        $categories = auth()->user()->categories()->with(['feeds' => function ($query) {
            return $query->withCount(['feedItems' => function ($query) {
                return $query->unread()->keywordFiltered(auth()->user());
            }]);
        }])->get();

        $categories = $categories->map(function (Category $category) {
            $total_feed_items_count = $category->feeds->reduce(function ($carry, Feed $feed) {
                return $carry + $feed->feed_items_count;
            }, 0);

            $category->total_feed_items_count = $total_feed_items_count;

            return $category;
        });

        $currentCategoryId = $categoryId;
        $latestUpdateLog = UpdateLog::orderBy('created_at', 'desc')->first();

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

        $feedItems = auth()->user()->feedItems()->unread()->whereIn('feed_id', $feedIds)->keywordFiltered(auth()->user())->with('categories');

        return $feedItems;
    }

    private function getFeedsForSelect()
    {
        return auth()->user()->categories()->with('feeds')->get()->map(function (Category $category) {
            return [
                'title' => $category->title,
                'subEntries' => $category->feeds()->orderBy('title')->get()->map(function (Feed $feed) {
                    return [
                        'id' => $feed->id,
                        'title' => $feed->title,
                    ];
                })->toArray()
            ];
        })->toArray();
    }

    private function getPerPage()
    {
        return auth()->user()->settings()->get('feed_items.per_page');
    }
}
