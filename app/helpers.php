<?php

const DATETIME = 'datetime';

if (! function_exists('l'))
{
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
        return $category->feeds()->get()->map(function ($feed) { return $feed->feedItems()->unread()->count(); })->sum();
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


if (! function_exists('upper'))
{
    function upper($string) {
        return \Illuminate\Support\Str::upper($string);
    }
}

function itemIf($item, $isVisible, $default = null) {
    return $isVisible ? $item : $default;
}

function removeNulls(array $arr) {
    return array_filter($arr, function ($item) {
        return $item != null;
    });
}