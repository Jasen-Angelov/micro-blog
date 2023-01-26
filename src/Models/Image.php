<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = ['name', 'path', 'created_at', 'updated_at'];

    public function blog():BelongsTo
    {
        $this->belongsTo(Blog::class, 'id', 'image_id');
    }
}