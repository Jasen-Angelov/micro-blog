<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $fillable = ['title', 'content', 'slug', 'user_id', 'image_id', 'created_at', 'updated_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function image(): HasOne
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function delete()
    {
        $this->image()->delete();

        return parent::delete();
    }
}