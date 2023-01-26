<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'created_at', 'updated_at'];
    protected $guarded = ['id'];

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

}