<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'name',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function babies(): HasMany
    {
        return $this->hasMany(Baby::class, 'parent_id');
    }

    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class, 'parent_id');
    }

    public function partners_baby(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(
            Baby::class,
            Partner::class,
            'partner_id',
            'parent_id',
            'id',
            'parent_id'
        );
    }
}
