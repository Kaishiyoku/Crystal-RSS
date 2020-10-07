<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReportFeed
 *
 * @property int $id
 * @property int $user_id
 * @property int $feed_id
 * @property int $feed_items_count
 * @property int $upvotes
 * @property int $downvotes
 * @property-read \App\Models\Feed $feed
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeed query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeed whereDownvotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeed whereFeedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeed whereFeedItemsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeed whereUpvotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeed whereUserId($value)
 * @mixin \Eloquent
 */
class ReportFeed extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    protected $casts = [
        //
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
