<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FeedItemCategory
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property-read \Illuminate\Database\Eloquent\Collection|FeedItemCategory[] $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|FeedItemCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeedItemCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeedItemCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|FeedItemCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeedItemCategory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeedItemCategory whereUserId($value)
 * @mixin \Eloquent
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
