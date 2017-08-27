<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedItem extends Model
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

    protected $dates = [
        'date'
    ];

    public $timestamps = false;

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
