<?php

namespace App\Models;

use Glorand\Model\Settings\Traits\HasSettingsTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_administrator
 * @property int $is_active
 * @property string|null $new_email
 * @property string|null $new_email_token
 * @property string|null $api_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FeedItemCategory[] $feedItemCategories
 * @property-read int|null $feed_item_categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Feed[] $feeds
 * @property-read int|null $feeds_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FilterKeyword[] $filterKeywords
 * @property-read int|null $filter_keywords_count
 * @property-read \Glorand\Model\Settings\Models\ModelSettings|null $modelSettings
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReportFeedItem[] $reportFeedItems
 * @property-read int|null $report_feed_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReportFeed[] $reportFeeds
 * @property-read int|null $report_feeds_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UpdateError[] $updateErrors
 * @property-read int|null $update_errors_count
 * @method static \Illuminate\Database\Eloquent\Builder|User active()
 * @method static \Illuminate\Database\Eloquent\Builder|User administrator()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdministrator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNewEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNewEmailToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasSettingsTable;

    public function getDefaultSettings(): array
    {
        return [
            'feed_items' => [
                'per_page' => config('app.feed_items_per_page'),
                'mark_duplicates_as_read_automatically' => config('app.feed_items_mark_duplicates_as_read_automatically'),
            ],
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token',
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
        return $this->hasMany(ReportFeedItem::class)->orderBy('date');
    }

    public function reportFeeds()
    {
        return $this->hasMany(ReportFeed::class);
    }

    public function filterKeywords()
    {
        return $this->hasMany(FilterKeyword::class)->orderBy('value');
    }
}
