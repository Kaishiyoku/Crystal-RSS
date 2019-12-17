<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_administrator
 * @property int $is_active
 * @property string|null $new_email
 * @property string|null $new_email_token
 * @property string $api_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Feed[] $enabledFeeds
 * @property-read int|null $enabled_feeds_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FeedItemCategory[] $feedItemCategories
 * @property-read int|null $feed_item_categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Feed[] $feeds
 * @property-read int|null $feeds_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReportFeedItem[] $reportFeedItems
 * @property-read int|null $report_feed_items_count
 * @property-write mixed $raw
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UpdateError[] $updateErrors
 * @property-read int|null $update_errors_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User administrator()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsAdministrator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNewEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNewEmailToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'is_active', 'is_administrator'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAdministrator($query)
    {
        return $query->where('is_administrator', true);
    }

    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    public function enabledFeeds()
    {
        return $this->hasMany(Feed::class)->whereIsEnabled(true);
    }

    public function feedItems($withOrder = true)
    {
        $data = $this->hasMany(FeedItem::class);

        if ($withOrder) {
            $data = $data->orderBy('read_at', 'desc')->orderBy('posted_at', 'desc');
        }

        return $data;
    }

    public function categories()
    {
        return $this->hasMany(Category::class)->orderBy('title');
    }

    public function updateErrors()
    {
        return $this->hasMany(UpdateError::class)->orderBy('created_at', 'desc');
    }

    public function feedItemCategories()
    {
        return $this->hasMany(FeedItemCategory::class)->orderBy('title');
    }

    public function reportFeedItems()
    {
        return $this->hasMany(ReportFeedItem::class)->orderBy('date')->orderBy('date');
    }
}
