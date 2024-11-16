<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens; , HasApiTokens

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'tbl_users';
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function djCharts()
    {
        return $this->hasMany(DjCharts::class, 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscriptions::class, 'user_id');
    }
    public function subscriptions_history()
    {
        return $this->hasMany(UserSubscriptionsHistory::class, 'user_id');
    }

    public function download_request()
    {
        return $this->hasMany(AddDownloadRequest::class, 'user_id', 'id');
    }

    public function streamboxes()
    {
        return $this->hasMany(Streambox::class, 'user_id', 'id');
    }

    public function mobile_token()
    {
        return $this->hasOne(UsersMobileToken::class, 'user_id');
    }

    public function likedTracks()
    {
        return $this->hasMany(Follow::class)->where('type', 'track');
    }

    public function artists()
    {
        return $this->hasMany(TrackArtists::class)->where('artist_id', 'id');
    }

    // public function tracks()
    // {
    //     return $this->belongsToMany(Mp3Mix::class, 'tbl_track_artists', 'artist_id', 'track_id');
    // }

    public function tracks()
    {
        return $this->belongsToMany(
            Mp3Mix::class,
            'tbl_track_artists',
            'artist_id',
            'track_id'
        )->wherePivot('type', 1);
    }

    public function genres()
    {
        return $this->hasMany(UserGenres::class);
    }

    public function mp3Statistics()
    {
        return $this->hasMany(Mp3Statistics::class, 'user_id');
    }

    public function mp3Mixes()
    {
        return $this->hasMany(Mp3Mix::class, 'user_id');
    }

    public function releases()
    {
        return $this->hasMany(Release::class, 'user_id');
    }

    public static function getUserById($id)
    {
        return self::find($id);
    }

    //parent_label_id response_id
}
