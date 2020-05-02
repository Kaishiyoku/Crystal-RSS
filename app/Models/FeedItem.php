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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FeedItemCategory[] $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\Feed $feed
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem favorited()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem keywordFiltered($user)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem read()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem unfavorited()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem unread()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereChecksum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereFavoritedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereFeedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem wherePostedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereRawJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItem whereVoteStatus($value)
 * @mixin \Eloquent
 */
class FeedItem extends Model
{
    use Searchable;

    public $asYouType = false;

    public $timestamps = false;

    protected $searchableFields = [
        'user_id',
        'url',
        'title',
        'author',
        'content',
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

    protected $casts = [
        'posted_at' => 'datetime',
        'read_at' => 'datetime',
        'favorited_at' => 'datetime',
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

    public function scopeKeywordFiltered(Builder $query, $user)
    {
        $filterKeywords = $user->filterKeywords;

        $filterKeywords->each(function (FilterKeyword $filterKeyword) use ($query) {
            $query->where('title', 'not like', '%' . $filterKeyword->value . '%');
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
