<?php

namespace App\Models;

use App\Enums\VoteStatus;
use App\Models\Extensions\ColoredModel;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property bool $is_valid
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FeedItem[] $feedItems
 * @property-read int|null $feed_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReportFeed[] $reportFeeds
 * @property-read int|null $report_feeds_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UpdateError[] $updateErrors
 * @property-read int|null $update_errors_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Feed enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed invalidAndEnabled()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed newQuery()
 * @method static \Illuminate\Database\Query\Builder|Feed onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereFeedUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereIsValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereLastCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereSiteUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feed whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Feed withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Feed withoutTrashed()
 * @mixin \Eloquent
 */
class Feed extends ColoredModel
{
    use SoftDeletes;

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
        'is_valid' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_checked_at'
    ];

    public function scopeEnabled($query)
    {
        return $query->whereIsEnabled(true);
    }

    public function scopeInvalidAndEnabled($query)
    {
        return $query->where('is_valid', false)->where('is_enabled', true);
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

    public function reportFeeds()
    {
        return $this->hasMany(ReportFeed::class);
    }
}
