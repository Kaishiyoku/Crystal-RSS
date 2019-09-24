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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem query()
 * @property string|null $raw_json
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereRawJson($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FeedItemCategory[] $categories
 * @property string $vote_status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereVoteStatus($value)
 * @property-read int|null $categories_count
 */
class FeedItem extends Model
{
    use Searchable;

    public $asYouType = false;

    protected $searchableFields = [
        'id',
        'user_id',
        'feed_id',
        'url',
        'title',
        'author',
        'content',
        'date',
        'read_at',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $list = collect($this->toArray());

        return $list->only($this->searchableFields)->toArray();
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
        'checksum', 'user_id', 'feed_id',
    ];

    protected $dates = [
        'date',
        'read_at',
    ];

    protected $casts = [

    ];

    public $timestamps = false;

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function getJson()
    {
        return json_decode($this->raw_json);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

    public function categories()
    {
        return $this->belongsToMany(FeedItemCategory::class);
    }
}
