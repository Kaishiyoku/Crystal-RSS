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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilterKeyword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilterKeyword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilterKeyword query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilterKeyword whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilterKeyword whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilterKeyword whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilterKeyword whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilterKeyword whereValue($value)
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
