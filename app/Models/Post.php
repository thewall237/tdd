<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    const OPEN = 1;
    const CLOSED = 0;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeOnlyOpen($query)
    {
        $query->where('status', self::OPEN);
    }

    public function isClosed(): bool
    {
        return $this->status == self::CLOSED;
    }
}
