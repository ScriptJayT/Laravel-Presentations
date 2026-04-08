<?php

namespace App\Models;

use App\Traits\CastUpdatedAtAsDiff;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use CastUpdatedAtAsDiff,
        HasFactory,
        HasRoles, Notifiable,
        TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    // ## Casting

    /**
     * transform existing attributes
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'created_at' => "date:d/m/'y",
        ];
    }

    // ## Relations

    public function presentationScripts(): HasMany
    {
        return $this->hasMany(PresentationScript::class)
            ->select('user_id', 'id', 'title');
    }

    public function presentations(): HasMany
    {
        return $this->hasMany(Presentation::class)
            ->select('user_id', 'id', 'title');
    }
}
