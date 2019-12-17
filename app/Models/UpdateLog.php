<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UpdateLog
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $created_at
 * @property int $duration_in_seconds
 * @property-write mixed $raw
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UpdateLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UpdateLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UpdateLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UpdateLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UpdateLog whereDurationInSeconds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UpdateLog whereId($value)
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
        //
    }
}
