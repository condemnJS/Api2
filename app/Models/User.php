<?php

namespace App\Models;

use App\Models\Traits\ResponseTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, ResponseTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function generateAccessToken()
    {
        $this->access_token = Hash::make(Str::random(40));
        $this->save();
        return $this->access_token;
    }

    public function generateRefreshToken() {
        $this->refresh_token = Hash::make(Str::random(40));
        $this->save();
        return $this->refresh_token;
    }

    public function lists() {
        return $this->belongsToMany(Listt::class, 'user_lists', 'user_id', 'list_id');
    }
}
