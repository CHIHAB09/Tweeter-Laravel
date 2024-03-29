<?php

namespace App\Models;

use App\Models\User;
use App\Models\Tweet;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function tweets()
    {
        //methode hasMany() car il y aura plusieur tweet et on decide de les afficher par ordre de creation
        //+ recent au + ancien 
        return $this->hasMany(Tweet::class)->orderBy('created_at','DESC');
    }


    public function followings ()
    {
        return $this->belongsToMany(
            User::class,
            'followings',
            'follower_id',
            'following_id'

        );
    }

    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'followings',
            'following_id',
            'follower_id'
        );
    }

}