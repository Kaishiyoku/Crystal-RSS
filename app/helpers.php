<?php

use App\Jobs\ProcessMarkFeedItemAsHidden;
use App\Jobs\ProcessMarkFeedItemsAsHidden;
use App\Models\Category;
use App\Models\FeedItem;
use App\Models\FeedItemCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

const DATETIME = 'datetime';
const DATE = 'date';
const DATE_WITH_DAY_OF_WEEK = 'date_with_day_of_week';

if (! function_exists('l')) {
    function l(string $type): string {
        return __('common.date_formats.' . $type);
    }
}

if (! function_exists('getYearsFrom')) {
    function getYearsFrom(int $year): string
    {
        return $year < date('Y') ? $year . '-' . date('Y') : date('Y');
    }
}

if (! function_exists('getUnreadFeedItemCountForCategory')) {
    function getUnreadFeedItemCountForCategory(Category $category): int
    {
        return $category->feeds()->withCount(['feedItems' => function ($query) {
            return $query->unread();
        }])->get()->map(function ($a) { return $a->feed_items_count; })->sum();
    }
}

if (! function_exists('formatBoolean')) {
    function formatBoolean(bool $bool): string
    {
        if ($bool) {
            $str = __('common.lists.boolean.1');
        } else {
            $str = __('common.lists.boolean.0');
        }

        return $str;
    }
}

if (! function_exists('upper')) {
    function upper(string $string): string {
        return Str::upper($string);
    }
}

if (! function_exists('itemIf')) {
    function itemIf($item, bool $isVisible, $default = null) {
        return $isVisible ? $item : $default;
    }
}

if (! function_exists('removeNulls')) {
    function removeNulls(array $arr): array {
        return array_filter($arr, function ($item) {
            return $item !== null;
        });
    }
}

if (! function_exists('syncFeedItemCategories')) {
    function syncFeedItemCategories(Collection $categoryTitles, User $user, FeedItem $feedItem): void
    {
        $categoryIds = [];

        $categoryTitles->each(function ($categoryTitle) use ($user) {
            $currentCategory = $user->feedItemCategories()->whereTitle($categoryTitle)->first();

            // if category currently doesn't exist, create it
            if ($currentCategory === null) {
                $newCategory = new FeedItemCategory();
                $newCategory->title = $categoryTitle;

                $newCategory->user_id = $user->id;
                $newCategory->save();

                $user->feedItemCategories()->save($newCategory);

                $categoryIds[] = $newCategory->id;
            } else {
                $categoryIds[] = $currentCategory->id;
            }
        });

        $feedItem->categories()->sync($categoryIds);
    }
}

if (! function_exists('createDateFromStr')) {
    /**
     * @param string|null $str
     * @param string|null $format
     * @return Carbon|null
     */
    function createDateFromStr(?string $str, string $format = null): ?Carbon
    {
        try {
            return Carbon::createFromFormat($format ?? __('common.date_formats.date'), $str)->startOfDay();
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }
}

if (! function_exists('markFeedItemsAsHiddenByKeywords')) {
    function markFeedItemsAsHiddenByKeywords($user): int
    {
        $feedItems = $user->feedItems()->unhidden()->includesKeywords($user)->whereNull('hidden_at')->get();

        $feedItems->each(function (FeedItem $feedItem) {
            ProcessMarkFeedItemAsHidden::dispatch($feedItem);
        });

        return $feedItems->count();
    }
}
