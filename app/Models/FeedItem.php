<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\Models\FeedItem
 *
 * @property int $id
 * @property int $user_id
 * @property int $feed_id
 * @property int $is_read
 * @property string $url
 * @property string $title
 * @property string $author
 * @property string $content
 * @property string|null $image_url
 * @property \Carbon\Carbon|null $date
 * @property-read \App\Models\Feed $feed
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem read()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem unread()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereFeedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereUserId($value)
 * @mixin \Eloquent
 * @property string $checksum
 * @property string|null $read_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereChecksum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereReadAt($value)
 */
class FeedItem extends Model
{
    use Searchable;

    public $asYouType = true;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // TODO: Customize array

        return $array;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'checksum', 'user_id', 'feed_id'
    ];

    protected $dates = [
        'date'
    ];

    protected $casts = [
        'is_read' => 'boolean'
    ];

    public $timestamps = false;

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
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
