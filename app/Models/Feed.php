<?php

namespace App\Models;

use App\Enums\VoteStatus;
use App\Models\Extensions\ColoredModel;

/**
 * App\Models\Feed
 *
 * @property int $id
 * @property int $user_id
 * @property string $feed_url
 * @property string $title
 * @property \Illuminate\Support\Carbon $last_checked_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $site_url
 * @property int|null $category_id
 * @property bool $is_enabled
 * @property string|null $color
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FeedItem[] $feedItems
 * @property-read int|null $feed_items_count
 * @property-write mixed $raw
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UpdateError[] $updateErrors
 * @property-read int|null $update_errors_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereFeedUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereLastCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereSiteUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereUserId($value)
 * @mixin \Eloquent
 * @property int $is_valid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereIsValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed invalid()
 */
class Feed extends ColoredModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'feed_url',
        'is_enabled',
        'color',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_checked_at'
    ];

    public function scopeInvalid($query)
    {
        return $query->where('is_valid', false);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedItems()
    {
        return $this->hasMany(FeedItem::class)->orderBy('read_at', 'desc')->orderBy('posted_at', 'desc');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function updateErrors()
    {
        return $this->hasMany(UpdateError::class)->orderBy('created_at', 'desc');
    }

    public function getTotalUpVoteCount()
    {
        return $this->feedItems()->whereVoteStatus(VoteStatus::Up)->count();
    }

    public function getTotalDownVoteCount()
    {
        return $this->feedItems()->whereVoteStatus(VoteStatus::Down)->count();
    }
}
