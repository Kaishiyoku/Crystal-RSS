<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FeedItemDetail
 *
 * @property int $feed_item_id
 * @property string $content
 * @property string|null $raw_json
 * @method static \Illuminate\Database\Eloquent\Builder|FeedItemDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeedItemDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeedItemDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|FeedItemDetail whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeedItemDetail whereFeedItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeedItemDetail whereRawJson($value)
 * @mixin \Eloquent
 */
class FeedItemDetail extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'feed_item_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
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

    public function getJson()
    {
        return json_decode($this->raw_json);
    }

    private function feedItem()
    {
        return $this->belongsTo(FeedItem::class);
    }
}
