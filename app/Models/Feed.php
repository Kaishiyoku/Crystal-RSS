<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Feed
 *
 * @property int $id
 * @property int $user_id
 * @property string $feed_url
 * @property string $title
 * @property string $last_checked_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereFeedUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereLastCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereUserId($value)
 * @mixin \Eloquent
 * @property string $site_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereSiteUrl($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FeedItem[] $feedItems
 * @property int|null $category_id
 * @property-read \App\Models\Category|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereCategoryId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UpdateError[] $updateErrors
 * @property bool $is_enabled
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed query()
 * @property string|null $color
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feed whereColor($value)
 */
class Feed extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedItems()
    {
        return $this->hasMany(FeedItem::class)->orderBy('read_at', 'desc')->orderBy('date', 'desc');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function updateErrors()
    {
        return $this->hasMany(UpdateError::class)->orderBy('created_at', 'desc');
    }

    public function getColor()
    {
        return $this->color ?? 'inherit';
    }
}
