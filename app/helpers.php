<?php

use App\Models\FeedItem;
use App\Models\User;
use Illuminate\Support\Collection;
const DATETIME = 'datetime';
const DATE = 'date';
const DATE_WITH_DAY_OF_WEEK = 'date_with_day_of_week';

if (! function_exists('l')) {
    function l($type) {
        return __('common.date_formats.' . $type);
    }
}

if (! function_exists('getYearsFrom')) {
    function getYearsFrom($year)
    {
        return $year < date('Y') ? $year . '-' . date('Y') : date('Y');
    }
}

if (! function_exists('getUnreadFeedItemCountForCategory')) {
    function getUnreadFeedItemCountForCategory($category)
    {
        return $category->feeds()->withCount(['feedItems' => function ($query) {
            return $query->unread();
        }])->get()->map(function ($a) { return $a->feed_items_count; })->sum();
    }
}

if (! function_exists('getPageRanges')) {
    function getPageRanges($currentPage, $lastPage)
    {
        $pageOffset = env('PAGINATION_PAGE_OFFSET');
        $numberOfPages = $pageOffset + 1;
        $maxOverflow = env('PAGINATION_MAX_OVERFLOW');
        $numberOfPagesWithMaxOverflow = $numberOfPages + $maxOverflow;
        $ranges = [];

        $leftStart = 1;
        $leftEnd = $numberOfPages;

        if ($currentPage >= $leftEnd) {
            if ($currentPage <= $leftEnd + $maxOverflow) {
                $leftEnd = $currentPage + 1;
            } else {
                $leftEnd = 1;
            }
        }

        $leftEnd = $leftEnd <= $lastPage ? $leftEnd : $lastPage;

        $ranges[] = [
            'start' => $leftStart,
            'end' => $leftEnd
        ];

        if ($currentPage > $numberOfPagesWithMaxOverflow && $currentPage <= $lastPage - $numberOfPagesWithMaxOverflow) {
            $middleStart = $currentPage - $pageOffset;
            $middleEnd = $currentPage + $pageOffset;

            if ($middleStart > 0) {
                $ranges[] = [
                    'start' => $middleStart,
                    'end' => $middleEnd
                ];
            }
        }

        $rightStart = $lastPage - $numberOfPages + 1;
        $rightEnd = $lastPage;

        if ($currentPage <= $rightStart) {
            if ($currentPage >= $rightStart - $maxOverflow) {
                $rightStart = $currentPage - 1;
            } else {
                $rightStart = $lastPage;
            }
        }

        if ($leftEnd < $rightStart) {
            $ranges[] = [
                'start' => $rightStart,
                'end' => $rightEnd
            ];
        }

        return $ranges;
    }
}

if (! function_exists('formatBoolean')) {
    function formatBoolean($bool)
    {
        if ($bool == true || $bool == 1) {
            $str = __('common.lists.boolean.1');
        } else {
            $str = __('common.lists.boolean.0');
        }

        return $str;
    }
}


if (! function_exists('upper')) {
    function upper($string) {
        return \Illuminate\Support\Str::upper($string);
    }
}

if (! function_exists('itemIf')) {
    function itemIf($item, $isVisible, $default = null) {
        return $isVisible ? $item : $default;
    }
}

if (! function_exists('removeNulls')) {
    function removeNulls(array $arr) {
        return array_filter($arr, function ($item) {
            return $item != null;
        });
    }
}

if (! function_exists('syncFeedItemCategories')) {
    function syncFeedItemCategories(Collection $categoryTitles, User $user, FeedItem $feedItem)
    {
        $categoryIds = [];

        $categoryTitles->each(function ($categoryTitle) use ($user) {
            $currentCategory = $user->feedItemCategories()->whereTitle($categoryTitle)->first();

            // if category currently doesn't exist, create it
            if ($currentCategory == null) {
                $newCategory = new \App\Models\FeedItemCategory();
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
     * @param string $str
     * @return \Illuminate\Support\Carbon
     */
    function createDateFromStr($str)
    {
        try {
            return \Illuminate\Support\Carbon::createFromFormat(__('common.date_formats.date'), $str)->startOfDay();
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }
}
