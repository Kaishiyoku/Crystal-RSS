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
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeedItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeedItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeedItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeedItem whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeedItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeedItem whereReadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeedItem whereTotalCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportFeedItem whereUserId($value)
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
