<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UpdateError
 *
 * @property int $id
 * @property int $user_id
 * @property int $feed_id
 * @property string $content
 * @property \Carbon\Carbon|null $created_at
 * @property-read \App\Models\Feed $feed
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UpdateError whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UpdateError whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UpdateError whereFeedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UpdateError whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UpdateError whereUserId($value)
 * @mixin \Eloquent
 */
class UpdateError extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function setUpdatedAt($value)
    {
        //
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
