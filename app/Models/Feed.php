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
 */
class Feed extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'feed_url'
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
}
