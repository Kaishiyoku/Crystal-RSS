<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UpdateLog
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $created_at
 * @property int $duration_in_seconds
 * @method static \Illuminate\Database\Eloquent\Builder|UpdateLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UpdateLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UpdateLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|UpdateLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UpdateLog whereDurationInSeconds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UpdateLog whereId($value)
 * @mixin \Eloquent
 */
class UpdateLog extends Model
{
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

    ];

    public function setUpdatedAt($value)
    {
        return $this;
    }
}
