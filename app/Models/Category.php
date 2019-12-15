<?php

namespace App\Models;

use App\Models\Extensions\ColoredModel;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Feed[] $feeds
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @property string|null $color
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereColor($value)
 * @property-read int|null $feeds_count
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

    public function getTotalFeedCount()
    {
        return $this->feeds->map(function (Feed $feed) {
            return $feed->feedItems()->count();
        })->sum();
    }

    public function getTotalUpVoteCount()
    {
        return $this->feeds->map(function (Feed $feed) {
            return $feed->getTotalUpVoteCount();
        })->sum();
    }

    public function getTotalDownVoteCount()
    {
        return $this->feeds->map(function (Feed $feed) {
            return $feed->getTotalDownVoteCount();
        })->sum();
    }
}
