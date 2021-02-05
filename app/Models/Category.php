<?php

namespace App\Models;

use App\Models\Extensions\ColoredModel;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $color
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Feed[] $feeds
 * @property-read int|null $feeds_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUserId($value)
 * @mixin \Eloquent
 */
class Category extends ColoredModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'color',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    public function getTotalFeedItemsCount()
    {
        return $this->feeds->map(function (Feed $feed) {
            return $feed->reportFeeds->sum('feed_items_count');
        })->sum();
    }

    public function getTotalUpVoteCount()
    {
        return $this->feeds->map(function (Feed $feed) {
            return $feed->reportFeeds->sum('upvotes');
        })->sum();
    }

    public function getTotalDownVoteCount()
    {
        return $this->feeds->map(function (Feed $feed) {
            return $feed->reportFeeds->sum('downvotes');
        })->sum();
    }
}
