<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'balance',
        'email',
        'password',
        'phone_number',
        'subscription_status',
        'last_login_at',
        'referral_code',
        'referred_by',
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
        'password' => 'hashed',
    ];

    /**
     * Get the user's referrals.
     *
     * @return HasMany
     */

    public function referrals(): HasMany
    {
        //return all users that have this user as their referrer
        return $this->hasMany(User::class, 'referred_by', 'referral_code');
    }

    /**
     * Get the user's referrer.
     *
     * @return BelongsTo
     */

    public function referrer(): BelongsTo
    {
        //return the user that referred this user
        return $this->belongsTo(User::class, 'referral_code', 'referred_by');
    }

    public function isAdmin(): bool
    {
        return $this->email == 'tomsteve187@gmail.com';
    }
}
