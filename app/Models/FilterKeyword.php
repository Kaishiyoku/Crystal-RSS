<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FilterKeyword
 *
 * @property int $id
 * @property int $user_id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|FilterKeyword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterKeyword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterKeyword query()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterKeyword whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterKeyword whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterKeyword whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterKeyword whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterKeyword whereValue($value)
 * @mixin \Eloquent
 */
class FilterKeyword extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
