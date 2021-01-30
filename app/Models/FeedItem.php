<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\Models\FeedItem
 *
 * @property int $id
 * @property int $user_id
 * @property int $feed_id
 * @property string $url
 * @property string $title
 * @property string|null $author
 * @property string|null $content
 * @property string|null $image_url
 * @property \Illuminate\Support\Carbon|null $posted_at
 * @property string $checksum
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property string|null $raw_json
 * @property string $vote_status
 * @property \Illuminate\Support\Carbon|null $favorited_at
 * @property \Illuminate\Support\Carbon|null $hidden_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FeedItemCategory[] $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\Feed $feed
 * @property-read \App\Models\User $user
 * @method static Builder|FeedItem favorited()
 * @method static Builder|FeedItem includesKeywords($user)
 * @method static Builder|FeedItem newModelQuery()
 * @method static Builder|FeedItem newQuery()
 * @method static Builder|FeedItem query()
 * @method static Builder|FeedItem read()
 * @method static Builder|FeedItem unfavorited()
 * @method static Builder|FeedItem unhidden()
 * @method static Builder|FeedItem unread()
 * @method static Builder|FeedItem whereAuthor($value)
 * @method static Builder|FeedItem whereChecksum($value)
 * @method static Builder|FeedItem whereContent($value)
 * @method static Builder|FeedItem whereFavoritedAt($value)
 * @method static Builder|FeedItem whereFeedId($value)
 * @method static Builder|FeedItem whereHiddenAt($value)
 * @method static Builder|FeedItem whereId($value)
 * @method static Builder|FeedItem whereImageUrl($value)
 * @method static Builder|FeedItem wherePostedAt($value)
 * @method static Builder|FeedItem whereRawJson($value)
 * @method static Builder|FeedItem whereReadAt($value)
 * @method static Builder|FeedItem whereTitle($value)
 * @method static Builder|FeedItem whereUrl($value)
 * @method static Builder|FeedItem whereUserId($value)
 * @method static Builder|FeedItem whereVoteStatus($value)
 * @mixin \Eloquent
 */
class FeedItem extends Model
{
    public $timestamps = false;

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
        'checksum', 'feed_id',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
        'read_at' => 'datetime',
        'favorited_at' => 'datetime',
        'hidden_at' => 'datetime',
    ];

    public const COMMON_COLUMNS = [
        'id',
        'user_id',
        'feed_id',
        'url',
        'title',
        'author',
        'image_url',
        'posted_at',
        'checksum',
        'read_at',
        'vote_status',
        'favorited_at',
        'hidden_at'
    ];

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeFavorited($query)
    {
        return $query->whereNotNull('favorited_at');
    }

    public function scopeUnfavorited($query)
    {
        return $query->whereNull('favorited_at');
    }

    public function scopeUnhidden(Builder $query)
    {
        return $query->whereNull('hidden_at');
    }

    public function scopeIncludesKeywords(Builder $query, $user)
    {
        $filterKeywords = $user->filterKeywords;

        $filterKeywords->each(function (FilterKeyword $filterKeyword, $i) use ($query) {
            $queryMethod = $i === 0 ? 'where' : 'orWhere';

            $query->{$queryMethod}('title', 'like', '%' . $filterKeyword->value . '%');
        });

        return $query;
    }

    public function getJson()
    {
        return json_decode($this->raw_json);
    }

    public function isDuplicate()
    {
        return $this->getFirstFeedItemForDuplicates()->id !== $this->id;
    }

    public function hasDuplicates()
    {
        return $this->getDuplicates()->count() > 0;
    }

    public function getDuplicates()
    {
        $firstFeedItemId = $this->getFirstFeedItemForDuplicates()->id;

        return $this->getDuplicateBaseQuery()->whereNotIn('id', [$this->id, $firstFeedItemId])->get();
    }

    public function getFirstItemOfDuplicates()
    {
        return $this->getFirstFeedItemForDuplicates();
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

    private function getDuplicateBaseQuery()
    {
        return FeedItem::whereUserId($this->user_id)->whereFeedId($this->feed_id)->whereUrl($this->url);
    }

    private function getFirstFeedItemForDuplicates()
    {
        return $this->getDuplicateBaseQuery()->orderBy('posted_at', 'asc')->first();
    }
}
