<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
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
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'role_id'
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
     * Roles const
     */

    public const SUPERADMIN = 1;
    public const ADMIN = 2;
    public const USER = 3;

    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }

    public function role(){
        return $this->hasOne(Role::class);
    }

    public function assignedDomains(){
        return $this->belongsToMany(Domain::class, 'admin_domains')->where('role_id', self::ADMIN);
    }

    public function scopeIsSuperAdmin($query){
        return $query->where('role_id', self::SUPERADMIN);
    }

    public function isAdmin(){
        return $this->where('role_id', self::ADMIN);
    }

    public function domains(){
        return $this->belongsToMany(Domain::class, 'admin_domains','user_id','domain_id','id','id');
    }
}
