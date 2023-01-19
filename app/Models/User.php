<?php

namespace App\Models;

use App\Traits\TelerikGridFilters;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Proposals\Entities\Proposal;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use hasRoles, HasApiTokens, HasFactory, Notifiable,TelerikGridFilters;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    protected $appends = ['role'];

    public function userable()
    {
        return $this->morphTo();
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'created_by');
    }

    public function getRoleAttribute()
    {
        return $this->roles()->first();
    }
}
