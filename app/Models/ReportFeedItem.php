<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReportFeedItem
 *
 * @property int $id
 * @property int $user_id
 * @property int $total_count
 * @property int $read_count
 * @property \Illuminate\Support\Carbon $date
 * @property-write mixed $raw
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReportFeedItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReportFeedItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReportFeedItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReportFeedItem whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReportFeedItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReportFeedItem whereReadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReportFeedItem whereTotalCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReportFeedItem whereUserId($value)
 * @mixin \Eloquent
 */
class ReportFeedItem extends Model
{
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
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
