<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'theme_id',
        'name',
        'image',
        'designation',
        'full_name',
        'cover_image',
        'bio',
        'email',
        'password',
        'address',
        'phone',
        'country_code',
        'website',
        'phone_visibility'
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function theme()
    {
        return $this->hasOne(Theme::class);
    }
    public function links()
    {
        return $this->hasMany(Link::class);
    }
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
    public function medias()
    {
        return $this->hasMany(Media::class);
    }
}
