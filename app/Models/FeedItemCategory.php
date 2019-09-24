<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\Models\FeedItemCategory
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FeedItemCategory[] $categories
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItemCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItemCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItemCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItemCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItemCategory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FeedItemCategory whereUserId($value)
 * @mixin \Eloquent
 * @property-read int|null $categories_count
 */
class FeedItemCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(FeedItemCategory::class);
    }
}
